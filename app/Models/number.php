<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class number extends Model
{
    use HasFactory;
    protected $fillable = [
        'city',
        'city_number',
    ];
    public function electric()
    {
        return $this->belongsTo('App\Models\electric', 'city_number');
    }

    public function water()
    {
        return $this->belongsTo('App\Models\water', 'city_number');
    }
}
