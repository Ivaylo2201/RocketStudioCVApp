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

    /**
     * Намира (създава ако го няма) университет 
     * по име и го връща като обект от базата данни
     */
    private function get_university($university_name)
    {
        if (!University::where('name', $university_name)->first()) {
            return University::create(['name' => $university_name, 'grade' => 0]);
        }

        return University::where('name', $university_name)->first();
    }

    /**
     * Намираме технология по име (създаваме я ако я няма) и
     * прибавяме нейното ид към масив. След обхождането прибавяме
     * технологиите към Many-to-Many полето на Person. Това е концепция
     * при базите данни наречена bulk create, която позволява да правим
     * множество релации наведнъж, което води до олекотени заявки
     */
    private function add_technologies($person, $technologies_names)
    {
        $technologies = [];

        foreach ($technologies_names as $t) {
            $technology = Technology::where('name', $t)->first();

            if (!$technology) {
                $technology = Technology::create(['name' => $t]);
            }

            $technologies = array_merge($technologies, [$technology->id]);
        }

        $person->technologies()->attach($technologies);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:25',
            'middle_name' => 'required|string|max:25',
            'last_name' => 'required|string|max:25',
            'date_of_birth' => 'required|date',
            'university' => 'required|string|max:50',
            'technologies' => 'required|array'
        ]);

        $person = Person::create(
            [
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'university_id' => $this->get_university($validatedData['university'])->id,
            ]
        );

        $this->add_technologies($person, $validatedData['technologies']);

        Cv::create(['person_id' => $person->id]);

        return redirect('/table');
    }
}
