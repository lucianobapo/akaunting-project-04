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
            
            $table->increments('id');
            $table->integer('company_id');
            
            $table->string('title');
            $table->dateTime('start');
            $table->dateTime('end');
            
            $table->integer('vendor_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('reference')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milk_productions');
    }
}
