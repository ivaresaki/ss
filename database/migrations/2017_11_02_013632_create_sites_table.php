<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('address');
            $table->string('slug')->indexed();
            $table->string('registration_id', 8);

            $table->integer('owner_id')->unsigned();
            
            $table->foreign('owner_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

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
        Schema::dropIfExists('sites');
    }
}
