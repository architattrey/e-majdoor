<?php

namespace App\models;
use Illuminate\Database\Eloquent\Model;

class Appusers extends Model
{
    protected $table = 'appusers';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email_id',
        'phone_number',
        'login_method',
        'gender',
        'state',
        'city',
        'dob',
        'image',
        'ratings',
        'delete_status',
        'created_at',
        'updated_at',
    ];
    #feedbacks 
    public function getUsersFeedbacks()
    {
        return $this->hasOne('App\models\UsersFeedbacks','user_id','id');
    }
}
