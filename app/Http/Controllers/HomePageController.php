<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WearSchedule;
use App\Models\WashSchedule;

class HomePageController extends Controller
{
    public function index()
    {
        // check for auth

        if (!auth()->check()) {
            return view('welcome');
        }

        // get wear and wash schedules for user

        $wearSchedule = WearSchedule::where('user_id', auth()->id())->orderBy('date', 'asc')->get();
        $washSchedule = WashSchedule::where('user_id', auth()->id())->orderBy('date', 'asc')->get();

        // combine wear and was schedules

        $schedule = collect();
        foreach ($wearSchedule as $ws) {
            $date = date('Y-m-d', strtotime($ws['date']));
            $schedule->push(['date' => $date, 'type' => 'wear']);
        }

        foreach ($washSchedule as $ws) {
            $date = date('Y-m-d', strtotime($ws['date']));
            $schedule->push(['date' => $date, 'type' => 'wash']);
        }

        $schedule = collect($schedule)->sortBy('date');

        return view('welcome', [
            'schedule' => $schedule,
        ]);
    }
}
