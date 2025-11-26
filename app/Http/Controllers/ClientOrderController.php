<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\Payment;
use App\Models\Inventory;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $stockWarnings = [];

        foreach ($cart as $productId => $item) {
            $product = Product::with('category')->find($productId);
            if ($product) {
                // Verificar stock disponible
                $inventory = Inventory::where('product_id', $productId)->first();
                $stockDisponible = $inventory ? $inventory->current_stock : null;
                
                if ($inventory && $stockDisponible < $item['quantity']) {
                    $stockWarnings[] = [
                        'product' => $product->name,
                        'stock_disponible' => $stockDisponible,
                        'cantidad_solicitada' => $item['quantity']
                    ];
                }

                $products[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                    'stock_disponible' => $stockDisponible
                ];
                $subtotal += $product->price * $item['quantity'];
            }
        }

        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        $tax = $subtotal * 0.13; // 13% de impuesto
        $total = $subtotal + $tax;

        // Generar QR para pagos
        $qrData = $this->generatePaymentQRData($total);
        $qrCodeSvg = QrCode::size(300)
            ->margin(2)
            ->generate($qrData);

        return view('client.checkout', compact('products', 'subtotal', 'tax', 'total', 'paymentMethods', 'qrCodeSvg', 'stockWarnings'));
    }

    /**
     * Generate payment QR data for Bolivian banking
     */
    private function generatePaymentQRData($amount)
    {
        // Datos bancarios estáticos para QR simple
        // En producción, esto debería venir de configuración
        $bankData = [
            'merchant' => 'Healthy Glow Wellness - HGW',
            'account' => '1234567890',
            'bank' => 'Banco Nacional de Bolivia',
            'account_type' => 'Caja de Ahorro',
            'holder' => 'HGW S.R.L.',
            'amount' => number_format($amount, 2, '.', ''),
            'currency' => 'BOB',
            'timestamp' => now()->toIso8601String(),
        ];

        // Formato simple para QR (puede ser adaptado según el estándar bancario boliviano)
        return json_encode($bankData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Generate QR code image
     */
    public function generateQR(Request $request)
    {
        $amount = $request->input('amount', 0);
        $qrData = $this->generatePaymentQRData($amount);

        return response(QrCode::size(300)->margin(2)->generate($qrData))
            ->header('Content-Type', 'image/svg+xml');
    }

    public function processCheckout(Request $request)
    {
        try {
            $request->validate([
                'payment_method_id' => 'required|exists:payment_methods,id',
                'delivery_type' => 'required|in:para_llevar,consumir_local',
                'payment_status' => 'required|in:pendiente,pagado',
                'notes' => 'nullable|string|max:500'
            ], [
                'payment_method_id.required' => 'Debes seleccionar un método de pago',
                'payment_method_id.exists' => 'El método de pago seleccionado no es válido',
                'delivery_type.required' => 'Debes seleccionar un tipo de pedido',
                'delivery_type.in' => 'El tipo de pedido seleccionado no es válido',
                'payment_status.required' => 'Debes seleccionar el estado del pago',
                'payment_status.in' => 'El estado del pago seleccionado no es válido',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

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

                // Verificar inventario (solo registrar advertencia, no bloquear el pedido)
                // El pedido se puede crear aunque haya stock insuficiente
                // La advertencia ya se muestra en el checkout antes de confirmar

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

            // Crear registro de pago
            $paymentStatus = $request->payment_status === 'pagado' ? 'completado' : 'pendiente';
            Payment::create([
                'order_id' => $order->id,
                'payment_method_id' => $request->payment_method_id,
                'amount' => $total,
                'status' => $paymentStatus,
                'paid_at' => $request->payment_status === 'pagado' ? now() : null,
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

                // Actualizar inventario (solo si existe registro de inventario)
                $inventory = Inventory::where('product_id', $item['product_id'])->first();
                if ($inventory) {
                    // Descontar stock, permitiendo que quede en 0 si es necesario
                    // Esto permite que el pedido se procese incluso con stock insuficiente
                    $stockActual = $inventory->current_stock;
                    $cantidadADescontar = $item['quantity'];
                    $nuevoStock = max(0, $stockActual - $cantidadADescontar);
                    
                    $inventory->update(['current_stock' => $nuevoStock]);
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

