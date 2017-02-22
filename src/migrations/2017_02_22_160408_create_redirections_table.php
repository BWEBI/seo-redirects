<?php

use Illuminate\Database\Migrations\Migration;

class CreateRedirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirections', function ($table) {
            $table->increments('id');
            $table->string('from_url', 500);
            $table->string('to_url', 500);
            $table->integer('status_code')->default(301);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redirections');
    }
}
