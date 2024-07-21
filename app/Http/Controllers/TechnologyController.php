<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TechnologyController extends Controller
{
    // Взима подадената технология от popup прозореца
    // за технологиите и проверява дали има вече такава в бд:
    // - ако да: връща самата технология и флага created, който казва
    //   на ajax-а да не добавя <option> в select елемента
    // - ако не: създава и връща технологията и флага created, който
    //   вече е true, което позволява добавянето на <option>-а в select-а
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
