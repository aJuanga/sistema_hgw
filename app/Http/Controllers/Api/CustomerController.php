<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index(Request $request)
    {
        $query = Customer::with(['user', 'healthProfile']);

        // Filtrar por estado activo
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Buscar por nombre o email
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'ILIKE', '%' . $search . '%')
                  ->orWhere('email', 'ILIKE', '%' . $search . '%');
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $customers
        ]);
    }

    /**
     * Store a newly created customer
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id|unique:customers,user_id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'preferences' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Customer::create([
            'user_id' => $request->user_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'preferences' => $request->preferences,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente creado exitosamente',
            'data' => $customer->load('user')
        ], 201);
    }

    /**
     * Display the specified customer
     */
    public function show($id)
    {
        $customer = Customer::with([
            'user',
            'healthProfile.diseases',
            'healthProfile.allergies',
            'orders' => function($query) {
                $query->orderBy('created_at', 'desc')->limit(5);
            }
        ])->find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customer
        ]);
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'preferences' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $customer->update([
            'phone' => $request->phone ?? $customer->phone,
            'address' => $request->address ?? $customer->address,
            'date_of_birth' => $request->date_of_birth ?? $customer->date_of_birth,
            'preferences' => $request->preferences ?? $customer->preferences,
            'is_active' => $request->is_active ?? $customer->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado exitosamente',
            'data' => $customer->load('user')
        ]);
    }

    /**
     * Remove the specified customer (soft delete)
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        // Desactivar en lugar de eliminar
        $customer->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente desactivado exitosamente'
        ]);
    }
}