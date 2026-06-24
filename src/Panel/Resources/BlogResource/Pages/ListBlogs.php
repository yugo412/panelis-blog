<?php

namespace Panelis\Blog\Panel\Resources\BlogResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Panelis\Blog\Panel\Resources\BlogResource;

class ListBlogs extends ListRecords
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
