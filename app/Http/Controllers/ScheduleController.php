<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WearSchedule;
use App\Models\WashSchedule;
use App\Models\Outfit;
use App\Models\Clothing;

class ScheduleController extends Controller
{
    public function showDay($date)
    {
        $clothes = Clothing::where('user_id', auth()->id())->get();
        $outfits = Outfit::where('user_id', auth()->id())->with('clothing')->get();
        $wearSchedule = WearSchedule::where('date', $date)->where('user_id', auth()->id())->with('outfit.clothing')->get();
        $washSchedule = WashSchedule::where('date', $date)->where('user_id', auth()->id())->with('outfit.clothing')->get();
        $wearables = Outfit::getWearableIds();

        return view('schedule.day',[
            'day' => $date,
            'clothes' => $clothes,
            'wearables' => $wearables,
            'wearSchedule' => $wearSchedule,
            'washSchedule' => $washSchedule,
            'outfits' => $outfits,
        ]);
    }

    public function wear($date)
    {
        $outfits = Outfit::where('user_id', auth()->id())->with('clothing')->get();
        $wearables = Outfit::getWearableIds();

        return view('schedule.wear', ['date' => $date]);
    }

    public function wash($date)
    {
        $outfits = Outfit::where('user_id', auth()->id())->with('clothing')->get();
        $wearables = Outfit::getWearableIds();

        return view('schedule.wash', ['date' => $date]);
    }

    public function storeWear($date)
    {
        $validated = request()->validate([
            'outfit' => 'required',
        ]);

        $user_id = auth()->id();

        WearSchedule::create([
            'date' => $date,
            'user_id' => $user_id,
            'outfit_id' => $validated['outfit'],
        ]);

        return redirect()->route('schedule.day', ['date' => $date]);
    }

    public function storeWash($date)
    {
        $validated = request()->validate([
            'outfit' => 'required',
        ]);

        $user_id = auth()->id();

        WashSchedule::create([
            'date' => $date,
            'user_id' => $user_id,
            'outfit_id' => $validated['outfit'],
        ]);

        return redirect()->route('schedule.day', ['date' => $date]);
    }
}
