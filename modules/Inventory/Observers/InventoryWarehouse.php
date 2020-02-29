<?php

namespace Modules\Inventory\Observers;

use Modules\Inventory\Models\Warehouse as Model;
use App\Observers\TObserver;

class InventoryWarehouse extends TObserver
{
    public $modelClass = Model::class; 
}