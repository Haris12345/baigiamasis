<?php

    Route::GET('/pagrindinis-pusl', 'AdminController@index')->name('admin.home');
    // Login and Logout
    Route::GET('/', 'LoginController@showLoginForm')->name('admin.login');
    Route::POST('/', 'LoginController@login');
    Route::POST('/atsijungti', 'LoginController@logout')->name('admin.logout');

    // Password Resets
    Route::POST('/slaptazodis/el-pastas', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::GET('/slaptazodis/atnaujinti', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::POST('/slaptazodis/atnaujinti', 'ResetPasswordController@reset');
    Route::GET('/slaptazodis/atnaujinti/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::GET('/slaptazodis/pakeisti', 'AdminController@showChangePasswordForm')->name('admin.password.change');
    Route::POST('/slaptazodis/pakeisti', 'AdminController@changePassword');

    // Register Admins
    Route::get('/registruoti', 'RegisterController@showRegistrationForm')->name('admin.register');
    Route::post('/registruoti', 'RegisterController@register');
    Route::get('/{admin}/keisti', 'RegisterController@edit')->name('admin.edit');
    Route::delete('/{admin}', 'RegisterController@destroy')->name('admin.delete');
    Route::patch('/{admin}', 'RegisterController@update')->name('admin.update');

    // Admin Lists
    Route::get('/administratoriai', 'AdminController@show')->name('admin.show');

    // Admin Roles
    Route::post('/{admin}/role/{role}', 'AdminRoleController@attach')->name('admin.attach.roles');
    Route::delete('/{admin}/role/{role}', 'AdminRoleController@detach');

    // // Roles
    // Route::get('/roles', 'RoleController@index')->name('admin.roles');
    // Route::get('/role/create', 'RoleController@create')->name('admin.role.create');
    // Route::post('/role/store', 'RoleController@store')->name('admin.role.store');
    // Route::delete('/role/{role}', 'RoleController@destroy')->name('admin.role.delete');
    // Route::get('/role/{role}/edit', 'RoleController@edit')->name('admin.role.edit');
    // Route::patch('/role/{role}', 'RoleController@update')->name('admin.role.update');

    Route::fallback(function () {
        return abort(404);
    });
