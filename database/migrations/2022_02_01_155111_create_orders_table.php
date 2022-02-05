<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('orderer_id')->unsigned();
            $table->string('pick_up_detail');
            $table->string('pick_up_latitude');
            $table->string('pick_up_longitude');
            $table->string('drop_off_detail');
            $table->string('drop_off_latitude');
            $table->string('drop_off_longitude');
            $table->enum('status', ['searching', 'accepted', 'on_pick_up_location', 'on_the_way', 'on_drop_off_location', 'dropped'])->default('searching');
            $table->timestamps();

            $table->foreign('orderer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
