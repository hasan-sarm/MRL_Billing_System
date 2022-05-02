<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_name',
        'card_number',
        'cvc',
        'amount',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'card_number',
        'cvc'
    ];
    public $timestamps = true;
    /**
     * Relation
     */
    //Belongs to
    public function user(){
        return $this ->belongsTo('App\Models\User','cvc','id');
    }
}
