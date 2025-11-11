<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthProfile;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HealthProfileController extends Controller
{
    /**
     * Display a listing of health profiles
     */
    public function index(Request $request)
    {
        $query = HealthProfile::with(['customer.user', 'diseases', 'allergies']);

        // Filtrar por customer_id
        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $profiles = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $profiles
        ]);
    }

    /**
     * Store a newly created health profile
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id|unique:health_profiles,customer_id',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'blood_type' => 'nullable|string|max:10',
            'health_goal' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'diseases' => 'nullable|array',
            'diseases.*' => 'exists:diseases,id',
            'allergies' => 'nullable|array',
            'allergies.*' => 'exists:allergies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Crear perfil de salud
            $profile = HealthProfile::create([
                'customer_id' => $request->customer_id,
                'weight' => $request->weight,
                'height' => $request->height,
                'blood_type' => $request->blood_type,
                'health_goal' => $request->health_goal,
                'additional_notes' => $request->additional_notes,
            ]);

            // Asociar enfermedades
            if ($request->has('diseases')) {
                $profile->diseases()->attach($request->diseases);
            }

            // Asociar alergias
            if ($request->has('allergies')) {
                $profile->allergies()->attach($request->allergies);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Perfil de salud creado exitosamente',
                'data' => $profile->load('customer.user', 'diseases', 'allergies')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el perfil de salud: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified health profile
     */
    public function show($id)
    {
        $profile = HealthProfile::with([
            'customer.user',
            'diseases',
            'allergies'
        ])->find($id);

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Perfil de salud no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $profile
        ]);
    }

    /**
     * Update the specified health profile
     */
    public function update(Request $request, $id)
    {
        $profile = HealthProfile::find($id);

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Perfil de salud no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'blood_type' => 'nullable|string|max:10',
            'health_goal' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'diseases' => 'nullable|array',
            'diseases.*' => 'exists:diseases,id',
            'allergies' => 'nullable|array',
            'allergies.*' => 'exists:allergies,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Actualizar perfil
            $profile->update([
                'weight' => $request->weight ?? $profile->weight,
                'height' => $request->height ?? $profile->height,
                'blood_type' => $request->blood_type ?? $profile->blood_type,
                'health_goal' => $request->health_goal ?? $profile->health_goal,
                'additional_notes' => $request->additional_notes ?? $profile->additional_notes,
            ]);

            // Sincronizar enfermedades
            if ($request->has('diseases')) {
                $profile->diseases()->sync($request->diseases);
            }

            // Sincronizar alergias
            if ($request->has('allergies')) {
                $profile->allergies()->sync($request->allergies);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Perfil de salud actualizado exitosamente',
                'data' => $profile->load('customer.user', 'diseases', 'allergies')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el perfil de salud: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified health profile
     */
    public function destroy($id)
    {
        $profile = HealthProfile::find($id);

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Perfil de salud no encontrado'
            ], 404);
        }

        $profile->delete();

        return response()->json([
            'success' => true,
            'message' => 'Perfil de salud eliminado exitosamente'
        ]);
    }
}