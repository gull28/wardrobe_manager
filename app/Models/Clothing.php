<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clothing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'description', 'size', 'color', 'user_id'];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
        ];
    }
}
