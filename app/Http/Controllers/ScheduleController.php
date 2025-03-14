<?php

namespace App\Http\Controllers;

use App\Models\WasteCollectingSchedule; 
use App\Models\WasteCollectionZone; 
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function schedule()
    {
        $schedules = WasteCollectingSchedule::with('wasteCollectionZone')
        ->orderBy('date')
        ->get()
        ->groupBy(function($schedule) {
            return \Carbon\Carbon::parse($schedule->date)->format('l'); // Format to get day of the week
        });

        $zones = WasteCollectionZone::all();

        return view('users.schedule.schedule', compact('schedules','zones'));
    }

    public function zonelist()
    {
        $zones = WasteCollectionZone::all();

        return view('users.schedule.zonelist', compact('zones'));
    }
}
