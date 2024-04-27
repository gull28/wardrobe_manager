<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WashSchedule;
use App\Models\Outfit;

class WearSchedule extends Model
{
    protected $table = 'wear_schedule';

    use HasFactory;

    protected $fillable = ['date', 'user_id', 'outfit_id'];

    public function outfit(){
        return $this->belongsTo(Outfit::class);
    }

    public function canAddToWearSchedule($outfitId, $date){
        $outfit = Outfit::find($outfitId)->with('clothing')->get();
        // get wear schedule for the outfit in the future
        $wearSchedule = WearSchedule::where('outfit_id', $outfitId)->where('date', '>', now())->orderBy('date', 'asc')->get();

        $clothing = $outfit->clothes;

        $canWear = true;

        // what this does is simulate the wear and was schedule for the outfit with simulated dates
        // if the outfit has negative wear count at any point in time, it can't be added to the wear schedule
        foreach($clothing as $c){
            $clothingId = $clothing->id;
            $wearCount = $clothing->wear_count;
            $washCount = WashSchedule::where('clothing_id', $clothingId)->where('date', '>', now())->orderBy('date', 'asc')->get();

            $schedule = $wearSchedule->merge($washSchedule)->push(['date' => $date])->sortBy('date');

            foreach($schedule as $s){
                if($s->clothing_id == $clothingId){
                    if($s->type == 'wear'){
                        $wearCount--;
                    }else{
                        $wearCount = $clothing->wear_count;
                    }
                    if($wearCount < 0){
                        $canWear = false;
                    }
                }
            }
            if($wearCount < 0){
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
