<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clothing;

class Outfit extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'user_id'];

    public function clothing(){
        return $this->belongsToMany(Clothing::class, 'outfit_clothing', 'outfit_id', 'clothing_id')->withPivot('category');
    }

    public static function getWearableIds(){
        $wearableIds = [];
        
        $outfits = Outfit::where('user_id', auth()->id())->with('clothing')->get();

        foreach($outfits as $outfit){
            $wearable = true;
            foreach($outfit->clothing as $clothing){
                if($clothing->uses_left = 0){
                    $wearable = false;
                }
            }
            if($wearable){
                $wearableIds[] = $outfit->id;
            }
        }

        return $wearableIds;
        
    }
}
