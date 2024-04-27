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
        $wearSchedule = WearSchedule::where('date', $date)->where('user_id', auth()->id())->with('outfit.clothing')->get();
        $washSchedule = WashSchedule::where('date', $date)->where('user_id', auth()->id())->with('outfit.clothing')->get();
        $wearables = Outfit::getWearableIds();

        return view('schedule.day', [
            'day' => $date,
            'wearables' => $wearables,
            'wearSchedule' => $wearSchedule,
            'washSchedule' => $washSchedule,
        ]);
    }

    public function wear($day)
    {
        $outfits = Outfit::where('user_id', auth()->id())->with('clothing')->get();
        $wearables = Outfit::getWearableIds();

        return view('schedule.wear', ['day' => $day, 'outfits' => $outfits, 'wearables' => $wearables]);
    }

    public function wash($day)
    {
        $clothes = Clothing::where('user_id', auth()->id())->get();

        $isEditable = $day >= date('Y-m-d');

        $wearSchedule = WearSchedule::where('date', $day)->where('user_id', auth()->id())->get();

        $clothes = $clothes->reject(function ($clothing) use ($wearSchedule) {
            return $wearSchedule->contains('clothing_id', $clothing->id);
        });

        return view('schedule.wash', ['day' => $day, 'clothes' => $clothes]);
    }

    public function storeWear($date)
    {
        $validated = request()->validate([
            'outfit' => 'required',
        ]);

        $isValid = in_array($validated['outfit'], Outfit::getWearableIds());

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
