<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citycode2 extends Model
{
    use HasFactory;
    protected $connection = 'mysql_Electrics';
    protected $fillable = [

        'city',
    ];
      /**
     * Relation
     */
    // One to Many
    public function electic()
    {
        return $this ->hasMany('App\Models\Electric','city_code');
    }
}
