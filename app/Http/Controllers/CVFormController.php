<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Cv;
use App\Models\Technology;
use App\Models\University;
use Carbon\Carbon;
use \Illuminate\View\View;
use \Illuminate\Http\RedirectResponse;

class CVFormController extends Controller
{

    public function show(): View
    {
        return view('form-page', [
            'technologies' => Technology::all(),
            'universities' => University::all(),
        ]);
    }

    /**
     * Намира (създава ако го няма) университет 
     * по име и го връща като обект от базата данни
     */
    private function getUniversity(Request $request, string $university_name): University
    {
        if (!University::where('name', $university_name)->first()) {
            return University::create(['name' => $university_name, 'grade' => $request->input('university')->grade]);
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
    private function addTechnologies(Cv $cv, array $technologies_names): void
    {
        $technologies = [];

        foreach ($technologies_names as $t) {
            $technology = Technology::where('name', $t)->first();

            if (!$technology) {
                $technology = Technology::create(['name' => $t]);
            }

            $technologies = array_merge($technologies, [$technology->id]);
        }

        $cv->technologies()->attach($technologies);
    }

    /**
     * Намираме cv-то със съответния потребител,
     * променяме университета ако потребителя е 
     * записал друг, същото и за технологиите,
     * които знае. Накрая запазваме инстанцията
     */
    private function replaceCv(Request $request, array $validatedData, Person $person): void
    {
        $cv = Cv::where('person_id', $person->id)->first();

        $cv->university_id = $this->getUniversity($request, $validatedData['university'])->id;
        $cv->technologies()->detach();
        $this->addTechnologies($cv, $validatedData['technologies']);
        $cv->created_at = Carbon::now();
        $cv->save();
    }

    /**
     * Създаваме потребител и свързваме
     * нужните релации
     */
    private function createCv(Request $request, array $validatedData): void
    {
        $person = Person::create(
            [
                'first_name' => $validatedData['first_name'],
                'middle_name' => $validatedData['middle_name'],
                'last_name' => $validatedData['last_name'],
                'date_of_birth' => $validatedData['date_of_birth'],
            ]
        );

        $cv = Cv::create([
            'person_id' => $person->id,
            'university_id' => $this->getUniversity($request, $validatedData['university'])->id,
        ]);

        $this->addTechnologies($cv, $validatedData['technologies']);
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:25',
            'middle_name' => 'required|string|max:25',
            'last_name' => 'required|string|max:25',
            'date_of_birth' => 'required|date',
            'university' => 'required|string|max:50',
            'technologies' => 'required|array'
        ]);

        $person = Person::where('first_name', $validatedData['first_name'])
            ->where('middle_name', $validatedData['middle_name'])
            ->where('last_name', $validatedData['last_name'])->first();

        if ($person)
            $this->replaceCv($request, $validatedData, $person);
        else
            $this->createCv($request, $validatedData);


        return redirect('/table');
    }
}
