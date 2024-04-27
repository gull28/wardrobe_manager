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

    // public function canAddToWearSchedule($outfitId){
    //     $outfit = Outfit::find($outfitId)->with('clothing')->get();
    //     // get wear schedule for the outfit in the future
    //     $wearSchedule = WearSchedule::where('outfit_id', $outfitId)->where('date', '>', now())->orderBy('date', 'asc')->get();
    //     // get the wash schedule for the outfit in the future
    //     $washSchedule = WashSchedule::where('outfit_id', $outfitId)->where('date', '>', now())->orderBy('date', 'asc')->get();

    //     // simulate outfit flow

    // }
}
