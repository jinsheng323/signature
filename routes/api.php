<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Expensecategories
    Route::apiResource('servicecosts', 'ServicecostApiController');

    // Incomecategories
    Route::apiResource('service-s', 'ServiceApiController');

    // Expenses
    Route::apiResource('sites', 'SiteApiController');

    // Incomes
    Route::apiResource('contracts', 'ContractApiController');


});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1', 'middleware' => ['auth:api']], function () {
Route::apiResource('jobs', 'JobApiController');

});
