<?php

namespace App\Providers;

use App\Models\Setting\Currency;
use Illuminate\Support\ServiceProvider;
use Validator;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config([
            'profiting'=>[
                'category_types'      =>  [
                    //'profiting-milk' => 'Tanques de Leite',
                    'expense' => trans_choice('general.expenses', 1),
                    'income' => trans_choice('general.incomes', 1),
                    'item' => trans_choice('general.items', 1),
                    'other' => trans_choice('general.others', 1),
                ],
            ],
        ]);
        //dd(config('profiting'));
        
        
        
        $currency_code = null;

        Validator::extend('currency', function ($attribute, $value, $parameters, $validator) use(&$currency_code) {
            $status = false;
            
            if (!is_string($value) || (strlen($value) != 3)) {
                return $status;
            }

            $currencies = Currency::enabled()->pluck('code')->toArray();

            if (in_array($value, $currencies)) {
                $status = true;
            }

            $currency_code = $value;

            return $status;
        },
            trans('validation.custom.invalid_currency', ['attribute' => $currency_code])
        );

        $amount = null;

        Validator::extend('amount', function ($attribute, $value, $parameters, $validator) use (&$amount) {
            $status = false;

            if ($value > 0) {
                $status = true;
            }

            $amount = $value;

            return $status;
        },
            trans('validation.custom.invalid_amount', ['attribute' => $amount])
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
