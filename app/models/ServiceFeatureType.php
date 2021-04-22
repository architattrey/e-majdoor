<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ServiceFeatureType extends Model
{
    protected $table = 'service_feature_types';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'service_features_id',
        'type',
        'price',
        'image',
        'delete_status',
        'created_at',
        'updated_at'
    ];
    #get service feature 
    public function getServiceFeature()
    {
        return $this->belongsTo('App\models\ServiceFeature','service_features_id','id');
    }
}
