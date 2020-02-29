<?php

namespace Modules\Inventory\Filters;

use EloquentFilter\ModelFilter;

class Options extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relatedModel => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function search($query)
    {
        return $this->where('name', 'LIKE', '%' . $query . '%');
    }
}
