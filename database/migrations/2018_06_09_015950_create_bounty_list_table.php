<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBountyListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bounty_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('twitter_account_uid');
            $table->string('bounty_username');
            $table->unsignedInteger('bounty_uid');
            $table->unsignedInteger('number_of_retweet');
            $table->unsignedInteger('number_of_tweet');
            $table->string('tweet_keyword')->nullable();
            $table->unsignedInteger('number_of_tweet_with_quote');
            $table->string('tweet_with_quote_keyword')->nullable();
            $table->unsignedInteger('comment_enabled');
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
        Schema::dropIfExists('bounty_list');
    }
}
