<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Appmajdoors extends Model
{
    protected $table = 'majdoors';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'cat',
        'service_type',
        'name',
        'phone',
        'gender',
        'dob',
        'address',
        'state',
        'city',
        'pin_code',
        'image',
        'password',
        'firebase_token',
        'status',
        'delete_status',
        'created_at',
        'updated_at'
    ];
}
