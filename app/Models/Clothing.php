<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clothing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'description', 'size', 'color', 'user_id', 'wear_count'];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
        ];
    }
}
