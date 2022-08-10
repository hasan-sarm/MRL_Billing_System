<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citycode3 extends Model
{
    use HasFactory;
    protected $connection = 'mysql_water';
    protected $fillable = [

        'city',
    ];
      /**
     * Relation
     */
    // One to Many
    public function water()
    {
        return $this ->hasMany('App\Models\Electric','city_code');
    }
}
