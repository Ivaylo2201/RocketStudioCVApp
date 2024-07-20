<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CVTableController extends Controller
{
    public function fetch_user_cvs($start, $end)
    {
        return Cv::whereHas('person', function ($query) use ($start, $end) {
            $query->whereBetween('date_of_birth', [$start, $end]);
        })->get();
    }

    public function show(Request $request)
    {
        $start = Carbon::parse($request->input('start_date'));
        $end = Carbon::parse($request->input('end_date'));

        return view('cv-table', ['cvs' => $this->fetch_user_cvs($start, $end)]);
    }
}
