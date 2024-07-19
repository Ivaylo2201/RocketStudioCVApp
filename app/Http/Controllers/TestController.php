<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use App\Models\University;
use App\Models\Person;
use App\Models\Cv;
use Illuminate\Http\Request;

class TestController extends Controller
{   
    public function show($id)
    {
        $cv = CV::with('person')->findOrFail($id);
        $person = $cv->person;
        $cvData = $cv->toArray();

        $cvData['person'] = $cv->person->load('technologies');
        $cvData['person']['university'] = $person->university;  // Replace 'person_id' with the full 'person' object
        unset($cvData['person_id']);
        unset($cvData['person']['university_id']);   
        
        return response()->json($cvData);
    }

    public function testcreate() {
        $university = University::create([
            'name' => 'TU',
            'grade' => '5'
        ]);

        $python = Technology::create(['name' => 'Python']);
        $ts = Technology::create(['name' => 'TS']);
        $react = Technology::create(['name' => 'ReactJS']);

        $person = Person::create(
            [
                'first_name' => 'Ivaylo',
                'middle_name' => 'Emilov',
                'last_name' => 'Goergiev',
                'date_of_birth' => '1990-01-01',
                'university_id' => $university->id,
            ]
            );

        $person->technologies()->attach([$python->id, $ts->id, $react->id]);
        $person = $person->load('technologies');

        $cv = Cv::create(['person_id' => $person->id]);

        return response()->json(['cv' => $cv, 'person' => $person]);
    }
}
