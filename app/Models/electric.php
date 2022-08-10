<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electric extends Model
{
    use HasFactory;
    protected $connection = 'mysql_Electrics';

    protected $fillable = [
        'code',
        'amount',
        'next_payment',
        'pay_state',
        'city_code',
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
        return $this ->belongsTo('App\Models\CityCode2','city_code');
   }
}
