<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccounte extends Model
{
    use HasFactory,SoftDeletes;
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
    protected $dates=['deleted_at'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'card_number',
        'cvc',
        'deleted_at',
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
