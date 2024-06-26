<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WearSchedule;
use App\Models\Outfit;
use App\Models\Clothing;

class WashSchedule extends Model
{
    protected $table = 'wash_schedule';

    use HasFactory;

    protected $fillable = ['date', 'user_id', 'clothing_id'];

    public function clothing(){
        return $this->belongsTo(Clothing::class);
    }

    public static function canAddToWashSchedule($clothingId, $date)
    {
        $outfits = Outfit::whereHas('clothing', function ($query) use ($clothingId) {
            $query->where('clothing_id', $clothingId);
        })->get();

        $wearSchedule = WearSchedule::whereIn('outfit_id', $outfits->pluck('id'))->where('date', $date)->orderBy('date', 'asc')->get();

        if ($wearSchedule->count() > 0) {

            return false;
        }

        $washSchedule = WashSchedule::where('clothing_id', $clothingId)->where('date', $date)->get();
        if ($washSchedule->count() > 0) {
            return false;
        }

        return true;
    }
}
