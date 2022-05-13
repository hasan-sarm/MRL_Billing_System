<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BankAccounte extends Model
{
    use HasFactory;
    protected $connection = 'mysql_bank';
    protected $fillable = [
        'user_name',
        'card_number',
        'cvc',
        'amount',
        'user_id',
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
    public function users(){
        return $this->setConnection('mysql')->belongsTo(User::class);
      //  return $this ->belongsTo('App\Models\User','user_id','id');
    }
}
