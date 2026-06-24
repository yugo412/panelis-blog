<?php

declare(strict_types=1);

namespace Panelis\Blog\Plugins;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Panelis\Blog\Panel\Resources\BlogResource;

class BlogPlugin implements Plugin
{
    public function getId(): string
    {
        return 'blog';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            BlogResource::class,
        ]);
    }

    public function boot(Panel $panel): void {}
}
