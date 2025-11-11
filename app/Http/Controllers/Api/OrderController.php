<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product', 'paymentMethod']);

        // Filtrar por estado
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filtrar por usuario (para clientes que ven solo sus pedidos)
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filtrar por fecha
        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Calcular totales
            $subtotal = 0;
            $total_preparation_time = 0;
            $items_data = [];

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                if (!$product) {
                    throw new \Exception("Producto con ID {$item['product_id']} no encontrado");
                }

                if (!$product->is_available) {
                    throw new \Exception("El producto '{$product->name}' no está disponible");
                }

                $item_total = $product->price * $item['quantity'];
                $subtotal += $item_total;
                $total_preparation_time += $product->preparation_time * $item['quantity'];

                $items_data[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $item_total,
                ];
            }

            // Crear orden
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => $request->user_id,
                'payment_method_id' => $request->payment_method_id,
                'subtotal' => $subtotal,
                'tax' => 0, // Puedes calcular impuestos aquí si es necesario
                'total' => $subtotal,
                'status' => 'pendiente',
                'estimated_time' => $total_preparation_time,
                'notes' => $request->notes,
            ]);

            // Crear items del pedido
            foreach ($items_data as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pedido creado exitosamente',
                'data' => $order->load('orderItems.product', 'user', 'paymentMethod')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el pedido: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified order
     */
    public function show($id)
    {
        $order = Order::with([
            'user',
            'orderItems.product',
            'paymentMethod'
        ])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    /**
     * Update order status
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pendiente,en_preparacion,listo,entregado,cancelado',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $order->update([
            'status' => $request->status,
        ]);

        // Marcar hora de entrega si está entregado
        if ($request->status === 'entregado' && !$order->delivered_at) {
            $order->update(['delivered_at' => now()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Estado del pedido actualizado exitosamente',
            'data' => $order->load('orderItems.product')
        ]);
    }

    /**
     * Cancel order
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        // Solo se pueden cancelar pedidos pendientes o en preparación
        if (!in_array($order->status, ['pendiente', 'en_preparacion'])) {
            return response()->json([
                'success' => false,
                'message' => 'Solo se pueden cancelar pedidos pendientes o en preparación'
            ], 400);
        }

        $order->update(['status' => 'cancelado']);

        return response()->json([
            'success' => true,
            'message' => 'Pedido cancelado exitosamente'
        ]);
    }
}