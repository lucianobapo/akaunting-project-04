<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMilksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milk_productions', function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer('company_id');
            //$table->integer('account_id');
            $table->date('posted_at');
            $table->double('quantity', 7, 2);
            //$table->string('currency_code');
            //$table->double('currency_rate', 15, 8);
            
            $table->integer('vendor_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('category_id')->nullable();
            //$table->string('payment_method');
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
