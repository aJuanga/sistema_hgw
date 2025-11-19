<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\EmployeePoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::join('inventory', 'products.id', '=', 'inventory.product_id')
            ->where('inventory.current_stock', '>', 0)
            ->select('products.*', 'inventory.current_stock')
            ->get();

        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Generate unique order number
            $date = now()->format('Ymd');
            $lastOrder = Order::whereDate('created_at', today())
                ->orderBy('id', 'desc')
                ->first();

            $sequence = $lastOrder ? (intval(substr($lastOrder->order_number, -4)) + 1) : 1;
            $orderNumber = 'ORD-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

            // Calculate totals
            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $subtotal += $product->price * $item['quantity'];
            }

            // Create order
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'order_number' => $orderNumber,
                'status' => 'pendiente',
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items and update inventory
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);

                // Update inventory stock
                $inventory = Inventory::where('product_id', $item['product_id'])->first();
                if ($inventory) {
                    $inventory->decrement('current_stock', $item['quantity']);
                }
            }

            // Asignar puntos al empleado si es empleado
            $currentUser = Auth::user();
            if ($currentUser && $currentUser->isEmpleado()) {
                // Calcular puntos: 1 punto por cada 10 Bs de venta
                $points = floor($subtotal / 10);
                // Cada punto equivale a 0.50 Bs
                $amount = $points * 0.50;

                EmployeePoint::create([
                    'user_id' => $currentUser->id,
                    'order_id' => $order->id,
                    'points' => $points,
                    'amount' => $amount,
                    'type' => 'earned',
                    'date' => today(),
                    'description' => "Pedido #{$orderNumber} - Bs. {$subtotal}",
                ]);
            }

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pedido creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        
        // Cargar historial solo si existe la tabla
        try {
            $order->load('statusHistory');
        } catch (\Exception $e) {
            // Si la tabla no existe, simplemente no cargar el historial
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // Cargar las relaciones necesarias
        $order->load(['user', 'orderItems.product']);

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pendiente,en_preparacion,listo,entregado,cancelado',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            $oldStatus = $order->status;

            $order->update([
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? $order->notes,
            ]);

            // Set completed_at if status changed to entregado
            if ($validated['status'] === 'entregado' && $oldStatus !== 'entregado') {
                $order->update(['completed_at' => now()]);
            }

            // Set cancelled_at and restore inventory if status changed to cancelado
            if ($validated['status'] === 'cancelado' && $oldStatus !== 'cancelado') {
                $order->update(['cancelled_at' => now()]);

                // Restore inventory stock
                foreach ($order->orderItems as $item) {
                    $inventory = Inventory::where('product_id', $item->product_id)->first();
                    if ($inventory) {
                        $inventory->increment('current_stock', $item->quantity);
                    }
                }
            }

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pedido actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        if (!in_array($order->status, ['pendiente', 'cancelado'])) {
            return redirect()->route('orders.index')
                ->with('error', 'Solo se pueden eliminar pedidos con estado pendiente o cancelado.');
        }

        DB::beginTransaction();

        try {
            // Restore inventory if order was pending
            if ($order->status === 'pendiente') {
                foreach ($order->orderItems as $item) {
                    $inventory = Inventory::where('product_id', $item->product_id)->first();
                    if ($inventory) {
                        $inventory->increment('current_stock', $item->quantity);
                    }
                }
            }

            $order->delete();

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Pedido eliminado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar el pedido: ' . $e->getMessage());
        }
    }
}
