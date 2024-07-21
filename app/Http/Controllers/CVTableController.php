<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Illuminate\View\View;
use Illuminate\Support\Collection;

class CVTableController extends Controller
{
    private function aggregate(Carbon $start, Carbon $end)
    {
        // Етикети за възрастовите групи
        // и долна и горна граница за тхя
        $age_ranges = [
            '0-19' => [0, 19],
            '20-29' => [20, 29],
            '30-39' => [30, 39],
            '40-49' => [40, 49],
            '50-59' => [50, 59],
            '60-100' => [60, 100],
        ];

        $cvs = $this->fetchUserCvs($start, $end);

        // Проверяваме годините на всеки потребител свързан със св
        // и определяме към коя възрастова група принадлежи
        $cvs_grouped_by_age = $cvs->groupBy(function ($cv) use ($age_ranges) {
            $age = Carbon::parse($cv->person->date_of_birth)->age;

            foreach ($age_ranges as $range => $boundaries) {
                if ($age >= $boundaries[0] && $age <= $boundaries[1]) {
                    return $range;
                }
            }
        });

        // Връщаме броят на потребителите за всяка възрастова група
        // и взимаме всичките им умения (технологии) като ги филтрираме
        // така, че да няма повтарящи се
        $age_range_data = $cvs_grouped_by_age->mapWithKeys(function ($group, $age_range) {
            $number_of_people = $group->count();
            $technologies = $group->flatMap(function ($cv) {
                return $cv->technologies->pluck('name');
            })->unique()->values();

            return [
                $age_range => [
                    'number_of_people' => $number_of_people,
                    'technologies' => $technologies->implode(', ')
                ]
            ];
        });

        return $age_range_data;

    }

    private function fetchUserCvs(Carbon $start, Carbon $end): Collection
    {
        return Cv::whereHas('person', function ($query) use ($start, $end) {
            $query->whereBetween('date_of_birth', [$start, $end]);
        })->get();
    }

    public function show(Request $request): View
    {
        $start = Carbon::parse($request->input('start_date'));
        $end = Carbon::parse($request->input('end_date'));

        return view('cv-table', [
            'cvs' => $this->fetchUserCvs($start, $end),
            'age_range_data' => $this->aggregate($start, $end)
        ]);
    }
}
