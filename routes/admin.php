<?php

    Route::GET('/home', 'AdminController@index')->name('admin.home');

    // Login and Logout
    Route::GET('/', 'LoginController@showLoginForm')->name('admin.login');
    Route::POST('/', 'LoginController@login');
    Route::POST('/logout', 'LoginController@logout')->name('admin.logout');

    // Password Resets
    Route::POST('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::GET('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::POST('/password/reset', 'ResetPasswordController@reset');
    Route::GET('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::GET('/password/change', 'AdminController@showChangePasswordForm')->name('admin.password.change');
    Route::POST('/password/change', 'AdminController@changePassword');

    // Register Admins
    Route::get('/register', 'RegisterController@showRegistrationForm')->name('admin.register');
    Route::post('/register', 'RegisterController@register');
    Route::get('/{admin}/edit', 'RegisterController@edit')->name('admin.edit');
    Route::delete('/{admin}', 'RegisterController@destroy')->name('admin.delete');
    Route::patch('/{admin}', 'RegisterController@update')->name('admin.update');

    // Admin Lists
    Route::get('/show', 'AdminController@show')->name('admin.show');

    // Admin Roles
    Route::post('/{admin}/role/{role}', 'AdminRoleController@attach')->name('admin.attach.roles');
    Route::delete('/{admin}/role/{role}', 'AdminRoleController@detach');

    // Roles
    Route::get('/roles', 'RoleController@index')->name('admin.roles');
    Route::get('/role/create', 'RoleController@create')->name('admin.role.create');
    Route::post('/role/store', 'RoleController@store')->name('admin.role.store');
    Route::delete('/role/{role}', 'RoleController@destroy')->name('admin.role.delete');
    Route::get('/role/{role}/edit', 'RoleController@edit')->name('admin.role.edit');
    Route::patch('/role/{role}', 'RoleController@update')->name('admin.role.update');

    //Students
    Route::GET('/students', 'StudentsController@index')->name('admin.students');
    Route::GET('/students/new', 'StudentsController@new')->name('admin.students.new');
    Route::GET('/students/show/{id}', 'StudentsController@show')->name('admin.students.show');
    Route::POST('/students/new', 'StudentsController@create')->name('admin.students.create');
    Route::GET('students/edit/{id}', 'StudentsController@edit')->name('admin.students.edit');
    Route::POST('students/show{id}', 'StudentsController@update')->name('admin.students.update');
    Route::DELETE('/students/{id}', 'StudentsController@delete')->name('admin.students.delete');
    Route::GET('/students/account/{id}', 'StudentsController@account')->name('admin.students.account');
    Route::POST('students/account{id}', 'StudentsController@newAccount')->name('admin.students.account.new');
    Route::POST('students/account/generate', 'StudentsController@generate')->name('admin.students.account.generate');

    //Studies
    // Route::GET('/studies', 'StudiesController@index')->name('admin.studies');
    // Route::GET('/studies/new', 'StudiesController@new')->name('admin.studies.new');
    // Route::POST('/studies/new', 'StudiesController@create')->name('admin.studies.create');
    // Route::DELETE('/studies/{id}', 'StudiesController@delete')->name('admin.studies.delete');

    //Groups
    Route::GET('/groups', 'GroupsController@index')->name('admin.groups');
    Route::GET('/groups/new', 'GroupsController@new')->name('admin.groups.new');
    Route::POST('/groups/create', 'GroupsController@create')->name('admin.groups.create');

    // Study plans
    Route::GET('/studies', 'StudyPlansController@index')->name('admin.studies');
    Route::GET('/studies/upload', 'StudyPlansController@upload')->name('admin.studies.upload');
    Route::POST('/studies/subjects', 'StudyPlansController@import')->name('admin.studies.import');
    Route::POST('/studies/semesters', 'SemestersController@import')->name('admin.studies.importSemesters');
    Route::GET('/studies/show/{studies_program_code}', 'StudyPlansController@show')->name('admin.studies.show');
    
    // should consider changing route links for Create Post methods

    Route::fallback(function () {
        return abort(404);
    });
