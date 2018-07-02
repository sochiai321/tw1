<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterBountyListLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_bounty_list_links', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bounty_list_id');
            $table->unsignedInteger('link_id');
            $table->string('bounty_list_link');
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
        Schema::dropIfExists('master_bounty_list_links');
    }
}
