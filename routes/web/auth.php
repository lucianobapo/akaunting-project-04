<?php
Route::group(['prefix' => 'auth'], function () {
    Route::get('logout', 'Auth\Login@destroy')->name('logout');
    Route::get('users/autocomplete', 'Auth\Users@autocomplete');
    Route::get('users/{user}/read-bills', 'Auth\Users@readUpcomingBills');
    Route::get('users/{user}/read-invoices', 'Auth\Users@readOverdueInvoices');
    Route::get('users/{user}/read-items', 'Auth\Users@readItemsOutOfStock');
    Route::get('users/{user}/enable', 'Auth\Users@enable')->name('users.enable');
    Route::get('users/{user}/disable', 'Auth\Users@disable')->name('users.disable');
    Route::resource('users', 'Auth\Users');
    Route::resource('roles', 'Auth\Roles');
    Route::resource('permissions', 'Auth\Permissions');
});