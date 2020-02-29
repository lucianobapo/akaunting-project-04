<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInventoryManufacturerVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_manufacturer_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('manufacturer_id');
            $table->integer('vendor_id');

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
        Schema::drop('inventory_manufacturer_vendors');
    }
}
