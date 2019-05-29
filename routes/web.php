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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

//------------------------------------------------
// Group for users actions
//------------------------------------------------
Route::middleware(['auth','activeUser'])->group(function () {  
        
    // Matching
    Route::post('/match', 'MatchingController@match')->name('match');
    Route::delete('/unmatch', 'MatchingController@unmatch')->name('unmatch');

    // See who I matched and who matched me
    Route::get('/my_matches', 'MatchingController@my_matches')->name('my_matches');
    Route::get('/matched_with_me', 'MatchingController@matched_me')->name('matched_me');
    Route::get('/both_match', 'MatchingController@both_match')->name('both_match');

    // Messages
    Route::get('/messages/{id1}/{id2}', 'MessageController@index')->name('messages');
    Route::post('/message', 'MessageController@store')->name('store_message');
    Route::get('/return_messages/{id1}/{id2}', 'MessageController@return_messages_js')->name('return_messages');

    // Discussions
    Route::get('/my_discussions', 'MessageController@my_discussions')->name('my_discussions');

    // flagging
    Route::post('/flag', 'FlagController@flag')->name('flag');
    Route::delete('/unflag', 'FlagController@unflag')->name('unflag');

    // Get profile
    Route::get("/get_profile/{id}", "ProfilController@get_profile")->name("get_profile");


    // Get pictures
    Route::get('/picture/{profile_id}/{picture_link}', 'ProfilController@profilePicture')->name('picture');
    Route::get('/picture/{profile_id}/{picture_link}/full', 'ProfilController@fullPicture')->name('full_picture');

    

    // Search
     Route::get('/search_page', 'SearchController@index')->name('all_active_users');

    //Filtred search
    Route::get('/search', 'SearchController@search_profiles')->name('search_profiles');

    //Sort users
    Route::get('/sort', 'SearchController@sort_users')->name('sort_users');

    // Search user by name
    Route::get('/search_by_name', 'SearchController@search_user_by_name')->name('search_user_by_name');
    

}); 


//------------------------------------------------
// Group for active or waiting for interview
//------------------------------------------------
Route::middleware(['auth', 'wfeOrActiveUser'])->group(function () {

    // Manage pictures
    Route::post('/picture_upload', 'PictureController@add_picture')->name('add_picture');
    Route::post('/change_to_main_picture', 'PictureController@change_to_main_picture')->name('change_to_main_picture');  
    Route::delete('/delete_picture', 'PictureController@delete_picture')->name('delete_picture');
    
    // Edit profile
    Route::get('/edit_profile', 'ProfilController@edit_profile')->name('edit_profile');
    Route::post('/update_profile', 'ProfilController@update_profile')->name('update_profile');


    // Access profile
    Route::get("/my_profile", "ProfilController@my_profile")->name("my_profile");
    // Access my pictures
    Route::get('/my_pictures/{profile_id}/{picture_link}', 'ProfilController@profilePicture')->name('my_pictures');
    

    Route::get('/my_pictures/{profile_id}/{picture_link}/full', 'ProfilController@fullPicture')->name('my_full_pictures');

});


//------------------------------------------------
// Group for registred user
//------------------------------------------------
Route::middleware(['auth', 'registredUser'])->group(function () {

    // Create profile
    Route::get('/create_profile', 'ProfilController@create_profile')->name('create_profile');

    // Submit profile
    Route::post("/post_profile", "ProfilController@store")->name("store_profil");
});



//------------------------------------------------
// Group for admin actions
//------------------------------------------------
Route::middleware(['auth','adminUser'])->group(function () {
    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/interviews', 'DashboardController@interviews')->name('interviews');
    Route::get('/active', 'DashboardController@active_users')->name('active_users');
    Route::get('/expired', 'DashboardController@expired_users')->name('expired_users');
    Route::get('/banned_users', 'DashboardController@admin_banned_users')->name('admin_banned_users');

    // Get user from admin
    Route::get("/admin_get_profile/{id}", "DashboardController@get_profile")->name("admin_get_profile");
    Route::get('/admin_pictures/{profile_id}/{picture_link}', 'ProfilController@profilePicture')->name('admin_pictures');
    
    Route::get('/admin_pictures/{profile_id}/{picture_link}/full', 'ProfilController@fullPicture')->name('admin_full_pictures'); 

    

    // Get users discussion list
    Route::get('/admin_users_discussions/{id}', 'DashboardController@users_discussions')->name('admin_users_discussions');

    // Access a discussion from admin
    Route::get('/admin_user_messages/{id1}/{id2}', 'DashboardController@users_messages')->name('admin_user_messages');
    
    // Change status
    Route::post('/change_status', 'DashboardController@Change_user_status')->name('Change_user_status');

    // Change expiration date
    Route::post('/Change_expiration_date', 'DashboardController@Change_expiration_date')->name('Change_expiration_date');


    // Manage flagged users
    Route::get('/new_flagged_users', 'DashboardController@flagged_users')->name('admin_new_flagged_users');
    Route::get('/flagged_users', 'DashboardController@flagged_users')->name('admin_flagged_users');
    Route::post('/flagged_action', 'DashboardController@flagged_action')->name('admin_flagged_action');
});


//------------------------------------------------
// Group for super admin actions
//------------------------------------------------
Route::middleware(['auth','superAdminUser'])->group(function () {
    // admin
    Route::get('/manage_admin', 'DashboardController@manage_admin')->name('manage_admin');
    Route::post('/register_admin', 'Auth\RegisterController@register_admin')->name('register_admin');
    Route::delete('/delete_user/{id}', 'Auth\RegisterController@delete_user')->name('admin_delete_user');
    Route::post('/save_interview_report', 'DashboardController@save_interview_report')->name('save_interview_report');

    // Create a free account
    Route::get('/create_free_account', 'DashboardController@create_free_account')->name('create_free_account');
    Route::post('/store_free_account', 'DashboardController@store_free_account')->name('store_free_account');

});


Route::middleware(['auth'])->group(function () {  
    
    // Change password
    Route::get('/change_password', 'ChangePasswordController@index')->name('change_password');
    Route::post('/store_new_password', 'ChangePasswordController@store_new_password')->name('store_new_password');


    // Expired account
    Route::get('/expired_account', 'ExpiredAccountController@expired_user')->name('expired_account');

    // Banned user    
    Route::get('/banned', 'ExpiredAccountController@banned_user')->name('banned_account');

    // Feedback
    Route::post('/feedback', 'DashboardController@feedback')->name('feedback');

    // Users delete account
    Route::post('/remove_my_account', 'ProfilController@remove_my_account')->name('remove_my_account');

});
