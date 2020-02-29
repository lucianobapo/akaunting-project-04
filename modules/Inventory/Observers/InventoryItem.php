<?php

namespace Modules\Inventory\Observers;

use Modules\Inventory\Models\Item as Model;
use App\Observers\TObserver;

class InventoryItem extends TObserver
{
    public $modelClass = Model::class; 
}