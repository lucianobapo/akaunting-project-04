<?php

namespace Modules\Inventory\Models;

use Modules\Inventory\Models\Model;
use Bkwld\Cloner\Cloneable;
use Illuminate\Notifications\Notifiable;
use Sofa\Eloquence\Eloquence;

class OptionValue extends Model
{
    use Cloneable, Eloquence, Notifiable;

    protected $table = 'inventory_option_values';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'option_id', 'name'];

    public function option()
    {
        return $this->belongsTo('Modules\Inventory\Models\Option');
    }
}
