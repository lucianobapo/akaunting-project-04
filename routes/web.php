<?php

Route::group(['middleware' => 'language'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'uploads'], function () {
            Route::get('{id}', 'Common\Uploads@get');
            Route::get('{id}/show', 'Common\Uploads@show');
            Route::get('{id}/download', 'Common\Uploads@download');
        });

        require_once('web/wizard.php');      

        Route::group(['middleware' => ['adminmenu', 'permission:read-admin-panel']], function () {
     
            require_once('web/auth.php');     
            require_once('web/common.php');     
            require_once('web/incomes.php');     
            require_once('web/expenses.php');     

            Route::get('/', 'Common\Dashboard@index');

            Route::group(['prefix' => 'uploads'], function () {
                Route::delete('{id}', 'Common\Uploads@destroy');
            });

            Route::group(['prefix' => 'banking'], function () {
                Route::get('accounts/currency', 'Banking\Accounts@currency')->name('accounts.currency');
                Route::get('accounts/{account}/enable', 'Banking\Accounts@enable')->name('accounts.enable');
                Route::get('accounts/{account}/disable', 'Banking\Accounts@disable')->name('accounts.disable');
                Route::resource('accounts', 'Banking\Accounts', ['middleware' => ['dateformat', 'money']]);
                Route::resource('transactions', 'Banking\Transactions');
                Route::resource('transfers', 'Banking\Transfers', ['middleware' => ['dateformat', 'money']]);
                Route::post('reconciliations/calculate', 'Banking\Reconciliations@calculate')->middleware(['money']);
                Route::patch('reconciliations/calculate', 'Banking\Reconciliations@calculate')->middleware(['money']);
                Route::resource('reconciliations', 'Banking\Reconciliations', ['middleware' => ['dateformat', 'money']]);
            });

            Route::group(['prefix' => 'reports'], function () {
                Route::resource('income-summary', 'Reports\IncomeSummary');
                Route::resource('expense-summary', 'Reports\ExpenseSummary');
                Route::resource('income-expense-summary', 'Reports\IncomeExpenseSummary');
                Route::resource('tax-summary', 'Reports\TaxSummary');
                Route::resource('profit-loss', 'Reports\ProfitLoss');
            });

            Route::group(['prefix' => 'settings'], function () {
                Route::post('categories/category', 'Settings\Categories@category');
                Route::get('categories/{category}/enable', 'Settings\Categories@enable')->name('categories.enable');
                Route::get('categories/{category}/disable', 'Settings\Categories@disable')->name('categories.disable');
                Route::resource('categories', 'Settings\Categories');
                Route::get('currencies/currency', 'Settings\Currencies@currency');
                Route::get('currencies/config', 'Settings\Currencies@config');
                Route::get('currencies/{currency}/enable', 'Settings\Currencies@enable')->name('currencies.enable');
                Route::get('currencies/{currency}/disable', 'Settings\Currencies@disable')->name('currencies.disable');
                Route::resource('currencies', 'Settings\Currencies');
                Route::get('cache', 'Settings\Settings@cache')->name('settings.cache');
                Route::get('settings', 'Settings\Settings@edit')->name('settings.edit');
                Route::patch('settings', 'Settings\Settings@update');
                Route::get('taxes/{tax}/enable', 'Settings\Taxes@enable')->name('taxes.enable');
                Route::get('taxes/{tax}/disable', 'Settings\Taxes@disable')->name('taxes.disable');
                Route::resource('taxes', 'Settings\Taxes');
                Route::get('apps/{alias}', 'Settings\Modules@edit');
                Route::patch('apps/{alias}', 'Settings\Modules@update');
            });

            Route::group(['prefix' => 'apps'], function () {
                Route::resource('token', 'Modules\Token');
                Route::resource('home', 'Modules\Home');
                Route::resource('my', 'Modules\My');
                Route::get('categories/{alias}', 'Modules\Tiles@categoryModules');
                Route::get('vendors/{alias}', 'Modules\Tiles@vendorModules');
                Route::get('docs/{alias}', 'Modules\Item@documentation');
                Route::get('paid', 'Modules\Tiles@paidModules');
                Route::get('new', 'Modules\Tiles@newModules');
                Route::get('free', 'Modules\Tiles@freeModules');
                Route::get('search', 'Modules\Tiles@searchModules');
                Route::post('steps', 'Modules\Item@steps');
                Route::post('download', 'Modules\Item@download');
                Route::post('unzip', 'Modules\Item@unzip');
                Route::post('install', 'Modules\Item@install');
                Route::get('post/{alias}', 'Modules\Item@post');
                Route::post('{alias}/reviews', 'Modules\Item@reviews');
                Route::get('{alias}/uninstall', 'Modules\Item@uninstall');
                Route::get('{alias}/enable', 'Modules\Item@enable');
                Route::get('{alias}/disable', 'Modules\Item@disable');
                Route::get('{alias}', 'Modules\Item@show');
            });

            Route::group(['prefix' => 'install'], function () {
                Route::get('updates/changelog', 'Install\Updates@changelog');
                Route::get('updates/check', 'Install\Updates@check');
                Route::get('updates/update/{alias}/{version}', 'Install\Updates@update');
                Route::get('updates/post/{alias}/{old}/{new}', 'Install\Updates@post');
                Route::post('updates/steps', 'Install\Updates@steps');
                Route::post('updates/download', 'Install\Updates@download');
                Route::post('updates/download', 'Install\Updates@download');
                Route::post('updates/unzip', 'Install\Updates@unzip');
                Route::post('updates/file-copy', 'Install\Updates@fileCopy');
                Route::post('updates/migrate', 'Install\Updates@migrate');
                Route::post('updates/finish', 'Install\Updates@finish');
                Route::resource('updates', 'Install\Updates');
            });

            Route::group(['as' => 'modals.', 'prefix' => 'modals'], function () {
                Route::resource('categories', 'Modals\Categories');
                Route::resource('customers', 'Modals\Customers');
                Route::resource('vendors', 'Modals\Vendors');
                Route::resource('invoices/{invoice}/payment', 'Modals\InvoicePayments', ['middleware' => ['dateformat', 'money']]);
                Route::resource('bills/{bill}/payment', 'Modals\BillPayments', ['middleware' => ['dateformat', 'money']]);
                Route::resource('taxes', 'Modals\Taxes');
            });

            /* @deprecated */
            Route::post('items/items/totalItem', 'Common\Items@totalItem');
        });

        Route::group(['middleware' => ['customermenu', 'permission:read-customer-panel']], function () {
            Route::group(['prefix' => 'customers'], function () {
                Route::get('/', 'Customers\Dashboard@index');

                Route::get('invoices/{invoice}/print', 'Customers\Invoices@printInvoice');
                Route::get('invoices/{invoice}/pdf', 'Customers\Invoices@pdfInvoice');
                Route::post('invoices/{invoice}/payment', 'Customers\Invoices@payment');
                Route::post('invoices/{invoice}/confirm', 'Customers\Invoices@confirm');
                Route::resource('invoices', 'Customers\Invoices');
                Route::resource('payments', 'Customers\Payments');
                Route::resource('transactions', 'Customers\Transactions');
                Route::get('profile/read-invoices', 'Customers\Profile@readOverdueInvoices');
                Route::resource('profile', 'Customers\Profile');

                Route::get('logout', 'Auth\Login@destroy')->name('customer_logout');
            });
        });
    });

    Route::group(['middleware' => 'guest'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::get('login', 'Auth\Login@create')->name('login');
            Route::post('login', 'Auth\Login@store');

            Route::get('forgot', 'Auth\Forgot@create')->name('forgot');
            Route::post('forgot', 'Auth\Forgot@store');

            //Route::get('reset', 'Auth\Reset@create');
            Route::get('reset/{token}', 'Auth\Reset@create')->name('reset');
            Route::post('reset', 'Auth\Reset@store');
        });

        Route::group(['middleware' => 'install'], function () {
            Route::group(['prefix' => 'install'], function () {
                Route::get('/', 'Install\Requirements@show');
                Route::get('requirements', 'Install\Requirements@show');

                Route::get('language', 'Install\Language@create');
                Route::post('language', 'Install\Language@store');

                Route::get('database', 'Install\Database@create');
                Route::post('database', 'Install\Database@store');

                Route::get('settings', 'Install\Settings@create');
                Route::post('settings', 'Install\Settings@store');
            });
        });
    });
});
