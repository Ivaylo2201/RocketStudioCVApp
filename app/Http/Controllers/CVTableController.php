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

        // use -> Позволява на нестед функциите да използват неща
        // дефинирани е скоупа на външната функция
        $cvs_grouped_by_age = $cvs->groupBy(function ($cv) use ($age_ranges) {
            $age = Carbon::parse($cv->person->date_of_birth)->age;

            foreach ($age_ranges as $range => $boundaries) {
                if ($age >= $boundaries[0] && $age <= $boundaries[1]) {
                    return $range;
                }
            }
        });

        // $cvs_grouped_by_age ще е колекция, която в JSON би изглеждала така:
        // {
        //     "0-19": [{<CV обект 1>}, {<CV обект 2>}],
        //     "20-29": [{<CV обект 3>}, ...],
        //     ...
        // }

        // mapWithKeys преобразува колекцията (отгоре) в следната:

        // {
        //     "0-19": [<брой кандидати>, <масив с уникални технологии от всички кандидати>],
        //     "20-29": [<брой кандидати>, <масив с уникални технологии от всички кандидати>]
        // }

        $age_range_data = $cvs_grouped_by_age->mapWithKeys(function ($group, $age_range) {
            $number_of_people = $group->count();

            // 1. На всяка итерация взимаме cv ot group 
            //    и връщаме всички имена на техн. свързани с него

            // 2. След като сме обходили всичко ще имаме нещо такова:
            //
            //    $technologies = $group->flatMap([
            //        ['python', 'php'],
            //        ['c#', 'c++'],
            //        ['python', 'c#']
            //    ])

            // 3. След това flatMap ще вземе този 2д масив и ще го
            //    преобразува в едномерен:
            //
            //    $technologies = ['python', 'php', 'c#', 'c++', 'python', 'c#']

            // 4. Прилагаме функцията unique на този вече 'плосък' масив,
            //    която маха дублирани стойности, като оставя само първата срещната,
            //    това означава, че масивът с който работим вече е:
            //
            //    $technologies = ['python', 'php', 'c#', 'c++']

            // 5. Използваме ->values() за да реиндексираме колекцията след премахването от unique

            $technologies = $group->flatMap(function ($cv) {

                // $cv->technologies->pluck('name') - Взима 'name' на всяка технология
                // с която cv инстанцията е свързана в мапинг таблицата. Връща масив
                // с 1 или повече елементи в случая стрингове (имената на технологиите)

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
