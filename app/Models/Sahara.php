<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sahara extends Model
{
    use HasFactory;
    protected $connection = 'mysql_sahara';
    protected $table = 'sahara_billes';
    protected $fillable = [

        'code',
        'amount',
        'next_payment',
        'pay_state',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
