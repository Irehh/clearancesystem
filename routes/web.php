<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FrontendController;

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

    Route::get('/', [FrontendController::class, 'home'])->name('home');
    

// Frontend Routes

    Route::get('/home', 'FrontendController@index');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
    Route::post('/contact/message', [MessageController::class, 'store'])->name('contact.store');
    





// Backend section start

    Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'role:admin','inactive']], function () {
        // Routes accessible to users with 'admin' role
        Route::get('/', 'AdminController@index')->name('admin');
        Route::get('/file-manager', function () {
            return view('backend.layouts.file-manager');
        })->name('file-manager');
        // user route
        Route::resource('users', 'UsersController');
        // Brand
        Route::resource('officers', 'ClearanceOfficersController');
        // Profile
        Route::get('/profile', 'AdminController@profile')->name('admin-profile');
        Route::post('/profile/{id}', 'AdminController@profileUpdate')->name('profile-update');
         // document
         Route::get('document', 'AdminController@document')->name('document');
         Route::post('document/update', 'AdminController@documentUpdate')->name('document.update');

             // Message
             Route::resource('/message', 'MessageController');
             Route::get('/message/five', [MessageController::class, 'messageFive'])->name('messages.five');
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
        Route::get('/profile', 'StudentController@profile')->name('student-profile');
        Route::post('/profile/{id}', 'StudentController@profileUpdate')->name('update.profile');
        Route::get('/restricted', function () {
            return view('restricted.index');
        });
    
        // Password Change
        Route::get('change-password', 'StudentController@changePassword')->name('change.password.student-form');
        Route::post('change-password', 'StudentController@changPasswordStore')->name('password.change');
        
        
    });
    
    Route::group(['prefix' => '/faculty', 'middleware' => ['auth', 'role:faculty']], function () {
        // Routes accessible to users with 'faculty' role
        Route::get('/', 'FacultyController@index')->name('faculty');
        // Profile
        Route::get('/profile', [FacultyController::class, 'profile'])->name('user-profile');
        Route::post('/profile/{id}', [FacultyController::class, 'profileUpdate'])->name('faculty-profile-update');
        //clear
        // web.php
        Route::post('/clearance-request/clear/{student_id}', 'FacultyController@clearStudent')->name('faculty.clearance-request.clear');
        Route::get('/document/show/{id}', "FacultyController@documentShow")->name('faculty.document.show');
        // Update document status to active
        Route::put('/faculty/document/{id}/update-status', 'FacultyController@updateDocumentStatus')->name('faculty.document.updateStatus');
        // Update document status to inactive
        Route::put('/faculty/document/{id}/update-status-inactive', 'FacultyController@updateDocumentInactive')->name('faculty.document.inactiveStatus');

        // Save document
        Route::put('/faculty/document/{id}/save', 'FacultyController@saveDocument')->name('faculty.document.save');


        // Password Change
        Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
        Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
        
        
    });

    Route::group(['prefix' => '/department', 'middleware' => ['auth', 'role:department']], function () {
        // Routes accessible to users with 'faculty' role
        Route::get('/', 'DepartmentController@index')->name('department');
        Route::post('/clearance-request/clear/{student_id}', 'DepartmentController@clearStudent')->name('department.clearance-request.clear');

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