<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    protected $table = 'service_providers';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'cat',
        'sub_cat',
        'name',
        'phone',
        'address',
        'district',
        'state',
        'pin_code',
        'ratings',
        'delete_status',
        'created_at',
        'updated_at'
    ];
}
