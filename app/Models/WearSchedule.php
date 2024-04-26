<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WearSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'user_id', 'outfit_id'];
}
