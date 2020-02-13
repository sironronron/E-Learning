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

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('{slug}/learn/{id}', 'Enroll\EnrollController@showLessons');
    });

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

    // My Courses
    Route::prefix('student/account/my-courses')->group(function () {
        Route::get('/learning', 'User\UserCoursesController@myCourses');
        Route::get('/learning/search', 'User\UserCoursesController@search');
        Route::get('/learning/{id}/lesson/{slug}/show', 'User\UserCoursesController@showCourseLessons');

        // Get Course overview
        Route::get('/learning/{slug}/show/overview', 'User\UserCoursesController@getCourseDetails');

        // Get Course QNA
        Route::get('/learning/{slug}/show/qanda', 'User\UserCoursesController@getQandA');
        Route::get('/learning/{id}/reply/qanda', 'User\CourseQandAController@showReplies');
        Route::post('/learning/{id}/reply/save', 'User\CourseQandAController@reply');
        Route::patch('/learning/{id}/reply/answered', 'User\CourseQandAController@markAsAnswered');

        // Get Announcements
        Route::get('/learning/{slug}/show/announcements', 'User\CourseAnnouncementController@index');
        Route::post('/learning/{slug}/save/announcement', 'User\CourseAnnouncementController@store');

        // Show Lesson
        Route::get('/learning/{slug}/show/lesson/{id}', 'User\UserCoursesController@showLesson');

        // Save new Question
        Route::post('/learning/qanda/store', 'User\CourseQandAController@store');

        // Save progress
        Route::patch('/learning/lesson/{id}/finish', 'User\CourseUserProgressController@update');

        // Save Rating
        Route::get('/rating/edit/{id}', 'User\CourseRatingController@edit');
        Route::post('/rating/save', 'User\CourseRatingController@store');
        // Update Rating
        Route::patch('/rating/patch/{id}', 'User\CourseRatingController@update');
    });


});

// Record user searches
Route::post('search/userSearches', 'User\UserSearchController@store');

// Course
Route::group(['middleware' => 'auth:api'], function () {
    Route::prefix('instructor')->group(function () {
        // Search
        Route::get('/courses/search', 'Instructor\Courses\PageController@search');

        // CRUD for Courses
        Route::resource('/courses', 'Instructor\Courses\CourseController');
        // Edit Image
        Route::get('/courses/{slug}/editImage', 'Instructor\Courses\CourseController@editImage');
        Route::post('/courses/{id}/updateImage', 'Instructor\Courses\CourseController@updateImage');
        // Edit Status
        Route::patch('/courses/{id}/editStatus', 'Instructor\Courses\CourseController@editStatus');


        // Course Section
        Route::post('/courses/section/add_section/{id}', 'Instructor\Courses\CourseSectionController@store');
        // Get Editable data / Update Section
        Route::get('/courses/section/edit_section/{id}/get', 'Instructor\Courses\CourseSectionController@edit');
        Route::patch('/courses/section/edit_section/{id}/patch', 'Instructor\Courses\CourseSectionController@update');
        // Delete Section
        Route::delete('/courses/section/delete_section/{id}', 'Instructor\Courses\CourseSectionController@destroy');
        // Update Section Order
        Route::put('/courses/section/order_index/{id}', 'Instructor\Courses\CourseSectionController@updateOrderIndex');
        // Update Section Lessons Order
        Route::put('/courses/section/lesson/order_index/{id}', 'Instructor\Courses\CourseSectionLessonController@updateOrderIndex');

        // Course Section Lesson
        Route::get('/courses/section/add_lesson/get/{id}', 'Instructor\Courses\CourseSectionLessonController@create');
        Route::post('/courses/section/add_lesson/post', 'Instructor\Courses\CourseSectionLessonController@store');

        Route::get('/courses/section/edit_lesson/get/{id}', 'Instructor\Courses\CourseSectionLessonController@edit');
        Route::patch('/courses/section/edit_lesson/patch/{id}', 'Instructor\Courses\CourseSectionLessonController@update');

        Route::delete('/courses/section/delete_lesson/{id}', 'Instructor\Courses\CourseSectionLessonController@destroy');

        // Course Section Quiz
        Route::get('/courses/section/add_quiz/get/{id}', 'Instructor\Courses\CourseSectionQuizController@create');
        Route::post('/courses/section/add_quiz/store', 'Instructor\Courses\CourseSectionQuizController@store');

        // Course Quizbank
        Route::post('/courses/section/add_quiz_bank/post', 'Instructor\Courses\CourseSectionQuizBankController@store');

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
        Route::get('/cartItems', 'Cart\CartController@index');

        // Add to cart
        Route::post('/store', 'Cart\CartController@store');

        // Subscription
        Route::get('/subscribe/course/{id}/get', 'Enroll\EnrollController@show');
        Route::post('/subscribe/course/{id}/post', 'Enroll\EnrollController@enroll');

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
