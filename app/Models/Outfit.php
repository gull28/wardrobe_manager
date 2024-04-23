<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outfit extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'user_id'];

    public function clothing(){
        return $this->belongsToMany(Clothing::class, 'outfit_clothing', 'outfit_id', 'clothing_id')->withPivot('category');
    }
}
