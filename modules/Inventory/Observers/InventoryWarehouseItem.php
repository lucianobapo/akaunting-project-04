<?php

namespace Modules\Inventory\Observers;

use Modules\Inventory\Models\WarehouseItem as Model;
use App\Observers\TObserver;

class InventoryWarehouseItem extends TObserver
{
    public $modelClass = Model::class; 
}