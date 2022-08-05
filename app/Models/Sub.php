<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sub extends Model
{
    protected $connection = 'mysql';
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'sub_name',
        'category_id',
        'next_payment',
        'amount',
        'user_id',
        'bill_id',
        'created_at',
        'updated_at',
    ];
    protected $dates=['deleted_at'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public $timestamps = true;
    /**
     * Relation
     */
    //Belongs to
    public function user(){
        return $this ->belongsTo('App\Models\User','user_id','id');
    }
    public function category(){
        return $this ->belongsTo('App\Models\Category','id','category_id');
    }
}
