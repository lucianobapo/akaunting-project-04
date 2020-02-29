<?php

            Route::group(['prefix' => 'common'], function () {
                Route::get('companies/{company}/set', 'Common\Companies@set')->name('companies.switch');
                Route::get('companies/{company}/enable', 'Common\Companies@enable')->name('companies.enable');
                Route::get('companies/{company}/disable', 'Common\Companies@disable')->name('companies.disable');
                Route::resource('companies', 'Common\Companies');
                Route::get('dashboard/cashflow', 'Common\Dashboard@cashFlow')->name('dashboard.cashflow');
                Route::get('import/{group}/{type}', 'Common\Import@create')->name('import.create');
                Route::get('items/autocomplete', 'Common\Items@autocomplete')->name('items.autocomplete');
                Route::post('items/totalItem', 'Common\Items@totalItem')->middleware(['money'])->name('items.total');
                Route::get('items/{item}/duplicate', 'Common\Items@duplicate')->name('items.duplicate');
                Route::post('items/import', 'Common\Items@import')->name('items.import');
                Route::get('items/export', 'Common\Items@export')->name('items.export');
                Route::get('items/{item}/enable', 'Common\Items@enable')->name('items.enable');
                Route::get('items/{item}/disable', 'Common\Items@disable')->name('items.disable');
                Route::resource('items', 'Common\Items', ['middleware' => ['money']]);
                Route::get('search/search', 'Common\Search@search')->name('search.search');
                Route::resource('search', 'Common\Search');
                Route::post('notifications/disable', 'Common\Notifications@disable')->name('notifications.disable');
            });  