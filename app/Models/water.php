<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class water extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'amount',
        'next_period',
        'pay_state',
        'city_number',
    ];
}
