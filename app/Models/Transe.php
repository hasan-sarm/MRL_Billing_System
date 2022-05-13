<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transe extends Model
{
    use HasFactory;
    protected $connection = 'mysql_bank';
    protected $fillable = [
        'Transe_name',
        'from',
        'to',
        'transe_amount',
        'bill_id',
        'user_id',

    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',

    ];
    public $timestamps = true;
}
