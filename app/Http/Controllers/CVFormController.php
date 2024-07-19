<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Cv;
use App\Models\Technology;
use App\Models\University;

class CVFormController extends Controller
{
    public function show()
    {
        return view('form-page');
    }

    public function store(Request $request)
    {
        $first_name = $request->input('first_name');
        $middle_name = $request->input('middle_name');
        $last_name = $request->input('last_name');
        $date_of_birth = $request->input('date_of_birth');
        $university = $request->input('university');
        $technologies = $request->input('technologies', []);

        if (!University::where('name', $university)->first()) {
            $university = University::create(['name' => $university, 'grade' => 0]);
        }

        $person = Person::create(
            [
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'date_of_birth' => $date_of_birth,
                'university_id' => $university->id,
            ]
        );

        foreach ($technologies as $t) {
            $technology = Technology::where('name', $t)->first();

            if (!$technology) {
                $technology = Technology::create(['name' => $t]);
            }

            $person->technologies()->attach([$technology->id]);
        }

        Cv::create(['person_id' => $person->id]);

        return redirect('/');
    }
}
