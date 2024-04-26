<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WashSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'user_id', 'outfit_id'];
}
