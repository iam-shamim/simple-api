<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('app_registration', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userID')->unsigned();
            $table->string('appName',100);
            $table->string('appID',20);
            $table->string('appSecret',80)->index();
            $table->enum('appStatus',['Active','InActive','Blocked']);
            $table->timestamps();
        });
        Schema::table('app_registration',function($table){
            $table->index(['userID']);
            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_registration', function (Blueprint $table) {
            //
        });
    }
}
