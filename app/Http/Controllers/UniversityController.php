<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UniversityController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $university_name = $request->input('name');
        $grade = $request->input('grade');
        $created = false;

        $university = University::where('name', $university_name)->first();

        if (!$university) {
            $created = true;
            $university = University::create([
                'name' => $university_name,
                'grade' => $grade
            ]);
        }

        $response = [
            'university' => $university,
            'created' => $created
        ];

        return response()->json(
            $response
        );
    }
}
