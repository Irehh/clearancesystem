<?php

use Illuminate\Support\Facades\Auth;

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
    Route::get('/about-us', 'FrontendController@aboutUs')->name('about-us');
    Route::get('/contact', 'FrontendController@contact')->name('contact');
    Route::post('/contact/message', 'MessageController@store')->name('contact.store');
    Route::get('/vendor-detail/{slug}', 'FrontendController@vendorDetail')->name('vendor-detail');
    Route::get('product-detail/{slug}', 'FrontendController@productDetail')->name('product-detail');
    Route::post('/product/search', 'FrontendController@productSearch')->name('product.search');
    Route::get('/product-cat/{slug}', 'FrontendController@productCat')->name('product-cat');
    Route::get('/product-sub-cat/{slug}/{sub_slug}', 'FrontendController@productSubCat')->name('product-sub-cat');
    Route::get('/product-brand/{slug}', 'FrontendController@productBrand')->name('product-brand');
    Route::get('/redirect-to-whatsapp/{userId}/{productSlug}', 'FrontendController@redirectToWhatsApp')->name('redirect-to-whatsapp');


// Cart section
    Route::get('/add-to-cart/{slug}', 'CartController@addToCart')->name('add-to-cart')->middleware('user');
    Route::post('/add-to-cart', 'CartController@singleAddToCart')->name('single-add-to-cart')->middleware('user');
    Route::get('cart-delete/{id}', 'CartController@cartDelete')->name('cart-delete');
    Route::post('cart-update', 'CartController@cartUpdate')->name('cart.update');

    Route::get('/cart', function () {
        return view('frontend.pages.cart');
    })->name('cart');
    Route::get('/checkout', 'CartController@checkout')->name('checkout')->middleware('user');
// Wishlist
    Route::get('/wishlist', function () {
        return view('frontend.pages.wishlist');
    })->name('wishlist');
    Route::get('/wishlist/{slug}', 'WishlistController@wishlist')->name('add-to-wishlist')->middleware('user');
    Route::get('wishlist-delete/{id}', 'WishlistController@wishlistDelete')->name('wishlist-delete');
    Route::post('cart/order', 'OrderController@store')->name('cart.order');
    Route::get('order/pdf/{id}', 'OrderController@pdf')->name('order.pdf');
    Route::get('/income', 'OrderController@incomeChart')->name('product.order.income');

// Order Track
    Route::get('/product/track', 'OrderController@orderTrack')->name('order.track');
    Route::post('product/track/order', 'OrderController@productTrackOrder')->name('product.track.order');



// Product Review
    Route::resource('/review', 'ProductReviewController');
    Route::post('product/{slug}/review', 'ProductReviewController@store')->name('review.store');

// Post Comment
    Route::post('post/{slug}/comment', 'PostCommentController@store')->name('post-comment.store');
    Route::resource('/comment', 'PostCommentController');
// Coupon
    Route::post('/coupon-store', 'CouponController@couponStore')->name('coupon-store');
// Payment
    Route::get('payment', 'PayPalController@payment')->name('payment');
    Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
    Route::get('payment/success', 'PayPalController@success')->name('payment.success');


// Backend section start

    Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {
        Route::get('/', 'AdminController@index')->name('admin');
        Route::get('/file-manager', function () {
            return view('backend.layouts.file-manager');
        })->name('file-manager');
        // user route
        Route::resource('users', 'UsersController');
        // Banner
        Route::resource('banner', 'BannerController');
        // Brand
        Route::resource('brand', 'BrandController');
        // Profile
        Route::get('/profile', 'AdminController@profile')->name('admin-profile');
        Route::post('/profile/{id}', 'AdminController@profileUpdate')->name('profile-update');
        // Category
        Route::resource('/category', 'CategoryController');
        // Product
        Route::resource('/product', ProductController::class);
        
        // Ajax for sub category
        Route::post('/category/{id}/child', 'CategoryController@getChildByParent');
        // POST category
        Route::resource('/post-category', 'PostCategoryController');
        // Post tag
        Route::resource('/post-tag', 'PostTagController');
        // Post
        Route::resource('/post', 'PostController');
        // Message
        Route::resource('/message', 'MessageController');
        Route::get('/message/five', 'MessageController@messageFive')->name('messages.five');

        // Order
        Route::resource('/order', 'OrderController');
        // Shipping
        Route::resource('/shipping', 'ShippingController');
        // Coupon
        Route::resource('/coupon', 'CouponController');
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
        Route::resource('users', 'UsersController');
        //faculty
        Route::get('/faculty/create', 'StudentController@facultyfiles')->name('faculty.create');
        Route::post('/faculty', 'StudentController@storefacultyfiles')->name('faculty.store');
        // Brand
        Route::resource('brand', 'BrandController');
        // Profile
        Route::get('/profile', 'AdminController@profile')->name('admin-profile');
        Route::post('/profile/{id}', 'AdminController@profileUpdate')->name('profile-update');
        // Category
        Route::resource('/category', 'CategoryController');
        // Product
        Route::resource('/product/create', 'StudentController@hmm');
        
        // Ajax for sub category
        Route::post('/category/{id}/child', 'CategoryController@getChildByParent');
        // POST category
        Route::resource('/post-category', 'PostCategoryController');
        // Post tag
        Route::resource('/post-tag', 'PostTagController');
        // Post
        Route::resource('/post', 'PostController');
        // Message
        Route::resource('/message', 'MessageController');
        Route::get('/message/five', 'MessageController@messageFive')->name('messages.five');

        // Order
        Route::resource('/order', 'OrderController');
        // Shipping
        Route::resource('/shipping', 'ShippingController');
        // Coupon
        Route::resource('/coupon', 'CouponController');
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
    
    Route::group(['prefix' => '/faculty', 'middleware' => ['auth', 'role:faculty']], function () {
        // Routes accessible to users with 'faculty' role
        Route::get('/', 'FacultyController@index')->name('faculty');
        // Profile
        Route::get('/profile', 'HomeController@profile')->name('user-profile');
        Route::post('/profile', 'UserController@profileUpdate')->name('faculty.profile.update');
        //  Order
        Route::get('/order', "HomeController@orderIndex")->name('faculty.order.index');
        Route::get('/order/show/{id}', "HomeController@orderShow")->name('faculty.order.show');
        Route::delete('/order/delete/{id}', 'HomeController@userOrderDelete')->name('faculty.order.delete');
        // Product
        Route::post('/products', 'UserProductController@store')->name('faculty.products.store');
        Route::get('/products', 'UserProductController@index')->name('faculty.products.index');
        Route::get('/products/create', 'UserProductController@create')->name('faculty.products.create');
        Route::get('/products/{id}/edit', 'UserProductController@edit')->name('faculty.products.edit');
        Route::put('/products/{id}', 'UserProductController@update')->name('faculty.products.update');
        Route::delete('/products/{id}', 'UserProductController@destroy')->name('faculty.products.destroy');
        
        
        // Product Review
        Route::get('/user-review', 'HomeController@productReviewIndex')->name('user.productreview.index');
        Route::delete('/user-review/delete/{id}', 'HomeController@productReviewDelete')->name('user.productreview.delete');
        Route::get('/user-review/edit/{id}', 'HomeController@productReviewEdit')->name('user.productreview.edit');
        Route::patch('/user-review/update/{id}', 'HomeController@productReviewUpdate')->name('user.productreview.update');

        // Post comment
        Route::get('user-post/comment', 'HomeController@userComment')->name('user.post-comment.index');
        Route::delete('user-post/comment/delete/{id}', 'HomeController@userCommentDelete')->name('user.post-comment.delete');
        Route::get('user-post/comment/edit/{id}', 'HomeController@userCommentEdit')->name('user.post-comment.edit');
        Route::patch('user-post/comment/udpate/{id}', 'HomeController@userCommentUpdate')->name('user.post-comment.update');

        // Password Change
        Route::get('change-password', 'HomeController@changePassword')->name('user.change.password.form');
        Route::post('change-password', 'HomeController@changPasswordStore')->name('change.password');

        // Ajax for sub category
        Route::post('/category/{id}/child', 'HomeController@getChildByParent');
        
        
    });
    

   
    

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
