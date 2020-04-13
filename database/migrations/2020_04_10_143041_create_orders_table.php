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
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');    
            $table->string('customer_name');   
            $table->bigInteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items');
            $table->integer('qty');
            $table->bigInteger('area_id')->unsigned();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->string('add_note')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->string('deliver_date')->nullable();
            $table->string('deliver_note')->nullable();
            $table->tinyInteger('status')->default(0);          
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
        Schema::dropIfExists('orders');
    }
}
