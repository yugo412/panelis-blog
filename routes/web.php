<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Panelis\Blog\Http\Controllers\BlogController;

Route::get('/blog', [BlogController::class, 'index'])->name('index');
Route::get('/blog/{slug}', [BlogController::class, 'view'])->name('view');
