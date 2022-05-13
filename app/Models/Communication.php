<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;
    protected $connection = 'mysql_communication';
    protected $fillable = [
        'city_code',
        'number',
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
    /**
     * Relation
     */
    //belong to // one to many
     /**
     * Relation
     */
    //Belongs to
    public function city(){
        return $this ->belongsTo('App\Models\CityCode','city_code');
    }
}
