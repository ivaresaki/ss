<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_registrations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('registration_id', 8);
            $table->string('name', 255);
            $table->text('address');
            $table->string('poc_name', 255);
            $table->string('poc_email', 255);
            $table->string('poc_phone', 50);

            $table->enum('approval', ['pending', 'approved', 'rejected'])
                  ->default('pending');

            $table->integer('owner_id')
                  ->unsigned();
            $table->integer('approver_id')
                  ->unsigned()
                  ->nullable();

            $table->foreign('owner_id')
                  ->references('id')
                  ->on('users')
                  ->onCascade('delete');

            $table->foreign('approver_id')
                  ->references('id')
                  ->on('users')
                  ->onCascade('set null');

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
        Schema::dropIfExists('site_registrations');
    }
}
