<?php

namespace App\Http\Controllers;

use App\Models\CafeRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CafeRatingController extends Controller
{
    /**
     * Guardar una nueva calificación
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // Verificar si el usuario ya calificó
        $existingRating = CafeRating::where('user_id', $user->id)->first();

        if ($existingRating) {
            // Actualizar calificación existente
            $existingRating->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Gracias! Tu calificación ha sido actualizada.',
                'rating' => $existingRating
            ]);
        }

        // Crear nueva calificación
        $rating = CafeRating::create([
            'user_id' => $user->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Gracias por tu calificación! Tu opinión nos ayuda a mejorar.',
            'rating' => $rating
        ]);
    }

    /**
     * Obtener las estadísticas de calificaciones
     */
    public function stats()
    {
        $averageRating = round(CafeRating::getAverageRating(), 1);
        $totalRatings = CafeRating::getTotalRatings();

        // Distribución de calificaciones
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = CafeRating::where('rating', $i)->count();
            $distribution[$i] = [
                'count' => $count,
                'percentage' => $totalRatings > 0 ? round(($count / $totalRatings) * 100, 1) : 0
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'average' => $averageRating,
                'total' => $totalRatings,
                'distribution' => $distribution
            ]
        ]);
    }

    /**
     * Obtener las últimas calificaciones
     */
    public function recent(Request $request)
    {
        $limit = $request->input('limit', 10);
        $ratings = CafeRating::getRecentRatings($limit);

        return response()->json([
            'success' => true,
            'data' => $ratings
        ]);
    }

    /**
     * Verificar si el usuario ya calificó
     */
    public function checkUserRating()
    {
        $user = Auth::user();
        $rating = CafeRating::where('user_id', $user->id)->first();

        return response()->json([
            'success' => true,
            'hasRated' => $rating !== null,
            'rating' => $rating
        ]);
    }

    /**
     * Mostrar página de todas las reseñas
     */
    public function index()
    {
        $ratings = CafeRating::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $averageRating = round(CafeRating::getAverageRating(), 1);
        $totalRatings = CafeRating::getTotalRatings();

        // Distribución de calificaciones
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = CafeRating::where('rating', $i)->count();
            $distribution[$i] = [
                'count' => $count,
                'percentage' => $totalRatings > 0 ? round(($count / $totalRatings) * 100, 1) : 0
            ];
        }

        $stats = [
            'average' => $averageRating,
            'total' => $totalRatings,
            'distribution' => $distribution
        ];

        return view('client.reviews', compact('ratings', 'stats'));
    }
}
