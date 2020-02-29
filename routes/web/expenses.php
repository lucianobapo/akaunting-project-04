<?php
            Route::group(['prefix' => 'expenses'], function () {
                Route::get('bills/{bill}/received', 'Expenses\Bills@markReceived');
                Route::get('bills/{bill}/print', 'Expenses\Bills@printBill');
                Route::get('bills/{bill}/pdf', 'Expenses\Bills@pdfBill');
                Route::get('bills/{bill}/duplicate', 'Expenses\Bills@duplicate');
                Route::get('bills/addItem', 'Expenses\Bills@addItem')->middleware(['money'])->name('bill.add.item');
                Route::post('bills/payment', 'Expenses\Bills@payment')->middleware(['dateformat', 'money'])->name('bill.payment');
                Route::delete('bills/payment/{payment}', 'Expenses\Bills@paymentDestroy');
                Route::post('bills/import', 'Expenses\Bills@import')->name('bills.import');
                Route::get('bills/export', 'Expenses\Bills@export')->name('bills.export');
                Route::resource('bills', 'Expenses\Bills', ['middleware' => ['dateformat', 'money']]);
                Route::get('payments/{payment}/duplicate', 'Expenses\Payments@duplicate');
                Route::post('payments/import', 'Expenses\Payments@import')->name('payments.import');
                Route::get('payments/export', 'Expenses\Payments@export')->name('payments.export');
                Route::resource('payments', 'Expenses\Payments', ['middleware' => ['dateformat', 'money']]);
                Route::get('vendors/currency', 'Expenses\Vendors@currency');
                Route::get('vendors/{vendor}/duplicate', 'Expenses\Vendors@duplicate');
                Route::post('vendors/vendor', 'Expenses\Vendors@vendor');
                Route::post('vendors/import', 'Expenses\Vendors@import')->name('vendors.import');
                Route::get('vendors/export', 'Expenses\Vendors@export')->name('vendors.export');
                Route::get('vendors/{vendor}/enable', 'Expenses\Vendors@enable')->name('vendors.enable');
                Route::get('vendors/{vendor}/disable', 'Expenses\Vendors@disable')->name('vendors.disable');
                Route::resource('vendors', 'Expenses\Vendors');
            });