<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WashSchedule;
use App\Models\Outfit;
use App\Transformers\OutfitTransformer;

class WearSchedule extends Model
{
    protected $table = 'wear_schedule';

    use HasFactory;

    protected $fillable = ['date', 'user_id', 'outfit_id'];

    public function outfit()
    {
        return $this->belongsTo(Outfit::class);
    }

    public static function canAddToWearSchedule($outfitId, $date)
    {
        $outfits = Outfit::where('id', $outfitId)->with('clothing')->get();
        $outfit = OutfitTransformer::transform($outfits)[0];

        $wearSchedule = WearSchedule::where('outfit_id', $outfitId)->where('date', '>', now())->orderBy('date', 'asc')->get();

        $clothing = $outfit['clothes'];

        $canWear = true;

        $date = date('Y-m-d', strtotime($date));
        $day = date('d', strtotime($date));

        // what this does is simulate the wear and was schedule for the outfit with simulated dates
        // if the outfit has negative wear count at any point in time, it can't be added to the wear schedule
        foreach ($clothing as $c) {
            $clothingId = $c['id'];
            $wearCount = $c['wear_count'];
            $washSchedule = WashSchedule::where('clothing_id', $clothingId)->where('date', '>', now())->orderBy('date', 'asc')->get();

            $containsDate = $washSchedule->contains(function ($value, $key) use ($day) {
                return date('d', strtotime($value['date'])) == $day;
            });
            
            if ($containsDate) {
                $canWear = false;
            }

            $schedule = collect();
            foreach ($wearSchedule as $ws) {
                $schedule->push(['date' => $ws['date'], 'type' => 'wear']);
            }

            foreach ($washSchedule as $ws) {
                $schedule->push(['date' => $ws['date'], 'type' => 'wash']);
            }
            $schedule->push(['date' => $date, 'type' => 'wear']);
            $schedule = collect($schedule)->sortBy('date');

            foreach ($schedule as $s) {
                if ($s['type'] == 'wear') {
                    $wearCount--;
                } else {
                    $wearCount = $c['wear_count'];
                }
                if ($wearCount < 0) {
                    $canWear= false;
                }
            }
            if ($wearCount < 0) {
                $canWear = false;
            }
        }


        return $canWear;
    }
    // public function canAddToWearSchedule($outfitId){
    //     $outfit = Outfit::find($outfitId)->with('clothing')->get();
    //     // get wear schedule for the outfit in the future
    //     $wearSchedule = WearSchedule::where('outfit_id', $outfitId)->where('date', '>', now())->orderBy('date', 'asc')->get();
    //     // get the wash schedule for the outfit in the future
    //     $washSchedule = WashSchedule::where('outfit_id', $outfitId)->where('date', '>', now())->orderBy('date', 'asc')->get();

    //     // simulate outfit flow

    // }
}
