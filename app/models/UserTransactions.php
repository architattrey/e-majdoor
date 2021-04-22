<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserTransactions extends Model
{
    protected $table   = 'user_transactions';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable   = [
        'order_id',
        'user_id',
        'majdoor_id',
        'service_type_id',
        'invoice_id',
        'phone_number',
        'amount',
        'city',
        'dlvry_address',
        'lat',
        'lng',
        'no_of_majdoor',
        'dlvry_status',
        'created_at',
        'updated_at',
    ];
    #service provider
    public function majdoor(){
        return $this->belongsTo('App\models\Majdoor', 'majdoor_id', 'id');
    }
    public function getMajdoor($city=NULL){
         
       return Appmajdoors::where('delete_status', "1")->where('city',$city)->orderBy('city','asc')->get();
    }  
}
