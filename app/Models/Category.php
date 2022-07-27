<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mysql';
    use HasFactory;
    protected $fillable = [
        'id',
        'category',

    ];
    public function sub(){
        return $this ->belongsTo('App\Models\Sub','id','category_id');
    }
}
