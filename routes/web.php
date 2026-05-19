<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\NewsController;

Route::get("/", [NewsController::class, "index"])->name("news.index");
Route::get("/post/{slug}", [NewsController::class, "show"])->name("news.show");

// Admin login (no middleware)

Route::get("admin/login", [AuthController::class, "showLogin"])->name(
    "admin.login",
);
Route::post("admin/login", [AuthController::class, "login"])->name(
    "admin.login.post",
);
Route::post("admin/logout", [AuthController::class, "logout"])->name(
    "admin.logout",
);

// Protected admin routes
Route::prefix("admin")
    ->name("admin.")
    ->middleware("admin.auth")
    ->group(function () {
        Route::resource("news", AdminNewsController::class)->except(["show"]);
        Route::get("media", [MediaController::class, "index"])->name(
            "media.index",
        );
        Route::post("media", [MediaController::class, "store"])->name(
            "media.store",
        );
        Route::delete("media/{media}", [
            MediaController::class,
            "destroy",
        ])->name("media.destroy");
    });
