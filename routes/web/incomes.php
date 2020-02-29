<?php

            Route::group(['prefix' => 'incomes'], function () {
                Route::get('invoices/{invoice}/sent', 'Incomes\Invoices@markSent');
                Route::get('invoices/{invoice}/email', 'Incomes\Invoices@emailInvoice');
                Route::get('invoices/{invoice}/pay', 'Incomes\Invoices@markPaid');
                Route::get('invoices/{invoice}/print', 'Incomes\Invoices@printInvoice');
                Route::get('invoices/{invoice}/pdf', 'Incomes\Invoices@pdfInvoice');
                Route::get('invoices/{invoice}/duplicate', 'Incomes\Invoices@duplicate');
                Route::get('invoices/addItem', 'Incomes\Invoices@addItem')->middleware(['money'])->name('invoice.add.item');
                Route::post('invoices/payment', 'Incomes\Invoices@payment')->middleware(['dateformat', 'money'])->name('invoice.payment');
                Route::delete('invoices/payment/{payment}', 'Incomes\Invoices@paymentDestroy');
                Route::post('invoices/import', 'Incomes\Invoices@import')->name('invoices.import');
                Route::get('invoices/export', 'Incomes\Invoices@export')->name('invoices.export');
                Route::resource('invoices', 'Incomes\Invoices', ['middleware' => ['dateformat', 'money']]);
                Route::get('revenues/{revenue}/duplicate', 'Incomes\Revenues@duplicate');
                Route::post('revenues/import', 'Incomes\Revenues@import')->name('revenues.import');
                Route::get('revenues/export', 'Incomes\Revenues@export')->name('revenues.export');
                Route::resource('revenues', 'Incomes\Revenues', ['middleware' => ['dateformat', 'money']]);
                Route::get('customers/currency', 'Incomes\Customers@currency');
                Route::get('customers/{customer}/duplicate', 'Incomes\Customers@duplicate');
                Route::post('customers/customer', 'Incomes\Customers@customer');
                Route::post('customers/field', 'Incomes\Customers@field');
                Route::post('customers/import', 'Incomes\Customers@import')->name('customers.import');
                Route::get('customers/export', 'Incomes\Customers@export')->name('customers.export');
                Route::get('customers/{customer}/enable', 'Incomes\Customers@enable')->name('customers.enable');
                Route::get('customers/{customer}/disable', 'Incomes\Customers@disable')->name('customers.disable');
                Route::resource('customers', 'Incomes\Customers');
            });