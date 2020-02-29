<?php

namespace App\Providers;

use App\Models\Auth\User;
use App\Models\Common\Company;
use App\Models\Common\Media;
use App\Models\Common\Item;
use App\Models\Setting\Tax;
use App\Models\Setting\Category;
use App\Models\Setting\Currency;
use App\Models\Module\Module;

use App\Models\Income\Invoice;
use App\Models\Income\InvoiceItem;
use App\Models\Income\Revenue;
use App\Models\Income\InvoicePayment;

use App\Models\Expense\Bill;
use App\Models\Expense\BillItem;
use App\Models\Expense\Vendor;
use App\Models\Expense\BillStatus;
use App\Models\Expense\Payment;
use App\Models\Expense\BillPayment;

use App\Models\Banking\Transfer;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Observe company actions
        Company::observe('App\Observers\Company');
        
        Media::observe('App\Observers\Media');
        
        User::observe('App\Observers\User');        
        Item::observe('App\Observers\Item');        
        Tax::observe('App\Observers\Tax');
        Category::observe('App\Observers\Category');
        Invoice::observe('App\Observers\Invoice');
        InvoiceItem::observe('App\Observers\InvoiceItem');
        Revenue::observe('App\Observers\Revenue');
        InvoicePayment::observe('App\Observers\InvoicePayment');
        
        BillItem::observe('App\Observers\BillItem');
        
        Bill::observe('App\Observers\Bill');
        Vendor::observe('App\Observers\Vendor');
        BillStatus::observe('App\Observers\BillStatus');
        BillPayment::observe('App\Observers\BillPayment');
        Payment::observe('App\Observers\Payment');
        
        Currency::observe('App\Observers\Currency');
        Module::observe('App\Observers\Module');
        Transfer::observe('App\Observers\Transfer');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}