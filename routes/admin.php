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

    // Students
    Route::GET('/studentai', 'StudentsController@index')->name('admin.students');
    Route::GET('/studentai/paieska', 'StudentsController@search')->name('admin.students.search');
    Route::GET('/studentai/filtras', 'StudentsController@filter')->name('admin.students.filter');
    Route::GET('/studentai/{group}', 'StudentsController@get')->name('admin.students.group');
    Route::GET('/studentai/naujas/{group}', 'StudentsController@new')->name('admin.students.new');
    Route::GET('/studentai/rodyti/{id}', 'StudentsController@show')->name('admin.students.show');
    Route::POST('/studentai/kurti', 'StudentsController@create')->name('admin.students.create');
    Route::GET('/studentai/keisti/{id}', 'StudentsController@edit')->name('admin.students.edit');
    Route::POST('/studentai/naujas{id}', 'StudentsController@update')->name('admin.students.update');
    Route::DELETE('/studentai/{id}', 'StudentsController@delete')->name('admin.students.delete');
    Route::GET('/studentai/ikelti/naujas', 'StudentsController@upload')->name('admin.students.upload');
    Route::POST('/studentai/importuoti', 'StudentsController@import')->name('admin.students.import');
    Route::GET('/studentai/atsisiusti', 'StudentsController@download')->name('admin.students.download');
    Route::POST('/studentai/{group}/keisti-semestra', 'StudentsController@changeSemester')->name('admin.students.changeSemester');
    Route::POST('/studentai/{group}/isjungti-paskyra', 'StudentsController@disableAcc')->name('admin.students.disableAcc');

    // Accounts
    Route::GET('/studentai/paskyra/{id}', 'AccountsController@index')->name('admin.students.account');
    Route::GET('/studentai/paskyra/nauja/{id}', 'AccountsController@create')->name('admin.students.account.new');
    Route::POST('/studentai/paskyra/generuoti', 'AccountsController@generate')->name('admin.students.account.generate');
    Route::GET('/studentai/paskyra/rodyti/{id}', 'AccountsController@show')->name('admin.students.account.show');
    Route::POST('/studentai/paskyra/generuoti-grupei', 'AccountsController@groupGenerate')->name('admin.students.account.groupGenerate');
    Route::POST('/studentai/paskyra/naujinti', 'AccountsController@update')->name('admin.students.account.update');
    Route::POST('/studentai/paskyra/trinti', 'AccountsController@delete')->name('admin.students.account.delete');
    Route::GET('/studentai/paskyra/{name}/{last_name}/{email}/{group}/{password}', 'AccountsController@createdAccount')->name('admin.students.account.createdAccount')->middleware('signed');

    // Groups
    Route::GET('/grupes', 'GroupsController@index')->name('admin.groups');
    Route::GET('/grupes/nauja', 'GroupsController@new')->name('admin.groups.new');
    Route::POST('/grupes/kurti', 'GroupsController@create')->name('admin.groups.create');
    Route::GET('/grupes/paieska', 'GroupsController@search')->name('admin.groups.search');

    // Study plans
    Route::GET('/studiju-planai', 'StudyPlansController@index')->name('admin.studies');
    Route::GET('/studiju-planai/ikelti', 'StudyPlansController@upload')->name('admin.studies.upload');
    Route::POST('/studiju-planai/dalykai', 'StudyPlansController@import')->name('admin.studies.import');
    Route::POST('/studiju-planai/semestrai', 'SemestersController@import')->name('admin.studies.importSemesters');
    Route::GET('/studiju-planai/rodyti/{studies_program_code}/{studies_form}', 'StudyPlansController@show')->name('admin.studies.show');
    Route::GET('/studiju-planai/rodyti/{studies_program_code}/{studies_form}/paieska', 'StudyPlansController@search')->name('admin.studies.search');
    Route::GET('/studiju-planai/naujas', 'StudyPlansController@new')->name('admin.studies.new');
    Route::POST('/studiju-planai/kurti', 'StudyPlansController@create')->name('admin.studies.create');
    Route::GET('/studiju-planai/keisti/{id}/{studies_form}', 'StudyPlansController@edit')->name('admin.studies.edit');
    Route::GET('/studiju-planai/keisti/{id}/{studies_form}/paieska', 'StudyPlansController@editSearch')->name('admin.studies.edit.search');
    Route::POST('/studiju-planai/naujinti', 'StudyPlansController@update')->name('admin.studies.update');
    Route::POST('/studiju-planai/trinti/{studies_program_code}/{studies_form}', 'StudyPlansController@delete')->name('admin.studies.delete');
    Route::GET('/studiju-planai/siusti-nl', 'StudyPlansController@downloadFt')->name('admin.studies.downloadFt');
    Route::GET('/studiju-planai/siusti-i', 'StudyPlansController@downloadEx')->name('admin.studies.downloadEx');

    // Settlements
    Route::GET('/atsiskaitymai/{group}', 'SettlementsController@index')->name('admin.settlements');
    Route::GET('/atsiskaitymai/{group}/{subject_code}', 'SettlementsController@show')->name('admin.settlements.show');
    Route::POST('/atsiskaitymai/priskirti-destytoja/{subject_code}', 'SettlementsController@assignTeacher')->name('admin.settlements.assignTeacher');
    Route::POST('/atsiskaitymai/kurti', 'SettlementsController@create')->name('admin.settlements.create');
    Route::GET('/atsiskaitymai/perlaikymai/{group}/{subject_code}', 'SettlementsController@showRetention')->name('admin.settlements.showRetention');
    Route::POST('/atsiskaitymai/spausdinti', 'SettlementsController@print')->name('admin.settlements.print.exam');
    Route::GET('/atsiskaitymai/priskirti-dalyka/grupei/{group}', 'SettlementsController@assignSubject')->name('admin.settlements.assignSubject');
    Route::POST('/atsiskaitymai/priskirti-dalyka/naujinti', 'SettlementsController@updateSubject')->name('admin.settlements.assignSubject.update');
    Route::POST('/atsiskaitymai/naujinti', 'SettlementsController@update')->name('admin.settlements.update');
    
    // Individual evaluations
    Route::GET('/individualus-vertinimas/{group}/{id}', 'EvaluationController@index')->name('admin.students.individual-evaluation');
    Route::GET('/individualus-vertinimas/{group}/{id}/{semester}', 'EvaluationController@show')->name('admin.students.individual-evaluation.semester');
    Route::GET('/individualus-vertinimas/{group}/{id}/{semester}/{subject_code}', 'EvaluationController@edit')->name('admin.students.individual-evaluation.edit');
    Route::POST('/individualus-vertinimas/naujinti/{group}/{id}/{semester}/{subject_code}', 'EvaluationController@update')->name('admin.students.individual-evaluation.update');
    Route::GET('/individualus-vertinimas/skola/{group}/{id}/{semester}/{subject_code}', 'EvaluationController@debt')->name('admin.students.individual-evaluation.debt');
    Route::POST('/individualus-vertinimas/naujinti-skola', 'EvaluationController@debtUpdate')->name('admin.students.individual-evaluation.debtUpdate');

    // Teachers
    Route::GET('/destytojai', 'TeachersController@index')->name('admin.teachers');
    Route::GET('/destytojai/paieska', 'TeachersController@search')->name('admin.teachers.search');
    Route::GET('/destytojai/naujas', 'TeachersController@new')->name('admin.teachers.new');
    Route::POST('/destytojai/kurti', 'TeachersController@create')->name('admin.teachers.create');
    Route::GET('/destytojai/ikelti', 'TeachersController@upload')->name('admin.teachers.upload');
    Route::POST('/destytojai/importuoti', 'TeachersController@import')->name('admin.teachers.import');
    Route::GET('/destytojai/atsiusti', 'TeachersController@download')->name('admin.teachers.download');

    Route::fallback(function () {
        return abort(404);
    });
