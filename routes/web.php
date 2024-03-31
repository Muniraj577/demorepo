<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ArtistController as AdminArtistController;
use App\Http\Controllers\Admin\MusicController as AdminMusicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware("guest");

Route::group(['prefix' => 'admin', 'as' => 'admin.', "middleware" => "auth"], function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::group(["prefix" => "user", "as" => "user.", "middleware" => "roles:super_admin"], function () {
        Route::get("", [AdminUserController::class, "index"])->name("index");
        Route::post("all", [AdminUserController::class, "allUsers"])->name("allUsers");
        Route::get("create", [AdminUserController::class, "create"])->name("create");
        Route::post("store", [AdminUserController::class, "store"])->name("store");
        Route::get("edit/{id}", [AdminUserController::class, "edit"])->name("edit");
        Route::match(["put", "patch"], "update/{id}", [AdminUserController::class, "update"])->name("update");
        Route::delete("delete/{id}", [AdminUserController::class, "delete"])->name("delete");
    });

    Route::group(["prefix" => "artist", "as" => "artist."], function () {
        Route::group(['middleware' => 'roles:super_admin,artist_manager,artist'], function () {
            Route::get("", [AdminArtistController::class, "index"])->name("index");
            Route::get("musics/{id}", [AdminMusicController::class, "index"])->name("musics");
        });
        Route::group(['middleware' => 'roles:artist_manager'], function () {
            Route::get("create", [AdminArtistController::class, "create"])->name("create")->middleware('roles:artist_manager');
            Route::post("store", [AdminArtistController::class, "store"])->name("store");
            Route::get("edit/{id}", [AdminArtistController::class, "edit"])->name("edit");
            Route::match(["put", "patch"], "update/{id}", [AdminArtistController::class, "update"])->name("update");
            Route::delete("delete/{id}", [AdminArtistController::class, "delete"])->name("delete");
            Route::get('export', [AdminArtistController::class, "export"])->name("export");
            Route::post('import', [AdminArtistController::class, "import"])->name("import");
        });
    });

    Route::group(["prefix" => "music", "as" => "music.", 'middleware' => 'roles:artist'], function () {
        Route::post("store", [AdminMusicController::class, "store"])->name("store");
        Route::get("edit/{id}", [AdminMusicController::class, "edit"])->name("edit");
        Route::match(["PUT", "PATCH"], "update/{id}", [AdminMusicController::class, "update"])->name("update");
        Route::delete("delete/{id}", [AdminMusicController::class, "destroy"])->name("delete");
    });
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
