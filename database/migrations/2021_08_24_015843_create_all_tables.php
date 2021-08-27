<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar')->default('default.png');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->integer('id_creator');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('website');
            $table->longText('description');
            $table->integer('discount');
            $table->string('open_weekday');
            $table->string('open_saturday');
            $table->string('open_sunday');
            $table->string('open_holiday');
            $table->integer('product_type');
            $table->integer('signature_type');
            $table->tinyInteger('cardMachine');
            $table->integer('payment_type');
            $table->tinyInteger('featured');
            $table->tinyInteger('is_current_location')->default(1);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });

        Schema::create('establishment_images', function (Blueprint $table) {
            $table->id();
            $table->integer('id_establishment');
            $table->string('url');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('establishment');
        Schema::dropIfExists('establishment_images');
    }
}
