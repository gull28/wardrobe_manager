<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WearSchedule;
use App\Models\WashSchedule;
use App\Models\Outfit;
use App\Models\Clothing;

class ScheduleController extends Controller
{

    public $clothingTypes = [
        'shirt' => 'Shirt',
        'pants' => 'Pants',
        'shoes' => 'Shoes',
        'accessory' => 'Accessory',
        'other' => 'Other',
    ];

    public function showDay($date)
    {
        
        $wearSchedule = WearSchedule::where('date', $date)->where('user_id', auth()->id())->with('outfit.clothing')->get();
        $washSchedule = WashSchedule::where('date', $date)->where('user_id', auth()->id())->with('clothing')->get();
        $wearables = Outfit::getWearableIds();
        
        $isEditable = date('Y-m-d', strtotime($date)) >= date('Y-m-d');

        return view('schedule.day', [
            'day' => $date,
            'wearables' => $wearables,
            'wearSchedule' => $wearSchedule,
            'washSchedule' => $washSchedule,
            'isEditable' => $isEditable,
            'clothingTypes' => $this->clothingTypes,
        ]);
    }

    public function wear($day)
    {
        $date = date('Y-m-d', strtotime($day));
        if($date < date('Y-m-d')){
            return redirect()->route('schedule.day', ['day' => $day]);
        }

        $wearSchedule = WearSchedule::where('date', $date)->where('user_id', auth()->id())->first();
        
        $outfitId = null;
        if(!empty($wearSchedule)){
            $outfitId = $wearSchedule->outfit_id;
        }

        $outfits = Outfit::where('user_id', auth()->id())->with('clothing')->get();
        $wearables = Outfit::getWearableIds();

        return view('schedule.wear', ['day' => $day, 'outfits' => $outfits, 'wearables' => $wearables, 'outfitId' => $outfitId]);
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

        $washSchedule = WashSchedule::where('date', $date)->where('user_id', auth()->id())->get();
        $clothingIds = $washSchedule->pluck('clothing_id')->toArray();


        $clothes = $clothes->reject(function ($clothing) use ($wearSchedule) {
            return $wearSchedule->contains('clothing_id', $clothing->id);
        });

        return view('schedule.wash', ['day' => $day, 'clothes' => $clothes, 'isEditable' => $isEditable, 'selectedClothings' => $clothingIds]);
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

        $date = date('Y-m-d', strtotime($date));

        $validated = request()->validate([
            'clothes' => 'sometimes|array',
        ]);

        $user_id = auth()->id();

        $washSchedule = WashSchedule::where('date', $date)->where('user_id', $user_id)->get();
        if($washSchedule->count() > 0){
            $washSchedule->each(function($schedule){
                $schedule->delete();
            });
        }        

        // validate each clothing in from the request
        if( !empty($validated['clothes']) ){
            foreach ($validated['clothes'] as $clothingId) {
                $canAdd = WashSchedule::canAddToWashSchedule((int)$clothingId, $date);
                if($canAdd){
                    WashSchedule::create([
                        'date' => $date,
                        'user_id' => $user_id,
                        'clothing_id' => $clothingId,
                    ]);
                }
            }
        }

        return redirect()->route('schedule.day', ['day' => $date]);
    }
}
