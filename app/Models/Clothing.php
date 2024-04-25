<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clothing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'description', 'size', 'color', 'brand', 'user_id', 'wear_count'];

    public function outfits()
    {
        return $this->belongsToMany(Outfit::class, 'outfit_clothing', 'clothing_id', 'outfit_id')->withPivot('category');
    }

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
        ];
    }
}
