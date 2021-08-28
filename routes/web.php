<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

 Route::get('/user/reset/{token?}', 'UserController@getReset');
 Route::POST('/user/doreset/{token?}', 'UserController@postDoreset');

// Route::resource('/home', 'HomeController');
Route::get('home', 'HomeController@index');
Route::get('home/lang/{one?}/{two?}/{three?}/{four?}/{five?}', 'HomeController@getLang');
// Route::get('service', 'HomeController@index');
Route::get('about-us', 'HomeController@index');
Route::get('contact-us', 'HomeController@index');
Route::get('faq', 'HomeController@index');
Route::get('portpolio', 'HomeController@index');

// Route::resource('/user', 'UserController');
Route::get('/user/login', 'UserController@getlogin')->name('login');
Route::post('/user/signin', 'UserController@postSignin');
Route::post('/user/request/{one?}/{two?}/{three?}/{four?}/{five?}', 'UserController@postRequest');
Route::get('/user/profile', 'UserController@getProfile');
Route::get('/user/logout', 'UserController@getLogout');
Route::post('/user/saveprofile', 'UserController@postSaveprofile');
Route::post('/user/savepassword', 'UserController@postSavepassword');

Route::group(['middleware' => 'auth'], function () {

    Route::get('core/elfinder', 'Core\ElfinderController@getIndex');
    Route::post('core/elfinder', 'Core\ElfinderController@getIndex');

    // Route::controller('/dashboard', 'DashboardController');
    Route::get('/', 'DashboardController@getIndex');
    Route::get('/dashboard', 'DashboardController@getIndex');

    // Route::controllers([
    //     'core/logs' => 'Core\LogsController',
    //     'core/pages' => 'Core\PagesController',
    // ]);

    //'core/users'        => 'Core\UsersController',
    Route::get('/core/users', 'Core\UsersController@getIndex');
    Route::post('/core/users/filter', 'Core\UsersController@postFilter');
    Route::get('/core/users/update', 'Core\UsersController@getUpdate');
    Route::post('/core/users/delete', 'Core\UsersController@postDelete');
    Route::post('/core/users/save', 'Core\UsersController@postSave');
    Route::get('/core/users/show/{id}', 'Core\UsersController@getShow');
    Route::get('/core/users/update/{id}', 'Core\UsersController@getUpdate');

    Route::post('core/users/search', 'Core\UsersController@postSearch');
    Route::get('searchTables/', 'SearchTablesController@index');
    Route::get('searchTables/search', 'SearchTablesController@search');
    Route::get('searchTables/download', 'SearchTablesController@download');
    Route::get('provider_info/{id}','ContractsController@get_provider');


    //'core/groups'         => 'Core\GroupsController',
    Route::get('/core/groups', 'Core\GroupsController@getIndex');
    Route::post('/core/groups/filter', 'Core\GroupsController@postFilter');
    Route::get('/core/groups/update', 'Core\GroupsController@getUpdate');
    Route::get('/core/groups/download', 'Core\GroupsController@getDownload');
    Route::post('/core/groups/delete', 'Core\GroupsController@postDelete');
    Route::get('/core/groups/show/{id}', 'Core\GroupsController@getShow');
    Route::get('/core/groups/update/{id}', 'Core\GroupsController@getUpdate');
    Route::post('/core/groups/save', 'Core\GroupsController@postSave');

    //'core/template'     => 'Core\TemplateController',
    Route::get('/core/template', 'Core\TemplateController@getIndex');

});


Route::get('/test', 'DashboardController@getTest');

Route::group(['middleware' => 'auth', 'middleware' => 'sximoauth'], function () {

    //'sximo/config'         => 'Sximo\ConfigController',
    Route::get('/sximo/config', 'Sximo\ConfigController@getIndex');
    Route::post('/sximo/config/save', 'Sximo\ConfigController@postSave');
    Route::get('/sximo/config/clearlog', 'Sximo\ConfigController@getClearlog');
    Route::get('/sximo/config/log', 'Sximo\ConfigController@getLog');

    //'sximo/module'         => 'Sximo\ModuleController',
    Route::get('/sximo/module', 'Sximo\ModuleController@getIndex');
    Route::get('/sximo/module/create', 'Sximo\ModuleController@getCreate');
    Route::get('/sximo/module/destroy/{id}', 'Sximo\ModuleController@getDestroy');
    Route::post('/sximo/module/create', 'Sximo\ModuleController@postCreate');
    Route::post('/sximo/module/create', 'Sximo\ModuleController@postCreate');
    Route::get('/sximo/module/config/{id}', 'Sximo\ModuleController@getConfig');
    Route::post('/sximo/module/saveconfig/{id}', 'Sximo\ModuleController@postSaveconfig');
    Route::post('/sximo/module/install', 'Sximo\ModuleController@postInstall');
    Route::post('/sximo/module/package', 'Sximo\ModuleController@postPackage');
    Route::post('/sximo/module/dopackage', 'Sximo\ModuleController@postDopackage');
    Route::get('/sximo/module/permission/{id}', 'Sximo\ModuleController@getPermission');
    Route::post('/sximo/module/savepermission/{id}', 'Sximo\ModuleController@postSavepermission');
    Route::get('/sximo/module/rebuild/{id}', 'Sximo\ModuleController@getRebuild');
    Route::get('/sximo/module/sql/{id}', 'Sximo\ModuleController@getSql');
    Route::post('/sximo/module/savesql/{id}', 'Sximo\ModuleController@postSavesql');
    Route::get('/sximo/module/table/{id}', 'Sximo\ModuleController@getTable');
    Route::post('/sximo/module/savetable/{id}', 'Sximo\ModuleController@postSavetable');
    Route::get('/sximo/module/conn/{id}', 'Sximo\ModuleController@getConn');
    Route::post('/sximo/module/conn/{id}', 'Sximo\ModuleController@postConn');
    Route::post('/sximo/module/combotable', 'Sximo\ModuleController@postCombotable');
    Route::post('/sximo/module/combotablefield', 'Sximo\ModuleController@postcombotablefield');
    Route::get('/sximo/module/form/{id}', 'Sximo\ModuleController@getForm');
    Route::post('/sximo/module/saveform/{id}', 'Sximo\ModuleController@postSaveform');
    Route::get('/sximo/module/editform/{id}', 'Sximo\ModuleController@getEditform');
    Route::get('/sximo/module/formdesign/{id}', 'Sximo\ModuleController@getFormdesign');
    Route::post('/sximo/module/formdesign/{id}', 'Sximo\ModuleController@postFormdesign');
    Route::get('/sximo/module/sub/{id}', 'Sximo\ModuleController@getSub');
    Route::get('/sximo/module/savesub/{id}', 'Sximo\ModuleController@postSavesub');
    Route::get('/sximo/module/build/{id}', 'Sximo\ModuleController@getBuild');
    Route::post('/sximo/module/dobuild/{id}', 'Sximo\ModuleController@postDobuild');

    //'sximo/tables'        => 'Sximo\TablesController'
    Route::get('/sximo/tables', 'Sximo\TablesController@getIndex');
    Route::get('/sximo/tables/tableconfig/{table}', 'Sximo\TablesController@getTableconfig');
    Route::get('/sximo/tables/sximo/tables/mysqleditor', 'Sximo\TablesController@getMysqleditor');
    Route::get('sximo/tables/tableconfig', 'Sximo\TablesController@getTableconfig');
    Route::get('sximo/tables/tablefieldedit/{any}', 'Sximo\TablesController@getTablefieldedit');
    Route::get('sximo/tables/tablefieldremove/{id?}/{id2?}', 'Sximo\TablesController@getTablefieldremove');
    Route::post('sximo/tables/tableremove', 'Sximo\TablesController@postTableremove');
    Route::post('sximo/tables/tableinfo/{any}', 'Sximo\TablesController@postTableinfo');
    Route::get('sximo/tables/mysqleditor', 'Sximo\TablesController@postMysqleditor');
    Route::post('sximo/tables/tablefieldsave/{any?}', 'Sximo\TablesController@postTablefieldsave');
    Route::post('sximo/tables/tables', 'Sximo\TablesController@postTables');

    //'sximo/menu'        => 'Sximo\MenuController',
    Route::get('/sximo/menu', 'Sximo\MenuController@getIndex');
    Route::get('/sximo/menu/index/{id}', 'Sximo\MenuController@getIndex');
    Route::post('/sximo/menu/saveorder', 'Sximo\MenuController@postSaveorder');
    Route::post('/sximo/menu/save', 'Sximo\MenuController@postSave');
    Route::get('/sximo/menu/destroy/{id}', 'Sximo\MenuController@getDestroy');

});

Route::group(['middleware' => 'auth'], function () {
    // apiAuth

    //Route::post('api/password/email', 'Api\Auth\PasswordController@postEmail');

    Route::get('api/news', 'Api\NewsController@getNews');
    //Route::post('api/news', 'Api\NewsController@postNews');

    Route::get('api/check', 'Api\ActivitiesController@getCheck');
    //Route::post('api/check', 'Api\ActivitiesController@postCheck');

    Route::get('api/exception', 'Api\ActivitiesController@getException');
    //Route::post('api/exception', 'Api\ActivitiesController@postException');

    Route::get('api/attendance', 'Api\ActivitiesController@getAttendance');
    //  Route::post('api/attendance', 'Api\ActivitiesController@postAttendance');

    Route::get('api/salary', 'Api\ActivitiesController@getSalary');
    //Route::post('api/salary', 'Api\ActivitiesController@postSalary');

});

Route::get('api/all', 'Api\ActivitiesController@getAll');
Route::get('api/password/email', 'Api\Auth\PasswordController@getEmail');
Route::post('api/password/email', 'Api\Auth\PasswordController@postEmail');
Route::post('api/check', 'Api\ActivitiesController@postCheck');
Route::post('api/exception', 'Api\ActivitiesController@postException');
Route::post('api/attendance', 'Api\ActivitiesController@postAttendance');
Route::post('api/salary', 'Api\ActivitiesController@postSalary');
Route::post('api/news', 'Api\NewsController@postNews');
Route::post('api/password/email', 'Api\Auth\PasswordController@postEmail');
Route::get('api/password/email', 'Api\Auth\PasswordController@getEmail');
Route::get('api/auth/login', 'Api\Auth\AuthController@getLogin');
Route::get('api/auth/logout', 'Api\Auth\AuthController@getLogout');
Route::post('api/auth/login', 'Api\Auth\AuthController@postLogin');
Route::get('api/inquiries', 'Api\InquiriesController@getInquiriesList');
Route::post('api/inquiriesList', 'Api\InquiriesController@postInquiriesList');
Route::get('api/inquiry', 'Api\InquiriesController@getInquiryView');
Route::post('api/inquiryView', 'Api\InquiriesController@postInquiryView');
Route::get('api/replay', 'Api\InquiriesController@getInquiryReply');
Route::post('api/replay', 'Api\InquiriesController@postInquiryReply');
Route::get('api/inquiryCreate', 'Api\InquiriesController@getInquiryCreate');
Route::post('api/inquiryCreate', 'Api\InquiriesController@postInquiryCreate');
Route::post('api/departments', 'Api\InquiriesController@postDepartments');
Route::post('api/employees', 'Api\InquiriesController@postEmployees');
Route::get('api/employees', 'Api\InquiriesController@getEmployees');
Route::get('api/checkApp', 'Api\DemoController@getAppStatus');
Route::post('api/checkApp', 'Api\DemoController@postAppStatus');
Route::get('api/last-activity', 'Api\ActivitiesController@getLastActivity');
Route::post('api/last-activity', 'Api\ActivitiesController@postLastActivity');
Route::get('api/username', 'Api\ProfileController@getUsername');
Route::post('api/username', 'Api\ProfileController@postUsername');
Route::get('api/avatar', 'Api\ProfileController@getAvatar');
Route::post('api/avatar', 'Api\ProfileController@postAvatar2');
Route::get('api/chat-login', 'Api\ActivitiesController@getChatLogin');
Route::post('api/chat-login', 'Api\ActivitiesController@postChatLogin');

//
Route::post('notifyclient', 'SubscribersController@notifyclient');
Route::post('notifyclient.php', 'SubscribersController@notifyclient');

Route::get('checksub', 'SubscribersController@checksub');
Route::get('checkphone', 'SubscribersController@checkphone');
Route::get('getPhone', 'SubscribersController@getPhone');

Route::get('addUpdateSubscriber', 'SubscribersController@addUpdateSubscriber');
Route::get('checkVcode', 'SubscribersController@checkVcode');
Route::get('setActiveWebLogin', 'SubscribersController@setActiveWebLogin');
Route::get('webAppLogin', 'SubscribersController@webAppLogin');
Route::get('setActiveWebLogout', 'SubscribersController@setActiveWebLogout');

// route by f
Route::get('phone/fromFile', 'PhonesController@fromFileForm');
Route::get('phone/newSubscriberDownload', 'PhonesController@newSubscriberDownload');
Route::post('phone/saveFromFile', 'PhonesController@saveFromFile');
Route::get('phone/newSubscriberDownload', 'PhonesController@newSubscriberDownload');

Route::post('api/checkExists', 'SubscribersController@checkExists');

Route::get('randomActiveSubscriber', 'SubscribersController@randomActiveSubscriber');
Route::get('downloadSubscribersCategory/{id}', 'PhonescategoriesController@downloadSub');

Route::get('updateSubscribers', 'SubscribersController@updateSubscribers');
//life time
Route::get('subscribe_liftime', 'SubscribersLifeTimeController@index');
Route::get('subscribe_liftime/search', 'SubscribersLifeTimeController@search');


//my vacations
Route::get('myvacations', 'MyvacationsController@getIndex');
Route::get('myvacations/update', 'MyvacationsController@getUpdate');
Route::get('myvacations/update/{id}', 'MyvacationsController@getUpdate');
Route::get('myvacations/show/{id}', 'MyvacationsController@getShow');
Route::post('myvacations/save', 'MyvacationsController@postSave');
Route::post('myvacations/delete', 'MyvacationsController@postDelete');
Route::post('myvacations/multisearch', 'MyvacationsController@postMultisearch');
Route::post('myvacations/filter', 'MyvacationsController@postFilter');
Route::get('myvacations/download', 'MyvacationsController@getDownload');
Route::post('myvacations/comboselect', 'MyvacationsController@postComboselect');
Route::post('myvacations/comboselectuser', 'MyvacationsController@postComboselectuser');
Route::get('myvacations/combotable', 'MyvacationsController@getCombotable');
Route::get('myvacations/combotablefield', 'MyvacationsController@getCombotablefield');

//my mypermissions
Route::get('mypermissions', 'MypermissionsController@getIndex');
Route::get('mypermissions/update', 'MypermissionsController@getUpdate');
Route::get('mypermissions/update/{id}', 'MypermissionsController@getUpdate');
Route::get('mypermissions/show/{id}', 'MypermissionsController@getShow');
Route::post('mypermissions/save', 'MypermissionsController@postSave');
Route::post('mypermissions/delete', 'MypermissionsController@postDelete');
Route::post('mypermissions/multisearch', 'MypermissionsController@postMultisearch');
Route::post('mypermissions/filter', 'MypermissionsController@postFilter');
Route::get('mypermissions/download', 'MypermissionsController@getDownload');
Route::post('mypermissions/comboselect', 'MypermissionsController@postComboselect');
Route::post('mypermissions/comboselectuser', 'MypermissionsController@postComboselectuser');
Route::get('mypermissions/combotable', 'MypermissionsController@getCombotable');
Route::get('mypermissions/combotablefield', 'MypermissionsController@getCombotablefield');


//my permissions
Route::get('permissions', 'PermissionsController@getIndex');
Route::get('permissions/update', 'PermissionsController@getUpdate');
Route::get('permissions/update/{id}', 'PermissionsController@getUpdate');
Route::get('permissions/show/{id}', 'PermissionsController@getShow');
Route::post('permissions/save', 'PermissionsController@postSave');
Route::post('permissions/delete', 'PermissionsController@postDelete');
Route::post('permissions/multisearch', 'PermissionsController@postMultisearch');
Route::post('permissions/filter', 'PermissionsController@postFilter');
Route::get('permissions/download', 'PermissionsController@getDownload');
Route::post('permissions/comboselect', 'PermissionsController@postComboselect');
Route::post('permissions/comboselectuser', 'PermissionsController@postComboselectuser');
Route::get('permissions/combotable', 'PermissionsController@getCombotable');
Route::get('permissions/combotablefield', 'PermissionsController@getCombotablefield');
Route::get('permissions/makepdfvacation/{one?}/{two?}/{three?}/{four?}/{five?}', 'PermissionsController@getMakepdfvacation');

//employeespermissions
Route::get('employeespermissions', 'EmployeespermissionsController@getIndex');
Route::get('employeespermissions/update', 'EmployeespermissionsController@getUpdate');
Route::get('employeespermissions/update/{id}', 'EmployeespermissionsController@getUpdate');
Route::get('employeespermissions/show/{id}', 'EmployeespermissionsController@getShow');
Route::post('employeespermissions/save', 'EmployeespermissionsController@postSave');
Route::post('employeespermissions/delete', 'EmployeespermissionsController@postDelete');
Route::post('employeespermissions/multisearch', 'EmployeespermissionsController@postMultisearch');
Route::post('employeespermissions/filter', 'EmployeespermissionsController@postFilter');
Route::get('employeespermissions/download', 'EmployeespermissionsController@getDownload');
Route::post('employeespermissions/comboselect', 'EmployeespermissionsController@postComboselect');
Route::post('employeespermissions/comboselectuser', 'EmployeespermissionsController@postComboselectuser');
Route::get('employeespermissions/combotable', 'EmployeespermissionsController@getCombotable');
Route::get('employeespermissions/combotablefield', 'EmployeespermissionsController@getCombotablefield');


//vacations
Route::get('vacations', 'VacationsController@getIndex');
Route::get('vacations/update', 'VacationsController@getUpdate');
Route::get('vacations/update/{id}', 'VacationsController@getUpdate');
Route::get('vacations/show/{id}', 'VacationsController@getShow');
Route::post('vacations/save', 'VacationsController@postSave');
Route::post('vacations/delete', 'VacationsController@postDelete');
Route::post('vacations/multisearch', 'VacationsController@postMultisearch');
Route::post('vacations/filter', 'VacationsController@postFilter');
Route::get('vacations/download', 'VacationsController@getDownload');
Route::post('vacations/comboselect', 'VacationsController@postComboselect');
Route::post('vacations/comboselectuser', 'VacationsController@postComboselectuser');
Route::get('vacations/combotable', 'VacationsController@getCombotable');
Route::get('vacations/combotablefield', 'VacationsController@getCombotablefield');
Route::get('vacations/makepdfvacation', 'VacationsController@getMakepdfvacation');



//vacationtypes
Route::get('vacationtypes', 'VacationtypesController@getIndex');
Route::get('vacationtypes/update', 'VacationtypesController@getUpdate');
Route::get('vacationtypes/update/{id}', 'VacationtypesController@getUpdate');
Route::get('vacationtypes/show/{id}', 'VacationtypesController@getShow');
Route::post('vacationtypes/save', 'VacationtypesController@postSave');
Route::post('vacationtypes/delete', 'VacationtypesController@postDelete');
Route::post('vacationtypes/multisearch', 'VacationtypesController@postMultisearch');
Route::post('vacationtypes/filter', 'VacationtypesController@postFilter');
Route::get('vacationtypes/download', 'VacationtypesController@getDownload');
Route::post('vacationtypes/comboselect', 'VacationtypesController@postComboselect');
Route::post('vacationtypes/comboselectuser', 'VacationtypesController@postComboselectuser');
Route::get('vacationtypes/combotable', 'VacationtypesController@getCombotable');
Route::get('vacationtypes/combotablefield', 'VacationtypesController@getCombotablefield');


//employeesvacations
Route::get('employeesvacations', 'EmployeesvacationsController@getIndex');
Route::get('employeesvacations/update', 'EmployeesvacationsController@getUpdate');
Route::get('employeesvacations/update/{id}', 'EmployeesvacationsController@getUpdate');
Route::get('employeesvacations/show/{id}', 'EmployeesvacationsController@getShow');
Route::post('employeesvacations/save', 'EmployeesvacationsController@postSave');
Route::post('employeesvacations/delete', 'EmployeesvacationsController@postDelete');
Route::post('employeesvacations/multisearch', 'EmployeesvacationsController@postMultisearch');
Route::post('employeesvacations/filter', 'EmployeesvacationsController@postFilter');
Route::get('employeesvacations/download', 'EmployeesvacationsController@getDownload');
Route::post('employeesvacations/comboselect', 'EmployeesvacationsController@postComboselect');
Route::post('employeesvacations/comboselectuser', 'EmployeesvacationsController@postComboselectuser');
Route::get('employeesvacations/combotable', 'EmployeesvacationsController@getCombotable');
Route::get('employeesvacations/combotablefield', 'EmployeesvacationsController@getCombotablefield');

//occationscategories
Route::get('occationscategories', 'OccationscategoriesController@getIndex');
Route::get('occationscategories/update', 'OccationscategoriesController@getUpdate');
Route::get('occationscategories/update/{id}', 'OccationscategoriesController@getUpdate');
Route::get('occationscategories/show/{id}', 'OccationscategoriesController@getShow');
Route::post('occationscategories/save', 'OccationscategoriesController@postSave');
Route::post('occationscategories/delete', 'OccationscategoriesController@postDelete');
Route::post('occationscategories/multisearch', 'OccationscategoriesController@postMultisearch');
Route::post('occationscategories/filter', 'OccationscategoriesController@postFilter');
Route::get('occationscategories/download', 'OccationscategoriesController@getDownload');
Route::post('occationscategories/comboselect', 'OccationscategoriesController@postComboselect');
Route::post('occationscategories/comboselectuser', 'OccationscategoriesController@postComboselectuser');
Route::get('occationscategories/combotable', 'OccationscategoriesController@getCombotable');
Route::get('occationscategories/combotablefield', 'OccationscategoriesController@getCombotablefield');



//overtimes
Route::get('overtimes', 'OvertimesController@getIndex');
Route::get('overtimes/update', 'OvertimesController@getUpdate');
Route::get('overtimes/update/{id}', 'OvertimesController@getUpdate');
Route::get('overtimes/show/{id}', 'OvertimesController@getShow');
Route::post('overtimes/save', 'OvertimesController@postSave');
Route::post('overtimes/delete', 'OvertimesController@postDelete');
Route::post('overtimes/multisearch', 'OvertimesController@postMultisearch');
Route::post('overtimes/filter', 'OvertimesController@postFilter');
Route::get('overtimes/download', 'OvertimesController@getDownload');
Route::post('overtimes/comboselect', 'OvertimesController@postComboselect');
Route::post('overtimes/comboselectuser', 'OvertimesController@postComboselectuser');
Route::get('overtimes/combotable', 'OvertimesController@getCombotable');
Route::get('overtimes/combotablefield', 'OvertimesController@getCombotablefield');
Route::get('overtimes/makepdfvacation', 'OvertimesController@getMakepdfvacation');
Route::post('overtimes/employee-overtimes', 'OvertimesController@getEmployeeOvertimes')->name("employee.overtimes");



//myovertime
Route::get('myovertime', 'MyovertimeController@getIndex');
Route::get('myovertime/update', 'MyovertimeController@getUpdate');
Route::get('myovertime/update/{id}', 'MyovertimeController@getUpdate');
Route::get('myovertime/show/{id}', 'MyovertimeController@getShow');
Route::post('myovertime/save', 'MyovertimeController@postSave');
Route::post('myovertime/delete', 'MyovertimeController@postDelete');
Route::post('myovertime/multisearch', 'MyovertimeController@postMultisearch');
Route::post('myovertime/filter', 'MyovertimeController@postFilter');
Route::get('myovertime/download', 'MyovertimeController@getDownload');
Route::post('myovertime/comboselect', 'MyovertimeController@postComboselect');
Route::post('myovertime/comboselectuser', 'MyovertimeController@postComboselectuser');
Route::get('myovertime/combotable', 'MyovertimeController@getCombotable');
Route::get('myovertime/combotablefield', 'MyovertimeController@getCombotablefield');


//employeesovertime
Route::get('employeesovertime', 'EmployeesovertimeController@getIndex');
Route::get('employeesovertime/update', 'EmployeesovertimeController@getUpdate');
Route::get('employeesovertime/update/{id}', 'EmployeesovertimeController@getUpdate');
Route::get('employeesovertime/show/{id}', 'EmployeesovertimeController@getShow');
Route::post('employeesovertime/save', 'EmployeesovertimeController@postSave');
Route::post('employeesovertime/delete', 'EmployeesovertimeController@postDelete');
Route::post('employeesovertime/multisearch', 'EmployeesovertimeController@postMultisearch');
Route::post('employeesovertime/filter', 'EmployeesovertimeController@postFilter');
Route::get('employeesovertime/download', 'EmployeesovertimeController@getDownload');
Route::post('employeesovertime/comboselect', 'EmployeesovertimeController@postComboselect');
Route::post('employeesovertime/comboselectuser', 'EmployeesovertimeController@postComboselectuser');
Route::get('employeesovertime/combotable', 'EmployeesovertimeController@getCombotable');
Route::get('employeesovertime/combotablefield', 'EmployeesovertimeController@getCombotablefield');


//meetings
Route::get('meetings', 'MeetingsController@getIndex');
Route::get('meetings/update', 'MeetingsController@getUpdate');
Route::get('meetings/update/{id}', 'MeetingsController@getUpdate');
Route::get('meetings/show/{id}', 'MeetingsController@getShow');
Route::post('meetings/save', 'MeetingsController@postSave');
Route::post('meetings/delete', 'MeetingsController@postDelete');
Route::post('meetings/multisearch', 'MeetingsController@postMultisearch');
Route::post('meetings/filter', 'MeetingsController@postFilter');
Route::get('meetings/download', 'MeetingsController@getDownload');
Route::post('meetings/comboselect', 'MeetingsController@postComboselect');
Route::post('meetings/comboselectuser', 'MeetingsController@postComboselectuser');
Route::get('meetings/combotable', 'MeetingsController@getCombotable');
Route::get('meetings/combotablefield', 'MeetingsController@getCombotablefield');
Route::get('meetings/makepdfvacation', 'MeetingsController@getMakepdfvacation');


//mymeetings
Route::get('mymeetings', 'MymeetingsController@getIndex');
Route::get('mymeetings/update', 'MymeetingsController@getUpdate');
Route::get('mymeetings/update/{id}', 'MymeetingsController@getUpdate');
Route::get('mymeetings/show/{id}', 'MymeetingsController@getShow');
Route::post('mymeetings/save', 'MymeetingsController@postSave');
Route::post('mymeetings/delete', 'MymeetingsController@postDelete');
Route::post('mymeetings/multisearch', 'MymeetingsController@postMultisearch');
Route::post('mymeetings/filter', 'MymeetingsController@postFilter');
Route::get('mymeetings/download', 'MymeetingsController@getDownload');
Route::post('mymeetings/comboselect', 'MymeetingsController@postComboselect');
Route::post('mymeetings/comboselectuser', 'MymeetingsController@postComboselectuser');
Route::get('mymeetings/combotable', 'MymeetingsController@getCombotable');
Route::get('mymeetings/combotablefield', 'MymeetingsController@getCombotablefield');



//employeesmeetings
Route::get('employeesmeetings', 'EmployeesmeetingsController@getIndex');
Route::get('employeesmeetings/update', 'EmployeesmeetingsController@getUpdate');
Route::get('employeesmeetings/update/{id}', 'EmployeesmeetingsController@getUpdate');
Route::get('employeesmeetings/show/{id}', 'EmployeesmeetingsController@getShow');
Route::post('employeesmeetings/save', 'EmployeesmeetingsController@postSave');
Route::post('employeesmeetings/delete', 'EmployeesmeetingsController@postDelete');
Route::post('employeesmeetings/multisearch', 'EmployeesmeetingsController@postMultisearch');
Route::post('employeesmeetings/filter', 'EmployeesmeetingsController@postFilter');
Route::get('employeesmeetings/download', 'EmployeesmeetingsController@getDownload');
Route::post('employeesmeetings/comboselect', 'EmployeesmeetingsController@postComboselect');
Route::post('employeesmeetings/comboselectuser', 'EmployeesmeetingsController@postComboselectuser');
Route::get('employeesmeetings/combotable', 'EmployeesmeetingsController@getCombotable');
Route::get('employeesmeetings/combotablefield', 'EmployeesmeetingsController@getCombotablefield');


//notifications
Route::get('notifications', 'NotificationsController@getIndex');
Route::get('notifications/update', 'NotificationsController@getUpdate');
Route::get('notifications/update/{id}', 'NotificationsController@getUpdate');
Route::get('notifications/show/{id}', 'NotificationsController@getShow');
Route::post('notifications/save', 'NotificationsController@postSave');
Route::post('notifications/delete', 'NotificationsController@postDelete');
Route::post('notifications/multisearch', 'NotificationsController@postMultisearch');
Route::post('notifications/filter', 'NotificationsController@postFilter');
Route::get('notifications/download', 'NotificationsController@getDownload');
Route::post('notifications/comboselect', 'NotificationsController@postComboselect');
Route::post('notifications/comboselectuser', 'NotificationsController@postComboselectuser');
Route::get('notifications/combotable', 'NotificationsController@getCombotable');
Route::get('notifications/combotablefield', 'NotificationsController@getCombotablefield');



//operator
Route::get('operator', 'OperatorController@getIndex');
Route::get('operator/update', 'OperatorController@getUpdate');
Route::get('operator/update/{id}', 'OperatorController@getUpdate');
Route::get('operator/show/{id}', 'OperatorController@getShow');
Route::post('operator/save', 'OperatorController@postSave');
Route::post('operator/delete', 'OperatorController@postDelete');
Route::post('operator/multisearch', 'OperatorController@postMultisearch');
Route::post('operator/filter', 'OperatorController@postFilter');
Route::get('operator/download', 'OperatorController@getDownload');
Route::post('operator/comboselect', 'OperatorController@postComboselect');
Route::post('operator/comboselectuser', 'OperatorController@postComboselectuser');
Route::get('operator/combotable', 'OperatorController@getCombotable');
Route::get('operator/combotablefield', 'OperatorController@getCombotablefield');


//visadays
Route::get('visadays', 'VisadaysController@getIndex');
Route::get('visadays/update', 'VisadaysController@getUpdate');
Route::get('visadays/update/{id}', 'VisadaysController@getUpdate');
Route::get('visadays/show/{id}', 'VisadaysController@getShow');
Route::post('visadays/save', 'VisadaysController@postSave');
Route::post('visadays/delete', 'VisadaysController@postDelete');
Route::post('visadays/multisearch', 'VisadaysController@postMultisearch');
Route::post('visadays/filter', 'VisadaysController@postFilter');
Route::get('visadays/download', 'VisadaysController@getDownload');
Route::post('visadays/comboselect', 'VisadaysController@postComboselect');
Route::post('visadays/comboselectuser', 'VisadaysController@postComboselectuser');
Route::get('visadays/combotable', 'VisadaysController@getCombotable');
Route::get('visadays/combotablefield', 'VisadaysController@getCombotablefield');


//perdiempositions
Route::get('perdiempositions', 'PerdiempositionsController@getIndex');
Route::get('perdiempositions/update', 'PerdiempositionsController@getUpdate');
Route::get('perdiempositions/update/{id}', 'PerdiempositionsController@getUpdate');
Route::get('perdiempositions/show/{id}', 'PerdiempositionsController@getShow');
Route::post('perdiempositions/save', 'PerdiempositionsController@postSave');
Route::post('perdiempositions/delete', 'PerdiempositionsController@postDelete');
Route::post('perdiempositions/multisearch', 'PerdiempositionsController@postMultisearch');
Route::post('perdiempositions/filter', 'PerdiempositionsController@postFilter');
Route::get('perdiempositions/download', 'PerdiempositionsController@getDownload');
Route::post('perdiempositions/comboselect', 'PerdiempositionsController@postComboselect');
Route::post('perdiempositions/comboselectuser', 'PerdiempositionsController@postComboselectuser');
Route::get('perdiempositions/combotable', 'PerdiempositionsController@getCombotable');
Route::get('perdiempositions/combotablefield', 'PerdiempositionsController@getCombotablefield');


//countryperdiem
Route::get('countryperdiem', 'CountryperdiemController@getIndex');
Route::get('countryperdiem/update', 'CountryperdiemController@getUpdate');
Route::get('countryperdiem/update/{id}', 'CountryperdiemController@getUpdate');
Route::get('countryperdiem/show/{id}', 'CountryperdiemController@getShow');
Route::post('countryperdiem/save', 'CountryperdiemController@postSave');
Route::post('countryperdiem/delete', 'CountryperdiemController@postDelete');
Route::post('countryperdiem/multisearch', 'CountryperdiemController@postMultisearch');
Route::post('countryperdiem/filter', 'CountryperdiemController@postFilter');
Route::get('countryperdiem/download', 'CountryperdiemController@getDownload');
Route::post('countryperdiem/comboselect', 'CountryperdiemController@postComboselect');
Route::post('countryperdiem/comboselectuser', 'CountryperdiemController@postComboselectuser');
Route::get('countryperdiem/combotable', 'CountryperdiemController@getCombotable');
Route::get('countryperdiem/combotablefield', 'CountryperdiemController@getCombotablefield');


//travelling
Route::get('travelling', 'TravellingController@getIndex');
Route::get('travelling/update', 'TravellingController@getUpdate');
Route::get('travelling/update/{id}', 'TravellingController@getUpdate');
Route::get('travelling/show/{id}', 'TravellingController@getShow');
Route::post('travelling/save', 'TravellingController@postSave');
Route::post('travelling/delete', 'TravellingController@postDelete');
Route::post('travelling/multisearch', 'TravellingController@postMultisearch');
Route::post('travelling/filter', 'TravellingController@postFilter');
Route::get('travelling/download', 'TravellingController@getDownload');
Route::post('travelling/comboselect', 'TravellingController@postComboselect');
Route::post('travelling/comboselectuser', 'TravellingController@postComboselectuser');
Route::get('travelling/combotable', 'TravellingController@getCombotable');
Route::get('travelling/combotablefield', 'TravellingController@getCombotablefield');


//mytravelling
Route::get('mytravelling', 'MytravellingController@getIndex');
Route::get('mytravelling/update', 'MytravellingController@getUpdate');
Route::get('mytravelling/update/{id}', 'MytravellingController@getUpdate');
Route::get('mytravelling/show/{id}', 'MytravellingController@getShow');
Route::post('mytravelling/save', 'MytravellingController@postSave');
Route::post('mytravelling/delete', 'MytravellingController@postDelete');
Route::post('mytravelling/multisearch', 'MytravellingController@postMultisearch');
Route::post('mytravelling/filter', 'MytravellingController@postFilter');
Route::get('mytravelling/download', 'MytravellingController@getDownload');
Route::post('mytravelling/comboselect', 'MytravellingController@postComboselect');
Route::post('mytravelling/comboselectuser', 'MytravellingController@postComboselectuser');
Route::get('mytravelling/combotable', 'MytravellingController@getCombotable');
Route::get('mytravelling/combotablefield', 'MytravellingController@getCombotablefield');


//employeestravelling
Route::get('employeestravelling', 'EmployeestravellingController@getIndex');
Route::get('employeestravelling/update', 'EmployeestravellingController@getUpdate');
Route::get('employeestravelling/update/{id}', 'EmployeestravellingController@getUpdate');
Route::get('employeestravelling/show/{id}', 'EmployeestravellingController@getShow');
Route::post('employeestravelling/save', 'EmployeestravellingController@postSave');
Route::post('employeestravelling/delete', 'EmployeestravellingController@postDelete');
Route::post('employeestravelling/multisearch', 'EmployeestravellingController@postMultisearch');
Route::post('employeestravelling/filter', 'EmployeestravellingController@postFilter');
Route::get('employeestravelling/download', 'EmployeestravellingController@getDownload');
Route::post('employeestravelling/comboselect', 'EmployeestravellingController@postComboselect');
Route::post('employeestravelling/comboselectuser', 'EmployeestravellingController@postComboselectuser');
Route::get('employeestravelling/combotable', 'EmployeestravellingController@getCombotable');
Route::get('employeestravelling/combotablefield', 'EmployeestravellingController@getCombotablefield');


//mycommitments
Route::get('mycommitments', 'MycommitmentsController@getIndex');
Route::get('mycommitments/approve/{id}', 'MycommitmentsController@getApprove');
Route::get('mycommitmentusers/{id}', 'EmployeestasksController@getUsers');
Route::get('mycommitments/update', 'MycommitmentsController@getUpdate');
Route::get('mycommitments/update/{id}', 'MycommitmentsController@getUpdate');
Route::get('mycommitments/show/{id}', 'MycommitmentsController@getShow');
Route::post('mycommitments/save', 'MycommitmentsController@postSave');
Route::post('mycommitments/delete', 'MycommitmentsController@postDelete');
Route::post('mycommitments/multisearch', 'MycommitmentsController@postMultisearch');
Route::post('mycommitments/filter', 'MycommitmentsController@postFilter');
Route::get('mycommitments/download', 'MycommitmentsController@getDownload');
Route::post('mycommitments/comboselect', 'MycommitmentsController@postComboselect');
Route::post('mycommitments/comboselectuser', 'MycommitmentsController@postComboselectuser');
Route::get('mycommitments/combotable', 'MycommitmentsController@getCombotable');
Route::get('mycommitments/combotablefield', 'MycommitmentsController@getCombotablefield');


//employeestasks
Route::get('employeestasks', 'EmployeestasksController@getIndex');
Route::get('employeestasks/index', 'EmployeestasksController@getIndex');
Route::get('employeestasks/update', 'EmployeestasksController@getUpdate');
Route::get('employeestasks/update/{id}', 'EmployeestasksController@getUpdate');
Route::get('employeestasks/show/{id}', 'EmployeestasksController@getShow');
Route::post('employeestasks/save', 'EmployeestasksController@postSave');
Route::post('employeestasks/delete', 'EmployeestasksController@postDelete');
Route::post('employeestasks/multisearch', 'EmployeestasksController@postMultisearch');
Route::post('employeestasks/filter', 'EmployeestasksController@postFilter');
Route::get('employeestasks/download', 'EmployeestasksController@getDownload');
Route::post('employeestasks/comboselect', 'EmployeestasksController@postComboselect');
Route::post('employeestasks/comboselect', 'EmployeestasksController@postComboselect');
Route::post('employeestasks/comboselectuser', 'EmployeestasksController@postComboselectuser');
Route::get('employeestasks/combotable', 'EmployeestasksController@getCombotable');
Route::get('employeestasks/combotablefield', 'EmployeestasksController@getCombotablefield');


//service
Route::get('service', 'ServiceController@getIndex');
Route::get('service/update', 'ServiceController@getUpdate');
Route::get('service/update/{id}', 'ServiceController@getUpdate');
Route::get('service/show/{id}', 'ServiceController@getShow');
Route::post('service/save', 'ServiceController@postSave');
Route::post('service/delete', 'ServiceController@postDelete');
Route::post('service/multisearch', 'ServiceController@postMultisearch');
Route::post('service/filter', 'ServiceController@postFilter');
Route::get('service/download', 'ServiceController@getDownload');
Route::post('service/comboselect', 'ServiceController@postComboselect');
Route::post('service/comboselect', 'ServiceController@postComboselect');
Route::post('service/comboselectuser', 'ServiceController@postComboselectuser');
Route::get('service/combotable', 'ServiceController@getCombotable');
Route::get('service/combotablefield', 'ServiceController@getCombotablefield');


//mytasks
Route::get('mytasks', 'MytasksController@getIndex');
Route::get('mytasks/update', 'MytasksController@getUpdate');
Route::get('mytasks/update/{id}', 'MytasksController@getUpdate');
Route::get('mytasks/show/{id}', 'MytasksController@getShow');
Route::post('mytasks/save', 'MytasksController@postSave');
Route::post('mytasks/delete', 'MytasksController@postDelete');
Route::post('mytasks/multisearch', 'MytasksController@postMultisearch');
Route::post('mytasks/filter', 'MytasksController@postFilter');
Route::get('mytasks/download', 'MytasksController@getDownload');
Route::post('mytasks/comboselect', 'MytasksController@postComboselect');
Route::post('mytasks/comboselectuser', 'MytasksController@postComboselectuser');
Route::get('mytasks/combotable', 'MytasksController@getCombotable');
Route::get('mytasks/combotablefield', 'MytasksController@getCombotablefield');
Route::get('mytasks/projects', 'MytasksController@getProjects');


//strategies
Route::get('strategies', 'StrategiesController@getIndex');
Route::get('strategies/update', 'StrategiesController@getUpdate');
Route::get('strategies/update/{id}', 'StrategiesController@getUpdate');
Route::get('strategies/show/{id}', 'StrategiesController@getShow');
Route::post('strategies/save', 'StrategiesController@postSave');
Route::post('strategies/delete', 'StrategiesController@postDelete');
Route::post('strategies/multisearch', 'StrategiesController@postMultisearch');
Route::post('strategies/filter', 'StrategiesController@postFilter');
Route::get('strategies/download', 'StrategiesController@getDownload');
Route::post('strategies/comboselect', 'StrategiesController@postComboselect');
Route::post('strategies/comboselectuser', 'StrategiesController@postComboselectuser');
Route::get('strategies/combotable', 'StrategiesController@getCombotable');
Route::get('strategies/combotablefield', 'StrategiesController@getCombotablefield');

//searchTables
Route::get('searchTables', 'SearchTablesController@index');
Route::get('searchTables/download', 'SearchTablesController@download');
Route::get('searchTables/search', 'SearchTablesController@search');

//database_backups
Route::get('database_backups', 'DashboardController@list_backups');
Route::get('export_DB', 'DashboardController@export_DB_backup');
Route::get('delete_backup', 'DashboardController@delete_backup');
Route::get('download_backup', 'DashboardController@download_backup');
Route::get('import_DB', 'DashboardController@import_DB_backup');

Route::get('core/elfinder', 'Core\ElfinderController@getIndex');
Route::post('core/elfinder', 'Core\ElfinderController@getIndex');

//campaigntypes
Route::get('campaigntypes', 'CampaigntypesController@getIndex');
Route::get('campaigntypes/update', 'CampaigntypesController@getUpdate');
Route::get('campaigntypes/update/{id}', 'CampaigntypesController@getUpdate');
Route::get('campaigntypes/show/{id}', 'CampaigntypesController@getShow');
Route::post('campaigntypes/save', 'CampaigntypesController@postSave');
Route::post('campaigntypes/delete', 'CampaigntypesController@postDelete');
Route::post('campaigntypes/multisearch', 'CampaigntypesController@postMultisearch');
Route::post('campaigntypes/filter', 'CampaigntypesController@postFilter');
Route::get('campaigntypes/download', 'CampaigntypesController@getDownload');
Route::post('campaigntypes/comboselect', 'CampaigntypesController@postComboselect');
Route::post('campaigntypes/comboselectuser', 'CampaigntypesController@postComboselectuser');
Route::get('campaigntypes/combotable', 'CampaigntypesController@getCombotable');
Route::get('campaigntypes/combotablefield', 'CampaigntypesController@getCombotablefield');


//campaignalbums
Route::get('campaignalbums', 'CampaignalbumsController@getIndex');
Route::get('campaignalbums/update', 'CampaignalbumsController@getUpdate');
Route::get('campaignalbums/update/{id}', 'CampaignalbumsController@getUpdate');
Route::get('campaignalbums/show/{id}', 'CampaignalbumsController@getShow');
Route::post('campaignalbums/save', 'CampaignalbumsController@postSave');
Route::post('campaignalbums/delete', 'CampaignalbumsController@postDelete');
Route::post('campaignalbums/multisearch', 'CampaignalbumsController@postMultisearch');
Route::post('campaignalbums/filter', 'CampaignalbumsController@postFilter');
Route::get('campaignalbums/download', 'CampaignalbumsController@getDownload');
Route::post('campaignalbums/comboselect', 'CampaignalbumsController@postComboselect');
Route::post('campaignalbums/comboselectuser', 'CampaignalbumsController@postComboselectuser');
Route::get('campaignalbums/combotable', 'CampaignalbumsController@getCombotable');
Route::get('campaignalbums/combotablefield', 'CampaignalbumsController@getCombotablefield');
Route::get('campaignalbums/combotablefield', 'CampaignalbumsController@getCombotablefield');



//aggregators
Route::get('aggregators', 'AggregatorsController@getIndex');
Route::get('aggregators/update', 'AggregatorsController@getUpdate');
Route::get('aggregators/update/{id}', 'AggregatorsController@getUpdate');
Route::get('aggregators/show/{id}', 'AggregatorsController@getShow');
Route::post('aggregators/save', 'AggregatorsController@postSave');
Route::post('aggregators/delete', 'AggregatorsController@postDelete');
Route::post('aggregators/multisearch', 'AggregatorsController@postMultisearch');
Route::post('aggregators/filter', 'AggregatorsController@postFilter');
Route::get('aggregators/download', 'AggregatorsController@getDownload');
Route::post('aggregators/comboselect', 'AggregatorsController@postComboselect');
Route::post('aggregators/comboselectuser', 'AggregatorsController@postComboselectuser');
Route::get('aggregators/combotable', 'AggregatorsController@getCombotable');
Route::get('aggregators/combotablefield', 'AggregatorsController@getCombotablefield');
Route::get('aggregators/combotablefield', 'AggregatorsController@getCombotablefield');


//album
Route::get('album', 'AlbumController@getIndex');
Route::get('album/update', 'AlbumController@getUpdate');
Route::get('album/update/{id}', 'AlbumController@getUpdate');
Route::get('album/show/{id}', 'AlbumController@getShow');
Route::post('album/save', 'AlbumController@postSave');
Route::post('album/delete', 'AlbumController@postDelete');
Route::post('album/multisearch', 'AlbumController@postMultisearch');
Route::post('album/filter', 'AlbumController@postFilter');
Route::get('album/download', 'AlbumController@getDownload');
Route::post('album/comboselect', 'AlbumController@postComboselect');
Route::post('album/comboselectuser', 'AlbumController@postComboselectuser');
Route::get('album/combotable', 'AlbumController@getCombotable');
Route::get('album/combotablefield', 'AlbumController@getCombotablefield');
Route::get('album/combotablefield', 'AlbumController@getCombotablefield');
Route::get('album/excel', 'AlbumController@excel');
Route::post('album/excel', 'AlbumController@excelStore');
Route::get('album/downloadSample', 'AlbumController@downloadSample');
Route::get('album/downloadsample/{one?}/{two?}/{three?}/{four?}/{five?}', 'AlbumController@getDownloadsample');
Route::post('album/downloadsheet/{one?}/{two?}/{three?}/{four?}/{five?}', 'AlbumController@postDownloadsheet');


//album
Route::get('track', 'TrackController@getIndex');
Route::get('track/upload', 'TrackController@tracks');
Route::post('track/upload', 'TrackController@tracksStore');
Route::get('track/update', 'TrackController@getUpdate');
Route::get('track/update/{id}', 'TrackController@getUpdate');
Route::get('track/show/{id}', 'TrackController@getShow');
Route::post('track/save', 'TrackController@postSave');
Route::post('track/delete', 'TrackController@postDelete');
Route::post('track/multisearch', 'TrackController@postMultisearch');
Route::post('track/filter', 'TrackController@postFilter');
Route::get('track/download', 'TrackController@getDownload');
Route::post('track/comboselect', 'TrackController@postComboselect');
Route::post('track/comboselectuser', 'TrackController@postComboselectuser');
Route::get('track/combotable', 'TrackController@getCombotable');
Route::get('track/combotablefield', 'TrackController@getCombotablefield');
Route::get('track/combotablefield', 'TrackController@getCombotablefield');
Route::post('track/downloadinf', 'TrackController@postDownloadinf');
Route::post('sximo/module/saveformfield/tracks', 'Sximo\ModuleController@postSaveformfield');


//providertypes
Route::get('providertypes', 'ProvidertypesController@getIndex');
Route::get('providertypes/update', 'ProvidertypesController@getUpdate');
Route::get('providertypes/update/{id}', 'ProvidertypesController@getUpdate');
Route::get('providertypes/show/{id}', 'ProvidertypesController@getShow');
Route::post('providertypes/save', 'ProvidertypesController@postSave');
Route::post('providertypes/delete', 'ProvidertypesController@postDelete');
Route::post('providertypes/multisearch', 'ProvidertypesController@postMultisearch');
Route::post('providertypes/filter', 'ProvidertypesController@postFilter');
Route::get('providertypes/download', 'ProvidertypesController@getDownload');
Route::post('providertypes/comboselect', 'ProvidertypesController@postComboselect');
Route::post('providertypes/comboselectuser', 'ProvidertypesController@postComboselectuser');
Route::get('providertypes/combotable', 'ProvidertypesController@getCombotable');
Route::get('providertypes/combotablefield', 'ProvidertypesController@getCombotablefield');
Route::get('providertypes/combotablefield', 'ProvidertypesController@getCombotablefield');


//individualproviders
Route::get('individualproviders', 'IndividualprovidersController@getIndex');
Route::get('individualproviders/update', 'IndividualprovidersController@getUpdate');
Route::get('individualproviders/update/{id}', 'IndividualprovidersController@getUpdate');
Route::get('individualproviders/show/{id}', 'IndividualprovidersController@getShow');
Route::post('individualproviders/save', 'IndividualprovidersController@postSave');
Route::post('individualproviders/delete', 'IndividualprovidersController@postDelete');
Route::post('individualproviders/multisearch', 'IndividualprovidersController@postMultisearch');
Route::post('individualproviders/filter', 'IndividualprovidersController@postFilter');
Route::get('individualproviders/download', 'IndividualprovidersController@getDownload');
Route::post('individualproviders/comboselect', 'IndividualprovidersController@postComboselect');
Route::post('individualproviders/comboselectuser', 'IndividualprovidersController@postComboselectuser');
Route::get('individualproviders/combotable', 'IndividualprovidersController@getCombotable');
Route::get('individualproviders/combotablefield', 'IndividualprovidersController@getCombotablefield');
Route::get('individualproviders/combotablefield', 'IndividualprovidersController@getCombotablefield');


//providerestablishments
Route::get('providerestablishments', 'ProviderestablishmentsController@getIndex');
Route::get('providerestablishments/update', 'ProviderestablishmentsController@getUpdate');
Route::get('providerestablishments/update/{id}', 'ProviderestablishmentsController@getUpdate');
Route::get('providerestablishments/show/{id}', 'ProviderestablishmentsController@getShow');
Route::post('providerestablishments/save', 'ProviderestablishmentsController@postSave');
Route::post('providerestablishments/delete', 'ProviderestablishmentsController@postDelete');
Route::post('providerestablishments/multisearch', 'ProviderestablishmentsController@postMultisearch');
Route::post('providerestablishments/filter', 'ProviderestablishmentsController@postFilter');
Route::get('providerestablishments/download', 'ProviderestablishmentsController@getDownload');
Route::post('providerestablishments/comboselect', 'ProviderestablishmentsController@postComboselect');
Route::post('providerestablishments/comboselectuser', 'ProviderestablishmentsController@postComboselectuser');
Route::get('providerestablishments/combotable', 'ProviderestablishmentsController@getCombotable');
Route::get('providerestablishments/combotablefield', 'ProviderestablishmentsController@getCombotablefield');
Route::get('providerestablishments/combotablefield', 'ProviderestablishmentsController@getCombotablefield');


//providerestablishments
Route::get('occasions', 'OccasionsController@getIndex');
Route::get('occasions/update', 'OccasionsController@getUpdate');
Route::get('occasions/update/{id}', 'OccasionsController@getUpdate');
Route::get('occasions/show/{id}', 'OccasionsController@getShow');
Route::post('occasions/save', 'OccasionsController@postSave');
Route::post('occasions/delete', 'OccasionsController@postDelete');
Route::post('occasions/multisearch', 'OccasionsController@postMultisearch');
Route::post('occasions/filter', 'OccasionsController@postFilter');
Route::get('occasions/download', 'OccasionsController@getDownload');
Route::post('occasions/comboselect', 'OccasionsController@postComboselect');
Route::post('occasions/comboselectuser', 'OccasionsController@postComboselectuser');
Route::get('occasions/combotable', 'OccasionsController@getCombotable');
Route::get('occasions/combotablefield', 'OccasionsController@getCombotablefield');
Route::get('occasions/combotablefield', 'OccasionsController@getCombotablefield');


//contenttypes
Route::get('contenttypes', 'ContenttypesController@getIndex');
Route::get('contenttypes/update', 'ContenttypesController@getUpdate');
Route::get('contenttypes/update/{id}', 'ContenttypesController@getUpdate');
Route::get('contenttypes/show/{id}', 'ContenttypesController@getShow');
Route::post('contenttypes/save', 'ContenttypesController@postSave');
Route::post('contenttypes/delete', 'ContenttypesController@postDelete');
Route::post('contenttypes/multisearch', 'ContenttypesController@postMultisearch');
Route::post('contenttypes/filter', 'ContenttypesController@postFilter');
Route::get('contenttypes/download', 'ContenttypesController@getDownload');
Route::post('contenttypes/comboselect', 'ContenttypesController@postComboselect');
Route::post('contenttypes/comboselectuser', 'ContenttypesController@postComboselectuser');
Route::get('contenttypes/combotable', 'ContenttypesController@getCombotable');
Route::get('contenttypes/combotablefield', 'ContenttypesController@getCombotablefield');
Route::get('contenttypes/combotablefield', 'ContenttypesController@getCombotablefield');

//mediafilesizes
Route::get('mediafilesizes', 'MediafilesizesController@getIndex');
Route::get('mediafilesizes/update', 'MediafilesizesController@getUpdate');
Route::get('mediafilesizes/update/{id}', 'MediafilesizesController@getUpdate');
Route::get('mediafilesizes/show/{id}', 'MediafilesizesController@getShow');
Route::post('mediafilesizes/save', 'MediafilesizesController@postSave');
Route::post('mediafilesizes/delete', 'MediafilesizesController@postDelete');
Route::post('mediafilesizes/multisearch', 'MediafilesizesController@postMultisearch');
Route::post('mediafilesizes/filter', 'MediafilesizesController@postFilter');
Route::get('mediafilesizes/download', 'MediafilesizesController@getDownload');
Route::post('mediafilesizes/comboselect', 'MediafilesizesController@postComboselect');
Route::post('mediafilesizes/comboselectuser', 'MediafilesizesController@postComboselectuser');
Route::get('mediafilesizes/combotable', 'MediafilesizesController@getCombotable');
Route::get('mediafilesizes/combotablefield', 'MediafilesizesController@getCombotablefield');
Route::get('mediafilesizes/combotablefield', 'MediafilesizesController@getCombotablefield');


//specscontentcategory
Route::get('specscontentcategory', 'SpecscontentcategoryController@getIndex');
Route::get('specscontentcategory/update', 'SpecscontentcategoryController@getUpdate');
Route::get('specscontentcategory/update/{id}', 'SpecscontentcategoryController@getUpdate');
Route::get('specscontentcategory/show/{id}', 'SpecscontentcategoryController@getShow');
Route::post('specscontentcategory/save', 'SpecscontentcategoryController@postSave');
Route::post('specscontentcategory/delete', 'SpecscontentcategoryController@postDelete');
Route::post('specscontentcategory/multisearch', 'SpecscontentcategoryController@postMultisearch');
Route::post('specscontentcategory/filter', 'SpecscontentcategoryController@postFilter');
Route::get('specscontentcategory/download', 'SpecscontentcategoryController@getDownload');
Route::post('specscontentcategory/comboselect', 'SpecscontentcategoryController@postComboselect');
Route::post('specscontentcategory/comboselectuser', 'SpecscontentcategoryController@postComboselectuser');
Route::get('specscontentcategory/combotable', 'SpecscontentcategoryController@getCombotable');
Route::get('specscontentcategory/combotablefield', 'SpecscontentcategoryController@getCombotablefield');
Route::get('specscontentcategory/combotablefield', 'SpecscontentcategoryController@getCombotablefield');

//specscontentcategory
Route::get('audiometadata', 'AudiometadataController@getIndex');
Route::get('audiometadata/update', 'AudiometadataController@getUpdate');
Route::get('audiometadata/update/{id}', 'AudiometadataController@getUpdate');
Route::get('audiometadata/show/{id}', 'AudiometadataController@getShow');
Route::post('audiometadata/save', 'AudiometadataController@postSave');
Route::post('audiometadata/delete', 'AudiometadataController@postDelete');
Route::post('audiometadata/multisearch', 'AudiometadataController@postMultisearch');
Route::post('audiometadata/filter', 'AudiometadataController@postFilter');
Route::get('audiometadata/download', 'AudiometadataController@getDownload');
Route::post('audiometadata/comboselect', 'AudiometadataController@postComboselect');
Route::post('audiometadata/comboselectuser', 'AudiometadataController@postComboselectuser');
Route::get('audiometadata/combotable', 'AudiometadataController@getCombotable');
Route::get('audiometadata/combotablefield', 'AudiometadataController@getCombotablefield');
Route::get('audiometadata/combotablefield', 'AudiometadataController@getCombotablefield');


//originalcontents
Route::get('originalcontents', 'OriginalcontentsController@getIndex');
Route::get('originalcontents/update', 'OriginalcontentsController@getUpdate');
Route::get('originalcontents/update/{id}', 'OriginalcontentsController@getUpdate');
Route::get('originalcontents/show/{id}', 'OriginalcontentsController@getShow');
Route::post('originalcontents/save', 'OriginalcontentsController@postSave');
Route::post('originalcontents/delete', 'OriginalcontentsController@postDelete');
Route::post('originalcontents/multisearch', 'OriginalcontentsController@postMultisearch');
Route::post('originalcontents/filter', 'OriginalcontentsController@postFilter');
Route::get('originalcontents/download', 'OriginalcontentsController@getDownload');
Route::post('originalcontents/comboselect', 'OriginalcontentsController@postComboselect');
Route::post('originalcontents/comboselectuser', 'OriginalcontentsController@postComboselectuser');
Route::get('originalcontents/combotable', 'OriginalcontentsController@getCombotable');
Route::get('originalcontents/combotablefield', 'OriginalcontentsController@getCombotablefield');
Route::get('originalcontents/combotablefield', 'OriginalcontentsController@getCombotablefield');


//finalvideo
Route::get('finalvideo', 'FinalvideoController@getIndex');
Route::get('finalvideo/update', 'FinalvideoController@getUpdate');
Route::get('finalvideo/update/{id}', 'FinalvideoController@getUpdate');
Route::get('finalvideo/show/{id}', 'FinalvideoController@getShow');
Route::post('finalvideo/save', 'FinalvideoController@postSave');
Route::post('finalvideo/delete', 'FinalvideoController@postDelete');
Route::post('finalvideo/multisearch', 'FinalvideoController@postMultisearch');
Route::post('finalvideo/filter', 'OriginalcontentsController@postFilter');
Route::get('finalvideo/download', 'FinalvideoController@getDownload');
Route::post('finalvideo/comboselect', 'FinalvideoController@postComboselect');
Route::post('finalvideo/comboselectuser', 'FinalvideoController@postComboselectuser');
Route::get('finalvideo/combotable', 'FinalvideoController@getCombotable');
Route::get('finalvideo/combotablefield', 'FinalvideoController@getCombotablefield');
Route::get('finalvideo/combotablefield', 'FinalvideoController@getCombotablefield');


//finalimage
Route::get('finalimage', 'FinalimageController@getIndex');
Route::get('finalimage/update', 'FinalimageController@getUpdate');
Route::get('finalimage/update/{id}', 'FinalimageController@getUpdate');
Route::get('finalimage/show/{id}', 'FinalimageController@getShow');
Route::post('finalimage/save', 'FinalimageController@postSave');
Route::post('finalimage/delete', 'FinalimageController@postDelete');
Route::post('finalimage/multisearch', 'FinalimageController@postMultisearch');
Route::post('finalimage/filter', 'FinalimageController@postFilter');
Route::get('finalimage/download', 'FinalimageController@getDownload');
Route::post('finalimage/comboselect', 'FinalimageController@postComboselect');
Route::post('finalimage/comboselectuser', 'FinalimageController@postComboselectuser');
Route::get('finalimage/combotable', 'FinalimageController@getCombotable');
Route::get('finalimage/combotablefield', 'FinalimageController@getCombotablefield');
Route::get('finalimage/combotablefield', 'FinalimageController@getCombotablefield');

//departments
Route::get('departments', 'DepartmentsController@getIndex');
Route::get('departments/update', 'DepartmentsController@getUpdate');
Route::get('departments/update/{id}', 'DepartmentsController@getUpdate');
Route::get('departments/show/{id}', 'DepartmentsController@getShow');
Route::post('departments/save', 'DepartmentsController@postSave');
Route::post('departments/delete', 'DepartmentsController@postDelete');
Route::post('departments/multisearch', 'DepartmentsController@postMultisearch');
Route::post('departments/filter', 'DepartmentsController@postFilter');
Route::get('departments/download', 'DepartmentsController@getDownload');
Route::post('departments/comboselect', 'DepartmentsController@postComboselect');
Route::post('departments/comboselectuser', 'DepartmentsController@postComboselectuser');
Route::get('departments/combotable', 'DepartmentsController@getCombotable');
Route::get('departments/combotablefield', 'DepartmentsController@getCombotablefield');
Route::get('departments/combotablefield', 'DepartmentsController@getCombotablefield');

//attendance
Route::get('attendance', 'AttendanceController@getIndex');
Route::get('attendance/update', 'AttendanceController@getUpdate');
Route::get('attendance/update/{id}', 'AttendanceController@getUpdate');
Route::get('attendance/show/{id}', 'AttendanceController@getShow');
Route::post('attendance/save', 'AttendanceController@postSave');
Route::post('attendance/delete', 'AttendanceController@postDelete');
Route::post('attendance/multisearch', 'AttendanceController@postMultisearch');
Route::post('attendance/filter', 'AttendanceController@postFilter');
Route::get('attendance/download', 'AttendanceController@getDownload');
Route::post('attendance/comboselect', 'AttendanceController@postComboselect');
Route::post('attendance/comboselectuser', 'AttendanceController@postComboselectuser');
Route::get('attendance/combotable', 'AttendanceController@getCombotable');
Route::get('attendance/combotablefield', 'AttendanceController@getCombotablefield');
Route::get('attendance/combotablefield', 'AttendanceController@getCombotablefield');
Route::get('refresh_punch', 'AttendanceController@refresh_punch');
Route::get('attendance/upload', 'AttendanceController@getUpload');


//deductions
Route::get('deductions', 'DeductionsController@getIndex');
Route::get('deductions/update', 'DeductionsController@getUpdate');
Route::get('deductions/update/{id}', 'DeductionsController@getUpdate');
Route::get('deductions/show/{id}', 'DeductionsController@getShow');
Route::post('deductions/save', 'DeductionsController@postSave');
Route::post('deductions/delete', 'DeductionsController@postDelete');
Route::post('deductions/multisearch', 'DeductionsController@postMultisearch');
Route::post('deductions/filter', 'DeductionsController@postFilter');
Route::get('deductions/download', 'DeductionsController@getDownload');
Route::post('deductions/comboselect', 'DeductionsController@postComboselect');
Route::post('deductions/comboselectuser', 'DeductionsController@postComboselectuser');
Route::get('deductions/combotable', 'DeductionsController@getCombotable');
Route::get('deductions/combotablefield', 'DeductionsController@getCombotablefield');
Route::get('deductions/combotablefield', 'DeductionsController@getCombotablefield');

//delaynotifications
Route::get('delaynotifications', 'DelaynotificationsController@getIndex');
Route::get('delaynotifications/update', 'DelaynotificationsController@getUpdate');
Route::get('delaynotifications/update/{id}', 'DelaynotificationsController@getUpdate');
Route::get('delaynotifications/show/{id}', 'DelaynotificationsController@getShow');
Route::post('delaynotifications/save', 'DelaynotificationsController@postSave');
Route::post('delaynotifications/delete', 'DelaynotificationsController@postDelete');
Route::post('delaynotifications/multisearch', 'DelaynotificationsController@postMultisearch');
Route::post('delaynotifications/filter', 'DelaynotificationsController@postFilter');
Route::get('delaynotifications/download', 'DelaynotificationsController@getDownload');
Route::post('delaynotifications/comboselect', 'DelaynotificationsController@postComboselect');
Route::post('delaynotifications/comboselectuser', 'DelaynotificationsController@postComboselectuser');
Route::get('delaynotifications/combotable', 'DelaynotificationsController@getCombotable');
Route::get('delaynotifications/combotablefield', 'DelaynotificationsController@getCombotablefield');
Route::get('delaynotifications/combotablefield', 'DelaynotificationsController@getCombotablefield');


//punchnotifications
Route::get('punchnotifications', 'PunchnotificationsController@getIndex');
Route::get('punchnotifications/update', 'PunchnotificationsController@getUpdate');
Route::get('punchnotifications/update/{id}', 'PunchnotificationsController@getUpdate');
Route::get('punchnotifications/show/{id}', 'PunchnotificationsController@getShow');
Route::post('punchnotifications/save', 'PunchnotificationsController@postSave');
Route::post('punchnotifications/delete', 'PunchnotificationsController@postDelete');
Route::post('punchnotifications/multisearch', 'PunchnotificationsController@postMultisearch');
Route::post('punchnotifications/filter', 'PunchnotificationsController@postFilter');
Route::get('punchnotifications/download', 'PunchnotificationsController@getDownload');
Route::post('punchnotifications/comboselect', 'PunchnotificationsController@postComboselect');
Route::post('punchnotifications/comboselectuser', 'PunchnotificationsController@postComboselectuser');
Route::get('punchnotifications/combotable', 'PunchnotificationsController@getCombotable');
Route::get('punchnotifications/combotablefield', 'PunchnotificationsController@getCombotablefield');
Route::get('punchnotifications/combotablefield', 'PunchnotificationsController@getCombotablefield');

//rbt
Route::get('rbt/statistics', 'RbtController@statitics');
Route::post('rbt/get_statistics', 'RbtController@get_statistics');
Route::get('rbt', 'RbtController@getIndex');
Route::get('rbt/update', 'RbtController@getUpdate');
Route::get('rbt/update/{id}', 'RbtController@getUpdate');
Route::get('rbt/show/{id}', 'RbtController@getShow');
Route::post('rbt/save', 'RbtController@postSave');
Route::post('rbt/delete', 'RbtController@postDelete');
Route::post('rbt/multisearch', 'RbtController@postMultisearch');
Route::post('rbt/filter', 'RbtController@postFilter');
Route::get('rbt/download', 'RbtController@getDownload');
Route::post('rbt/comboselect', 'RbtController@postComboselect');
Route::post('rbt/comboselectuser', 'RbtController@postComboselectuser');
Route::get('rbt/combotable', 'RbtController@getCombotable');
Route::get('rbt/combotablefield', 'RbtController@getCombotablefield');
Route::get('rbt/combotablefield', 'RbtController@getCombotablefield');
Route::get('rbt/excel', 'RbtController@create_excel');
Route::post('rbt/excel', 'RbtController@excelStore');
Route::get('rbt/upload_tracks', 'RbtController@multi_upload');
Route::post('rbt/save_tracks', 'RbtController@save_tracks');
Route::get('rbt/file_system', 'RbtController@list_file_system');
Route::get('rbt/file_system/content', 'RbtController@get_file_system');
Route::get('rbt/search', 'RbtController@search');
Route::get('rbt/downloadSampleNew', 'RbtController@getDownloadNew');
Route::get('rbt/downloadSample', 'RbtController@downloadSample');
Route::post('rbt/search', 'RbtController@search_result');
Route::get('rbt/search', 'RbtController@search');

//report
Route::get('report/statistics', 'ReportController@statitics');
Route::post('report/get_statistics', 'ReportController@get_statistics');
Route::get('report', 'ReportController@getIndex');
Route::get('report/update', 'ReportController@getUpdate');
Route::get('report/update/{id}', 'ReportController@getUpdate');
Route::get('report/show/{id}', 'ReportController@getShow');
Route::post('report/save', 'ReportController@postSave');
Route::post('report/delete', 'ReportController@postDelete');
Route::post('report/multisearch', 'ReportController@postMultisearch');
Route::post('report/filter', 'ReportController@postFilter');
Route::get('report/download', 'ReportController@getDownload');
Route::post('report/comboselect', 'ReportController@postComboselect');
Route::post('report/comboselectuser', 'ReportController@postComboselectuser');
Route::get('report/combotable', 'ReportController@getCombotable');
Route::get('report/combotablefield', 'ReportController@getCombotablefield');
Route::get('report/combotablefield', 'ReportController@getCombotablefield');
Route::get('report/excel', 'ReportController@excel');
Route::post('report/excel', 'ReportController@excelStore');
Route::get('report/upload_tracks', 'ReportController@multi_upload');
Route::get('report/file_system', 'ReportController@list_file_system');
Route::get('report/file_system/content', 'ReportController@get_file_system');
Route::get('report/downloadSample', 'ReportController@downloadSample');
Route::get('report/downloadsample/{one?}/{two?}/{three?}/{four?}/{five?}', 'ReportController@getDownloadsample');
Route::get('report/search', 'ReportController@search');
Route::post('report/search', 'ReportController@search_result');

//playtrack_v4
Route::get('playtrack', 'CampaignalbumsController@GetTrack');
Route::get('playtrack_v2/{track_id}', 'CampaignalbumsController@GetTrack_v2');
Route::get('playtrack_v3/{track_id}', 'CampaignalbumsController@GetTrack_v3');
Route::get('playtrack_v4/{track_id}', 'CampaignalbumsController@GetTrack_v4');
Route::post('campaignalbums/add/track', 'CampaignalbumsController@add_track');
Route::get('campaignalbums/add/track/{id}', 'CampaignalbumsController@get_track_form');

//contracts
Route::get('contracts', 'ContractsController@getIndex');
Route::get('contracts/approve', 'ContractsController@getApprove');
Route::get('contracts/update', 'ContractsController@getUpdate');
Route::get('contracts/update/{id}', 'ContractsController@getUpdate');
Route::get('contracts/show/{id}', 'ContractsController@getShow');
Route::post('contracts/save', 'ContractsController@postSave');
Route::get('contracts/trashed', 'ContractsController@getTrashed');
Route::get('contracts/teamapprove', 'ContractsController@getTeamapprove');
Route::get('contracts/provider', 'ContractsController@get_provider');
Route::get('contracts/download', 'ContractsController@getDownload');
Route::get('contracts/cancel', 'ContractsController@getCancel');
Route::get('contracts/chart', 'ContractsController@getChart');
Route::post('contracts/comboselect', 'ContractsController@postComboselect');
Route::post('contracts/multisearch', 'ContractsController@postMultisearch');
Route::post('contracts/filter', 'ContractsController@postFilter');
Route::post('contracts/delete', 'ContractsController@postDelete');

//contractsrenew
Route::get('contractsrenew', 'ContractsrenewController@getIndex');
Route::get('contractsrenew/index', 'ContractsrenewController@getIndex');
Route::get('contractsrenew/approve', 'ContractsrenewController@getApprove');
Route::get('contractsrenew/renew/{id}', 'ContractsrenewController@getRenew');
Route::get('contractsrenew/update', 'ContractsrenewController@getUpdate');
Route::get('contractsrenew/update/{id}', 'ContractsrenewController@getUpdate');
Route::get('contractsrenew/show/{id}', 'ContractsrenewController@getShow');
Route::post('contractsrenew/save', 'ContractsrenewController@postSave');
Route::get('contractsrenew/trashed', 'ContractsrenewController@getTrashed');
Route::get('contractsrenew/teamapprove', 'ContractsrenewController@getTeamapprove');
Route::get('contractsrenew/provider', 'ContractsrenewController@get_provider');
Route::get('contractsrenew/download', 'ContractsrenewController@getDownload');
Route::get('contractsrenew/cancel', 'ContractsrenewController@getCancel');
Route::get('contractsrenew/chart', 'ContractsrenewController@getChart');
Route::post('contractsrenew/comboselect', 'ContractsrenewController@postComboselect');
Route::post('contractsrenew/multisearch', 'ContractsrenewController@postMultisearch');
Route::post('contractsrenew/filter', 'ContractsrenewController@postFilter');
Route::post('contractsrenew/delete', 'ContractsrenewController@postDelete');

//commitments
Route::get('commitments', 'CommitmentsController@getIndex');
Route::get('commitments/approve', 'CommitmentsController@getApprove');
Route::get('commitments/update/{id?}', 'CommitmentsController@getUpdate');
Route::get('commitments/show/{id}', 'CommitmentsController@getShow');
Route::post('commitments/save', 'CommitmentsController@postSave');
Route::get('commitments/trashed', 'CommitmentsController@getTrashed');
Route::get('commitments/teamapprove', 'CommitmentsController@getTeamapprove');
Route::get('commitments/provider', 'CommitmentsController@get_provider');
Route::get('commitments/download', 'CommitmentsController@getDownload');
Route::get('commitments/cancel', 'CommitmentsController@getCancel');
Route::get('commitments/chart', 'CommitmentsController@getChart');
Route::post('commitments/comboselect', 'CommitmentsController@postComboselect');
Route::post('commitments/multisearch', 'CommitmentsController@postMultisearch');
Route::post('commitments/filter', 'CommitmentsController@postFilter');
Route::post('commitments/delete', 'CommitmentsController@postDelete');

//Tasks
Route::get('tasks', 'TasksController@getIndex');
Route::get('tasks/index', 'EmployeestasksController@getIndex');
Route::get('tasks/approve', 'TasksController@getApprove');
Route::get('tasks/update/{id?}', 'TasksController@getUpdate');
Route::get('tasks/show/{id}', 'TasksController@getShow');
Route::post('tasks/save', 'TasksController@postSave');
Route::get('tasks/trashed', 'TasksController@getTrashed');
Route::get('tasks/teamapprove', 'TasksController@getTeamapprove');
Route::get('tasks/provider', 'TasksController@get_provider');
Route::get('tasks/download', 'TasksController@getDownload');
Route::get('tasks/cancel', 'TasksController@getCancel');
Route::get('tasks/chart', 'TasksController@getChart');
Route::post('tasks/comboselect', 'TasksController@postComboselect');
Route::post('tasks/multisearch', 'TasksController@postMultisearch');
Route::post('tasks/filter', 'TasksController@postFilter');
Route::post('tasks/delete', 'TasksController@postDelete');

//template
Route::get('template', 'TemplateController@getIndex');
Route::get('template/approve', 'TemplateController@getApprove');
Route::get('template/update/{id?}', 'TemplateController@getUpdate');
Route::get('template/show/{id}', 'TemplateController@getShow');
Route::post('template/save', 'TemplateController@postSave');
Route::get('template/trashed', 'TemplateController@getTrashed');
Route::get('template/teamapprove', 'TemplateController@getTeamapprove');
Route::get('template/provider', 'TemplateController@get_provider');
Route::get('template/download', 'TemplateController@getDownload');
Route::get('template/cancel', 'TemplateController@getCancel');
Route::get('template/chart', 'TemplateController@getChart');
Route::post('template/comboselect', 'TemplateController@postComboselect');
Route::post('template/multisearch', 'TemplateController@postMultisearch');
Route::post('template/filter', 'TemplateController@postFilter');
Route::post('template/delete', 'TemplateController@postDelete');

//acquisitions
Route::get('acquisitions', 'AcquisitionsController@getIndex');
Route::get('acquisitions/approve', 'AcquisitionsController@getApprove');
Route::get('acquisitions/update/{id?}', 'AcquisitionsController@getUpdate');
Route::get('acquisitions/show/{id}', 'AcquisitionsController@getShow');
Route::post('acquisitions/save', 'AcquisitionsController@postSave');
Route::get('acquisitions/trashed', 'AcquisitionsController@getTrashed');
Route::get('acquisitions/teamapprove', 'AcquisitionsController@getTeamapprove');
Route::get('acquisitions/provider', 'AcquisitionsController@get_provider');
Route::get('acquisitions/download', 'AcquisitionsController@getDownload');
Route::get('acquisitions/cancel', 'AcquisitionsController@getCancel');
Route::get('acquisitions/chart', 'AcquisitionsController@getChart');
Route::post('acquisitions/comboselect', 'AcquisitionsController@postComboselect');
Route::post('acquisitions/multisearch', 'AcquisitionsController@postMultisearch');
Route::post('acquisitions/filter', 'AcquisitionsController@postFilter');
Route::post('acquisitions/delete', 'AcquisitionsController@postDelete');

//notifications
Route::post('notifications/upnotifications', 'NotificationsController@postUpnotifications');
Route::post('notifications/seennotification', 'NotificationsController@postSeennotification');
Route::get('template_download_pdf/{id}', 'TemplateController@download_pdf');
Route::get('template_download_word/{id}', 'TemplateController@download_word');
Route::get('items/get/{id}', 'TemplateitemsController@get_items');
Route::get('provider_info/{id}', 'ContractsController@get_provider');
Route::get('contracts/operator', 'ContractsController@getOperator');
Route::get('contract_download_pdf/{id}', 'ContractsController@download_pdf');


//months
Route::get('months', 'MonthsController@getIndex');
Route::get('months/approve', 'MonthsController@getApprove');
Route::get('months/update/{id?}', 'MonthsController@getUpdate');
Route::get('months/show/{id}', 'MonthsController@getShow');
Route::post('months/save', 'MonthsController@postSave');
Route::get('months/trashed', 'MonthsController@getTrashed');
Route::get('months/teamapprove', 'MonthsController@getTeamapprove');
Route::get('months/provider', 'MonthsController@get_provider');
Route::get('months/download', 'MonthsController@getDownload');
Route::get('months/cancel', 'MonthsController@getCancel');
Route::get('months/chart', 'MonthsController@getChart');
Route::post('months/comboselect', 'MonthsController@postComboselect');
Route::post('months/multisearch', 'MonthsController@postMultisearch');
Route::post('months/filter', 'MonthsController@postFilter');
Route::post('months/delete', 'MonthsController@postDelete');


Route::get('hr', function () {
    return redirect('dashboard');
});

define('MANAGER_DEPARTMENT_ID', 21);
define('ADMIN_USER_ID', 109); // Mayar
define('CFO_USER_ID', 59); // Tamer
define('CFO_BACKUP_ID', 64); // Rana
define('CEO_USER_ID', 2); // Haitham
define('CEO_USER_ID2', 65); // Reem
define('HR_USER_ID', 24); // Sara

define('DEV_SMS_SEND_MESSAGE', 'http://sms.ivashosting.com/hr_notify');
define('DEV_SMS_HR_PUNCH', 'http://sms.ivashosting.com/hr_punch');
// define('DEV_SMS_HR_PUNCH','http://localhost/sms_backend/hr_punch');

define('ContractMonthCheck', 4);

define('CNF_APPNAME','HR System');
define('CNF_APPDESC','HR System');
define('CNF_COMNAME','');
define('CNF_EMAIL','');
define('CNF_METAKEY','');
define('CNF_METADESC','');
define('CNF_GROUP','3');
define('CNF_ACTIVATION','confirmation');
define('CNF_MULTILANG','0');
define('CNF_LANG','');
define('CNF_REGIST','false');
define('CNF_FRONT','false');
define('CNF_RECAPTCHA','false');
define('CNF_THEME','sximone');
define('CNF_RECAPTCHAPUBLICKEY','');
define('CNF_RECAPTCHAPRIVATEKEY','');
define('CNF_MODE','development');
define('CNF_LOGO','backend-logo.png');
define('CNF_ALLOWIP','');
define('CNF_RESTRICIP','192.116.134 , 194.111.606.21 ');
define('CNF_VACATION','');
define('CNF_START_HOUR','');
define('CNF_END_HOUR','');
define('CNF_TOLERANCE','');
define('VACATIONS_PER_YEAR','21');
define('PERMISSIONS_PER_MONTH','2');
define('PERMISSIONS_Hours_PER_MONTH','4');
define('CNF_BUILDER_TOOL','1');
define('delay_notifications_email','hr@ivas.com.eg');
define('SEND_SMS','0');
define('DELAY_TIME_IN_HOURS','1');
