<?php
Route::group(['middleware' => 'permission:read-admin-panel'], function () {
    Route::group(['prefix' => 'wizard'], function () {
        Route::get('/', 'Wizard\Companies@edit')->name('wizard.index');
        Route::get('companies', 'Wizard\Companies@edit')->name('wizard.companies.edit');
        Route::patch('companies', 'Wizard\Companies@update')->name('wizard.companies.update');

        Route::get('currencies', 'Wizard\Currencies@index')->name('wizard.currencies.index');
        Route::get('currencies/create', 'Wizard\Currencies@create')->name('wizard.currencies.create');
        Route::get('currencies/{currency}/edit', 'Wizard\Currencies@edit')->name('wizard.currencies.edit');
        Route::get('currencies/{currency}/enable', 'Wizard\Currencies@enable')->name('wizard.currencies.enable');
        Route::get('currencies/{currency}/disable', 'Wizard\Currencies@disable')->name('wizard.currencies.disable');
        Route::get('currencies/{currency}/delete', 'Wizard\Currencies@destroy')->name('wizard.currencies.delete');
        Route::post('currencies', 'Wizard\Currencies@store')->name('wizard.currencies.store');
        Route::patch('currencies/{currency}', 'Wizard\Currencies@update')->name('wizard.currencies.update');

        Route::get('taxes', 'Wizard\Taxes@index')->name('wizard.taxes.index');
        Route::get('taxes/create', 'Wizard\Taxes@create')->name('wizard.taxes.create');
        Route::get('taxes/{tax}/edit', 'Wizard\Taxes@edit')->name('wizard.taxes.edit');
        Route::get('taxes/{tax}/enable', 'Wizard\Taxes@enable')->name('wizard.taxes.enable');
        Route::get('taxes/{tax}/disable', 'Wizard\Taxes@disable')->name('wizard.taxes.disable');
        Route::get('taxes/{tax}/delete', 'Wizard\Taxes@destroy')->name('wizard.taxes.delete');
        Route::post('taxes', 'Wizard\Taxes@store')->name('wizard.taxes.store');
        Route::patch('taxes/{tax}', 'Wizard\Taxes@update')->name('wizard.taxes.upadate');

        Route::get('finish', 'Wizard\Finish@index')->name('wizard.finish.index');
    });
});