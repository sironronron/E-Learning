<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Welcome Page
Route::get('/welcome', 'PageController@welcome');
Route::get('/getCategories', 'PageController@navCategories');

Route::get('/search_query', 'SearchController@searchCourses');

Route::prefix('course')->group(function () {
    // Course Pages
    Route::get('/{slug}', 'PageController@showCourse');
    Route::get('/getCourseOverviewURL/{slug}', 'PageController@getCourseOverviewURL');
    // Course Instructor Page
    Route::get('/instructor/{username}', 'PageController@showInstructor');
    // Course Category
    Route::get('/category/{slug}', 'PageController@showCategory');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    // Fetch User Data for Auth
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // User Settings
    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
    Route::patch('settings/change-avatar', 'Settings\AvatarController@update');

});

// Course
Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('instructor')->group(function () {
        // CRUD for Courses
        Route::resource('/courses', 'Instructor\Courses\CourseController');
        Route::get('/courses/{slug}/editImage', 'Instructor\Courses\CourseController@editImage');
        Route::post('/courses/{id}/updateImage', 'Instructor\Courses\CourseController@updateImage');

        // Course Section
        Route::post('/courses/section/add_section/{id}', 'Instructor\Courses\CourseSectionController@store');
            /// Update Section Order
            Route::put('/courses/section/order_index/{id}', 'Instructor\Courses\CourseSectionController@updateOrderIndex');
            
        // Course Section Lesson
        Route::get('/courses/section/add_lesson/get/{id}', 'Instructor\Courses\CourseSectionLessonController@create');
        Route::post('/courses/section/add_lesson/post', 'Instructor\Courses\CourseSectionLessonController@store');

        // Course Section Quiz
        Route::get('/courses/section/add_quiz/get/{id}', 'Instructor\Courses\CourseSectionQuizController@create');
        Route::post('/courses/section/add_quiz/post', 'Instructor\Courses\CourseSectionQuizController@store');

        Route::patch('/settings/email', 'Settings\ProfileController@updateEmail');
        Route::post('/settings/avatar', 'Settings\ProfileController@updateAvatar');

        // Register as an Instructor
        Route::post('/instructor-registration/v2', 'Instructor\UserInstructorQuestionController@store');
    });
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});


Route::prefix('cart')->group(function () {
    Route::group(['middleware' => 'auth:api'], function () {

        // Add to cart
        Route::post('/store', 'Cart\CartController@store');

    });
});

// Help-center
Route::prefix('help-center')->group(function () {
    Route::get('/', 'HelpCenter\PageController@index');
    Route::get('/category/{slug}', 'HelpCenter\PageController@category');
    Route::get('/category/post/{categoryId}/{postSlug}', 'HelpCenter\PageController@post');
    Route::get('/search', 'HelpCenter\SearchController@search');

    // Contact Us
    Route::post('/customer_inquiry', 'HelpCenter\ContactController@store');
});