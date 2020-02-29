<?php

namespace Modules\Inventory\Database\Seeders;

use App\Models\Model;
use App\Utilities\Overrider;
use App\Models\Common\Company;
use Modules\Inventory\Models\Warehouse;

use Illuminate\Database\Seeder;

class Warehouses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $old_company_id = session('company_id');

        $company_id = $this->command->argument('company');

        $company = Company::where('id', $company_id)->first();

        $company->setSettings();

        session(['company_id' => $company_id]);

        $row = [
            'company_id' => $company_id,
            'name' => trans('inventory::warehouses.main_warehouse'),
            'email' => $company->company_email,
            'phone' => $company->company_phone,
            'address' => $company->company_address,
            'enabled' => '1',
        ];

        $warehouse = Warehouse::firstOrCreate($row);

        setting()->forgetAll();

        setting()->setExtraColumns(['company_id' => $company->id]);

        Overrider::load('settings');

        setting()->set('inventory.default_warehouse', $warehouse->id);
        setting()->save();

        setting()->forgetAll();

        session(['company_id' => $old_company_id]);

        Overrider::load('settings');
    }
}
