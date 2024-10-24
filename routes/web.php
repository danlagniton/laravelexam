<?php

use Illuminate\Support\Facades\Route;

Route::macro('softDeletes', function ($uri, $controller) {
    Route::get("$uri/trashed", "$controller@trashed")->name("$uri.trashed");
    Route::patch("$uri/{user}/restore", "$controller@restore")->name("$uri.restore");
    Route::delete("$uri/{user}/delete", "$controller@delete")->name("$uri.delete");
});
