<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WearSchedule;

class WashSchedule extends Model
{
    protected $table = "wash_schedule";

    use HasFactory;

    protected $fillable = ['date', 'user_id', 'clothing_id'];


    public static function canAddToWashSchedule($clothingId, $date){
        // check if outfit is not worn on the date 
        $wearSchedule = WearSchedule::where('clothing_id', $clothingId)->where('date', $date)->get();
        if($wearSchedule->count() > 0){
            return false;
        }

        // check if outfit is not already in the wash schedule
        $washSchedule = WashSchedule::where('clothing_id', $clothingId)->where('date', $date)->get();
        if($washSchedule->count() > 0){
            return false;
        }

    }
}
