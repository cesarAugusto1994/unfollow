<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('media_id');
            $table->foreign('media_id')->references('id')->on('user_medias');
            $table->string('type')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('media_images');
    }
}
