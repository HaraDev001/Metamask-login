<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AccessToken;
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



// Route::get('/', function () {
//     return view('blockchain');
// });
Auth::routes();

Route::post('/signup', [
	'uses' => 'AuthControllerEth@signup',
	'as' => 'signup',
	/*'middleware' => 'auth'*/
]);

Route::post('/metaauth', [
	'uses' => 'AuthControllerEth@metaAuth',
	'as' => 'metaauth',
	/*'middleware' => 'auth'*/
]);



// Route::get('/', [
// 	'uses' => 'AuthControllerEth@showLoginForm',
// 	'as' => 'loginEth',
	
// ]);

Route::get('/', [
	'uses' => 'NewArtworkController@index',
	'as' => '',
]);

Route::get('/arthome_new', function(){
	$nav_type = '2';
	return view('newarthome', compact('nav_type'));
});
Route::get('/creator_new', function(){
	$nav_type ='3';
	return view('newcreator', compact('nav_type'));
});
Route::get('/artwork_id_new', [
	'uses' => 'NewArtworkController@artwork_id',
	'as' => 'artwork_id_new',
]);
Route::get('/postarticle', function(){
	$nav_type ='0';
	return view('postarticle', compact('nav_type'));
});

Route::post('/user', [
	'uses' => 'AuthControllerEth@user',
	'as' => 'user',
	
]);

Route::get('/artworks_confirm_get', function(){
	return view('artworks_confirm');
});

Route::post('/artworks_confirm', [
	'uses' => 'AuthControllerEth@artworks_confirm',
	'as' => 'artworks_confirm',
]);

// Route::get('/welcome', function () {
// 	return view('welcome');
// });jwt.verify
Route::group(['middleware' => 'jwt.verify'], function() {
	// Route::get('/artworks_notmet', [
		// 	'uses' => 'ArtworkController@index_notmet',
		// 	'as' => 'artworks_notmet',
		// ]);
		// Route::get('/artworks_sold', [
			// 	'uses' => 'ArtworkController@index_sold',
			// 	'as' => 'artworks_sold',
			// ]);
	Route::get('/artworks', [
		'uses' => 'ArtworkController@index',
		'as' => 'artworks',
	]);
	
	Route::get('/arthome', function(){
		$nav_type = '2';
		return view('arthome', compact('nav_type'));
	});
	Route::get('/creator', function(){
		$nav_type ='3';
		return view('creator', compact('nav_type'));
	});
	Route::get('/artwork_id', [
		'uses' => 'ArtworkController@artwork_id',
		'as' => 'artwork_id',
	]);
	Route::get('/account', [
		'uses' => 'ArtworkController@account',
		'as' => 'account',
	]);
	Route::post('/bidart', [
		'uses' => 'ArtworkController@bidart',
		'as' => 'bidart',
	]);
	Route::post('/artworkpost', [
		'uses' => 'ArtworkController@upload',
		'as' => 'artworkpost',
	]);
	Route::get('/signout', [
		'uses' => 'AuthControllerEth@signout',
		'as' => 'signout',
	]);
	Route::get('/test',function(){
		return "web token verification passed through ";
	});
    // Route::get('user', 'UserController@getAuthenticatedUser');
    // Route::get('closed', 'DataController@closed');
});

// Route::group(['middleware' => ['jwt.token']], function() {
// 	Route::get('/welcome', function () {
// 		return view('welcome');
// 	});
	
// 	Route::get('/test',function(){
// 	return "web token verification passed through ";

// })->name('test');  
// }); /* end of jwt.auth middleware */
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
