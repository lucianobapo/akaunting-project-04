<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // All Company create accounts
        $this->call(\Modules\Inventory\Database\Seeders\Warehouses::class);
    }
}
