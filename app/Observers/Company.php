<?php

namespace App\Observers;

use App\Models\Common\Company as Model;
use Artisan;
use Auth;

class Company extends TObserver
{
    public $modelClass = Model::class; 

    /**
     * Listen to the created event.
     *
     * @param  Model  $company
     * @return void
     */
    public function created($model)
    {
        // Create seeds
        Artisan::call('company:seed', [
            'company' => $model->id
        ]);

        // Check if user is logged in
        if (!Auth::check()) {
            return;
        }

        // Attach company to user
        Auth::user()->companies()->attach($model->id);

        parent::created($model);
    }

    /**
     * Listen to the deleted event.
     *
     * @param  Model  $company
     * @return void
     */
    public function deleted($model)
    {
        $tables = [
            'accounts', 'bill_histories', 'bill_items', 'bill_payments', 'bill_statuses', 'bills', 'categories',
            'currencies', 'customers', 'invoice_histories', 'invoice_items', 'invoice_payments', 'invoice_statuses',
            'invoices', 'items', 'payments', 'recurring', 'revenues', 'settings', 'taxes', 'transfers', 'vendors',
        ];

        foreach ($tables as $table) {
            foreach ($model->$table as $item) {
                $item->delete();
            }
        }

        parent::deleted($model);
    }
}