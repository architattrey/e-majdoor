<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ServiceFeature extends Model
{
    protected $table = 'service_features';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'cat_id',
        'service_type',
        'image',
        'delete_status',
        'created_at',
        'updated_at'
    ];
    public function categories()
    {
        return $this->belongsTo('App\models\category','cat_id', 'id');
    }
}
