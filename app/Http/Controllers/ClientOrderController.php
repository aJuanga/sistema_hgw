<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\Inventory;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientOrderController extends Controller
{
    public function cart()
    {
        $cart = session()->get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::with('category')->find($productId);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                    'customizations' => $item['customizations'] ?? []
                ];
                $total += $product->price * $item['quantity'];
            }
        }

        return view('client.cart', compact('products', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'customizations' => 'nullable|array'
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_available) {
            return back()->with('error', 'El producto no está disponible');
        }

        $cart = session()->get('cart', []);

        $customizations = [];
        if ($request->has('customizations')) {
            foreach ($request->customizations as $key => $value) {
                $customizations[$key] = $value;
            }
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
            if (!empty($customizations)) {
                $cart[$product->id]['customizations'] = $customizations;
            }
        } else {
            $cart[$product->id] = [
                'quantity' => $request->quantity,
                'customizations' => $customizations
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Producto agregado al carrito');
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('client.cart')->with('success', 'Carrito actualizado');
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        return redirect()->route('client.cart')->with('success', 'Producto eliminado del carrito');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('client.cart')->with('error', 'Tu carrito está vacío');
        }

        $products = [];
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::with('category')->find($productId);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity']
                ];
                $subtotal += $product->price * $item['quantity'];
            }
        }

        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        $tax = $subtotal * 0.13; // 13% de impuesto
        $total = $subtotal + $tax;

        return view('client.checkout', compact('products', 'subtotal', 'tax', 'total', 'paymentMethods'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'delivery_type' => 'required|in:para_llevar,consumir_local',
            'notes' => 'nullable|string|max:500'
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('client.cart')->with('error', 'Tu carrito está vacío');
        }

        DB::beginTransaction();

        try {
            // Calcular totales
            $subtotal = 0;
            $total_preparation_time = 0;
            $items_data = [];

            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);
                
                if (!$product) {
                    throw new \Exception("Producto con ID {$productId} no encontrado");
                }

                if (!$product->is_available) {
                    throw new \Exception("El producto '{$product->name}' no está disponible");
                }

                // Verificar inventario
                $inventory = Inventory::where('product_id', $productId)->first();
                if ($inventory && $inventory->current_stock < $item['quantity']) {
                    throw new \Exception("No hay suficiente stock para '{$product->name}'");
                }

                $item_total = $product->price * $item['quantity'];
                $subtotal += $item_total;
                $total_preparation_time += ($product->preparation_time ?? 0) * $item['quantity'];

                $items_data[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $item_total,
                ];
            }

            $tax = $subtotal * 0.13;
            $total = $subtotal + $tax;

            // Generar número de orden único
            $date = now()->format('Ymd');
            $lastOrder = Order::whereDate('created_at', today())
                ->orderBy('id', 'desc')
                ->first();

            $sequence = $lastOrder ? (intval(substr($lastOrder->order_number, -4)) + 1) : 1;
            $orderNumber = 'ORD-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

            // Crear orden
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id(),
                'payment_method_id' => $request->payment_method_id,
                'delivery_type' => $request->delivery_type,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'status' => 'pendiente',
                'estimated_time' => $total_preparation_time,
                'notes' => $request->notes,
            ]);

            // Otorgar puntos de fidelización (1 punto por cada 10 Bs)
            try {
                $pointsEarned = floor($total / 10);
                if ($pointsEarned > 0) {
                    // Verificar si la tabla existe antes de insertar
                    if (\Illuminate\Support\Facades\Schema::hasTable('loyalty_points')) {
                        LoyaltyPoint::create([
                            'user_id' => auth()->id(),
                            'order_id' => $order->id,
                            'points' => $pointsEarned,
                            'type' => 'earned',
                            'description' => 'Puntos ganados por pedido #' . $orderNumber,
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Si la tabla no existe, simplemente continuar sin puntos
            }

            // Crear items del pedido y actualizar inventario
            foreach ($items_data as $item) {
                $customizations = $cart[$item['product_id']]['customizations'] ?? [];
                $notes = '';
                
                if (!empty($customizations)) {
                    $product = Product::find($item['product_id']);
                    $customizationTexts = [];
                    if ($product && $product->customization_options) {
                        foreach ($product->customization_options as $index => $option) {
                            $key = 'customization_' . $item['product_id'] . '_' . $index;
                            if (isset($customizations[$key])) {
                                $customizationTexts[] = ($option['label'] ?? $option['name']) . ': ' . $customizations[$key];
                            }
                        }
                    }
                    $notes = implode(', ', $customizationTexts);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                    'notes' => $notes,
                ]);

                // Actualizar inventario
                $inventory = Inventory::where('product_id', $item['product_id'])->first();
                if ($inventory) {
                    $inventory->decrement('current_stock', $item['quantity']);
                }
            }

            // Limpiar carrito
            session()->forget('cart');

            DB::commit();

            return redirect()->route('client.orders.show', $order)
                ->with('success', 'Pedido creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear el pedido: ' . $e->getMessage());
        }
    }

    public function myOrders()
    {
        try {
            $orders = Order::where('user_id', auth()->id())
                ->with(['orderItems.product', 'paymentMethod'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('client.orders', compact('orders'));
        } catch (\Exception $e) {
            return view('client.orders', ['orders' => collect([])])
                ->with('error', 'Error al cargar los pedidos: ' . $e->getMessage());
        }
    }

    public function showOrder(Order $order)
    {
        // Verificar que el pedido pertenezca al usuario autenticado
        if ($order->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver este pedido');
        }

        try {
            $order->load(['orderItems.product', 'paymentMethod']);
            
            // Intentar cargar historial solo si existe
            try {
                $order->load('statusHistory.changedBy');
            } catch (\Exception $e) {
                // Si no existe la tabla, continuar sin historial
            }
        } catch (\Exception $e) {
            return redirect()->route('client.orders')
                ->with('error', 'Error al cargar el pedido: ' . $e->getMessage());
        }

        return view('client.order-show', compact('order'));
    }

    public function storeRating(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        // Verificar que el pedido pertenece al usuario
        $order = Order::findOrFail($request->order_id);
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            // Verificar si la tabla existe
            if (!\Illuminate\Support\Facades\Schema::hasTable('product_ratings')) {
                return back()->with('error', 'El sistema de valoraciones no está disponible en este momento');
            }

            // Verificar que no haya una valoración previa para este producto en este pedido
            $existingRating = \App\Models\ProductRating::where('user_id', auth()->id())
                ->where('product_id', $request->product_id)
                ->where('order_id', $request->order_id)
                ->first();

            if ($existingRating) {
                return back()->with('error', 'Ya has valorado este producto en este pedido');
            }

            \App\Models\ProductRating::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'order_id' => $request->order_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            return back()->with('success', 'Valoración enviada exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar la valoración: ' . $e->getMessage());
        }
    }
}

