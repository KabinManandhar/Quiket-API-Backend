<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->integer('price');
            $table->integer('total_ticket');
            $table->integer('max_ticket_allowed_per_person')->default(10);
            $table->integer('min_ticket_allowed_per_person')->default(1);
            $table->boolean('ticket_type');
//            $table->string('promo_code')->nullable();tivk
            $table->boolean('status');
//            $table->boolean('refundable');
            $table->bigInteger('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
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
        Schema::dropIfExists('tickets');
    }
}
