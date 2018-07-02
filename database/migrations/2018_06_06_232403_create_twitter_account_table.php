<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwitterAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twitter_account', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID');
            $table->string('twitter_uid')->unique();
            $table->string('profile_image_url');
            $table->string('twitter_username');
            $table->string('Access_Token');
            $table->string('Access_Token_Secret');
            $table->unsignedInteger('isActive');
            $table->unsignedInteger('isDisable')->default(0);
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
        Schema::dropIfExists('twitter_account');
    }
}
