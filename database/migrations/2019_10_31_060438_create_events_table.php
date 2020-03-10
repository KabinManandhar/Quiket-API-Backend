<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('venue');
            $table->string('category');
            $table->string('type');
            $table->string('picture')->nullable();
            $table->boolean('status');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->bigInteger('organizer_id')->unsigned()->index();
            $table->foreign('organizer_id')->references('id')->on('organizers')->onDelete('cascade');
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
        Schema::dropIfExists('events');
    }
}
