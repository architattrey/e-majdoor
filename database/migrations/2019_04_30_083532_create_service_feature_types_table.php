<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceFeatureTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_feature_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('service_features_id');
            $table->string('type');
            $table->string('price');
            $table->string('image');
            $table->enum('delete_status',['0','1']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_feature_types');
    }
}
