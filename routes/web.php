<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

    use Illuminate\Support\Facades\Route;

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

    // CACHE CLEAR ROUTE
    Route::get('cache-clear', function () {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        request()->session()->flash('success', 'Successfully cache cleared.');
        return redirect()->back();
    })->name('cache.clear');


    // STORAGE LINKED ROUTE
    Route::get('storage-link',[\App\Http\Controllers\AdminController::class,'storageLink'])->name('storage.link');


    Auth::routes(['register' => false,]);

    Route::get('user/login', 'FrontendController@login')->name('login.form');
    Route::post('user/login', 'FrontendController@loginSubmit')->name('login.submit');
    Route::get('user/logout', 'FrontendController@logout')->name('user.logout');

    Route::get('user/register', 'FrontendController@register')->name('register.form');
    Route::post('user/register', 'FrontendController@registerSubmit')->name('register.submit');

// Reset password
    Route::get('password-reset', 'FrontendController@showResetForm')->name('password.reset');
// Socialite
    Route::get('login/{provider}/', 'Auth\LoginController@redirect')->name('login.redirect');
    Route::get('login/{provider}/callback/', 'Auth\LoginController@Callback')->name('login.callback');

    Route::get('/', 'FrontendController@home')->name('home');

// Frontend Routes

    Route::get('/home', 'FrontendController@index');





// Backend section start

    Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'role:admin']], function () {
        // Routes accessible to users with 'admin' role
        Route::get('/', 'AdminController@index')->name('admin');
        Route::get('/file-manager', function () {
            return view('backend.layouts.file-manager');
        })->name('file-manager');
        // user route
        Route::resource('users', 'UsersController');
        // Brand
        Route::resource('brand', 'BrandController');
        // Profile
        Route::get('/profile', 'AdminController@profile')->name('admin-profile');
        Route::post('/profile/{id}', 'AdminController@profileUpdate')->name('profile-update');

        // Settings
        Route::get('settings', 'AdminController@settings')->name('settings');
        Route::post('setting/update', 'AdminController@settingsUpdate')->name('settings.update');
        // Notification
        Route::get('/notification/{id}', 'NotificationController@show')->name('admin.notification');
        Route::get('/notifications', 'NotificationController@index')->name('all.notification');
        Route::delete('/notification/{id}', 'NotificationController@delete')->name('notification.delete');
        // Password Change
        Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
        Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');
    });

    Route::group(['prefix' => '/student', 'middleware' => ['auth', 'role:student']], function () {
        // Routes accessible to users with 'student' role
        Route::get('/', 'StudentController@index')->name('student');
        Route::get('/file-manager', function () {
            return view('backend.layouts.file-manager');
        })->name('file-manager');
        // user route
        Route::resource('document', 'StudentDocumentController');
        //faculty
        Route::get('/faculty/create', 'StudentController@facultyfiles')->name('faculty.create');
        Route::post('/faculty', 'StudentController@storefacultyfiles')->name('faculty.store');
        // Profile
        Route::get('/profile', 'AdminController@profile')->name('admin-profile');
        Route::post('/profile/{id}', 'AdminController@profileUpdate')->name('profile-update');
        
        // Settings
        Route::get('settings', 'AdminController@settings')->name('settings');
        Route::post('setting/update', 'AdminController@settingsUpdate')->name('settings.update');

    
        // Password Change
        Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
        Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');
    });
    
    Route::group(['prefix' => '/faculty', 'middleware' => ['auth', 'role:faculty']], function () {
        // Routes accessible to users with 'faculty' role
        Route::get('/', 'FacultyController@index')->name('faculty');
        // Profile
        Route::get('/profile', [HomeController::class, 'profile'])->name('user-profile');
        Route::post('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');
        //clear
        // web.php
        Route::post('/faculty/clearance-request/clear/{student_id}', 'FacultyController@clearStudent')->name('faculty.clearance-request.clear');
        
        Route::get('/order', "HomeController@orderIndex")->name('faculty.order.index');
        Route::get('/document/show/{id}', "HomeController@orderShow")->name('faculty.document.show');
        Route::delete('/order/delete/{id}', [HomeController::class, 'userOrderDelete'])->name('faculty.document.delete');

        // Password Change
        Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
        Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
        
        
    });

    Route::group(['prefix' => '/department', 'middleware' => ['auth', 'role:department']], function () {
        // Routes accessible to users with 'faculty' role
        Route::get('/', 'DepartmentController@index')->name('department');
        Route::post('/faculty/clearance-request/clear/{student_id}', 'FacultyController@clearStudent')->name('faculty.clearance-request.clear');

        // Profile
        Route::get('/profile', [HomeController::class, 'profile'])->name('user-profile');
        Route::post('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');

        // Password Change
        Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
        Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
        
        
    });

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });