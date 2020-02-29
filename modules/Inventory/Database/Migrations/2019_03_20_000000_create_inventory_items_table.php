<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInventoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('item_id');
            $table->double('opening_stock', 7, 2)->nullable();
            $table->double('opening_stock_value', 15, 4)->nullable();
            $table->double('reorder_level')->nullable();
            $table->integer('vendor_id')->nullable();

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
        Schema::drop('inventory_items');
    }
}
