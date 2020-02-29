<?php

namespace Modules\Inventory\Observers;

use Modules\Inventory\Models\History as Model;
use App\Observers\TObserver;

class InventoryHistory extends TObserver
{
    public $modelClass = Model::class; 
}