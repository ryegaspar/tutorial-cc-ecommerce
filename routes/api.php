<?php

use App\Models\Category;

Route::get('/', function () {
    $categories = Category::parents()->get();
    dd($categories);
});
