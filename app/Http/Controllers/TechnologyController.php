<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TechnologyController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $technology_name = $request->input('name');
        $created = false;

        $technology = Technology::where('name', $technology_name)->first();

        if (!$technology) {
            $created = true;
            $technology = Technology::create([
                'name' => $technology_name,
            ]);
        }

        $response = [
            'technology' => $technology,
            'created' => $created
        ];

        return response()->json(
            $response
        );
    }
}
