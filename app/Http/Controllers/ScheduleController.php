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
        $washSchedule = WashSchedule::where('date', $date)->where('user_id', auth()->id())->get();
        $wearables = Outfit::getWearableIds();

        $isEditable = date('Y-m-d', strtotime($date)) >= date('Y-m-d');

        return view('schedule.day', [
            'day' => $date,
            'wearables' => $wearables,
            'wearSchedule' => $wearSchedule,
            'washSchedule' => $washSchedule,
            'isEditable' => $isEditable
        ]);
    }

    public function wear($day)
    {
        $date = date('Y-m-d', strtotime($day));
        if($date < date('Y-m-d')){
            return redirect()->route('schedule.day', ['day' => $day]);
        }

        $outfits = Outfit::where('user_id', auth()->id())->with('clothing')->get();
        $wearables = Outfit::getWearableIds();

        return view('schedule.wear', ['day' => $day, 'outfits' => $outfits, 'wearables' => $wearables]);
    }

    public function wash($day)
    {
        $date = date('Y-m-d', strtotime($day));
        if($date < date('Y-m-d')){
            return redirect()->route('schedule.day', ['day' => $day]);
        }

        $clothes = Clothing::where('user_id', auth()->id())->get();

        $isEditable = $day >= date('Y-m-d');

        $wearSchedule = WearSchedule::where('date', $date)->where('user_id', auth()->id())->get();

        $clothes = $clothes->reject(function ($clothing) use ($wearSchedule) {
            return $wearSchedule->contains('clothing_id', $clothing->id);
        });

        return view('schedule.wash', ['day' => $day, 'clothes' => $clothes, 'isEditable' => $isEditable]);
    }

    public function storeWear($date)
    {
        
        $validated = request()->validate([
            'outfit' => 'required',
        ]);

        $wearSchedule = WearSchedule::where('date', $date)->where('user_id', auth()->id())->get();

        $isValid = in_array($validated['outfit'], Outfit::getWearableIds());

        $canAdd = WearSchedule::canAddToWearSchedule((int)$validated['outfit'], $date);

        if (!$isValid || !$canAdd) {
            return redirect()->route('schedule.wear', ['day' => $date]);
        }

        $user_id = auth()->id();

        $date = date('Y-m-d', strtotime($date));

        if($wearSchedule->count() > 0){
            $wearSchedule->each(function($schedule){
                $schedule->delete();
            });
        }

        WearSchedule::create([
            'date' => $date,
            'user_id' => $user_id,
            'outfit_id' => $validated['outfit'],
        ]);

        return redirect()->route('schedule.day', ['day' => $date]);
    }

    public function storeWash($date)
    {

        $validated = request()->validate([
            'clothes' => 'required',
        ]);

        $user_id = auth()->id();

        $date = date('Y-m-d', strtotime($date));
        // validate each clothing in from the request
        foreach ($validated['clothes'] as $clothing_id) {
            $canWash = WashSchedule::canAddToWashSchedule($clothing_id, $date);
            return var_dump($canWash);
            if ($canWash) {

                WashSchedule::create([
                    'date' => $date,
                    'user_id' => $user_id,
                    'clothing_id' => $clothing_id,
                ]);
            }
        }

        return redirect()->route('schedule.day', ['day' => $date]);
    }
}
