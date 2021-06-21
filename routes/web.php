<?php

//Route::redirect('/', '/jobs');

//Route::group(['prefix' => 'jobs', 'as' => 'jobs.', 'namespace' => 'Job', function () {
    Route::redirect('/', '/login');
    Route::redirect('/jobs', '/login');
    Route::delete('jobs/destroy', 'Job\JobController@massDestroy')->name('jobs.massDestroy');
    Route::get('sites/sitefilter', 'Admin\SiteController@sitefilter')->name('admin.sites.sitefilter');
    Route::get('services/servicefilter', 'Admin\ServiceController@servicefilter')->name('admin.services.servicefilter');
    Route::post('jobs/savesign', 'Job\JobController@savesign')->name('jobs.savesign');
    Route::post('payments/store', 'PaymentController@store')->name('payments.store');
    Route::post('jobs/resavesign', 'Job\JobController@resavesign')->name('jobs.resavesign');
    Route::post('jobs/filter', 'Job\JobController@filter')->name('jobs.filter');

    Route::GET('generate-pay','PDFController@generatepay')->name('generatepay');
    Route::GET('jobs/generatebill/{id}','Job\JobController@generatebill');
    Route::GET('jobs/generatepay1/{id}','Job\JobController@generatepay1');
    Route::resource('jobs', 'Job\JobController');
    Route::resource('payments', 'PaymentController');
    Route::get('/sendemail/send', 'SendEmailController@send')->name('sendmail');
  //});
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
//Route::redirect('/home', '/admin');
Auth::routes();



Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::redirect('/', '/admin/sites');

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');


    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');


    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');


    Route::delete('servicecosts/destroy', 'ServicecostController@massDestroy')->name('servicecosts.massDestroy');
    Route::resource('servicecosts', 'ServicecostController');


    Route::delete('service-s/destroy', 'ServiceController@massDestroy')->name('service-s.massDestroy');
    Route::resource('service-s', 'ServiceController');


    Route::delete('sites/destroy', 'SiteController@massDestroy')->name('sites.massDestroy');
    Route::resource('sites', 'SiteController');


    Route::delete('contract-s/destroy', 'ContractController@massDestroy')->name('contract-s.massDestroy');
    Route::resource('contract-s', 'ContractController');

});
