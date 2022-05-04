<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_code_id',
        'city',
    ];
      /**
     * Relation
     */
    // One to Many
    public function communication()
    {
        return $this ->hasMany('App\Models\Communication','city_code_id','city_code');
    }
}
