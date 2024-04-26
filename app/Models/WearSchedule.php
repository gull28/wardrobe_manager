<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WearSchedule extends Model
{

    protected $table = "wear_schedule";


    use HasFactory;

    protected $fillable = ['date', 'user_id', 'clothing_id'];
}
