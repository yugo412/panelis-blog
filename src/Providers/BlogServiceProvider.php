<?php

declare(strict_types=1);

namespace Panelis\Blog\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Panelis\Blog\Livewire\Widgets\Latest;

class BlogServiceProvider extends ServiceProvider
{
    private const NAMESPACE = 'blog';

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../lang', self::NAMESPACE);

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../../resources/views', self::NAMESPACE);

        Livewire::component('blog.widget.latest', Latest::class);

        Route::middleware('web')
            ->name('blog.')
            ->group(__DIR__.'/../../routes/web.php');
    }
}
