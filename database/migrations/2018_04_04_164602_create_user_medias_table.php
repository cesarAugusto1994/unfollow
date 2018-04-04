<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_medias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('author_id')->nullable();
            $table->string('api_id')->nullable();
            $table->text('caption')->nullable();
            $table->integer('likes')->nullable();
            $table->integer('comments')->nullable();
            $table->string('filter')->nullable();
            $table->string('type')->nullable();
            $table->string('link')->nullable();
            $table->datetime('create_time')->nullable();
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
        Schema::dropIfExists('user_medias');
    }
}
