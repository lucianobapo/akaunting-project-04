<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Utilities\CacheUtility;
use App\Models\Common\Company;
use App\Models\Auth\User;


class Menu
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $customer = null;
        $user = auth()->user();
        $cache = new CacheUtility();

        // Get all companies       

        $companies = $cache->remember('companies_view_composer', function () use ($user) {
            return $user->companies()->enabled()->limit(10)->get()->each(function ($com) {
                    $com->setSettings();
            })->sortBy('name');
        }, [User::class,Company::class]);

        // Get customer
        $get_customer = $cache->remember('user_customer_user_id_'.$user->id, function () use ($user) {
            return $user->customer;
        }, [User::class]);

        if ($get_customer) {
            $customer = $user;
        }

        $view->with(['companies' => $companies, 'customer' => $customer]);
    }
}
