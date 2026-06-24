<?php

namespace Panelis\Blog\Panel\Resources\BlogResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Panelis\Blog\Panel\Resources\BlogResource;
use Panelis\Blog\Panel\Resources\BlogResource\Enums\BlogStatus;

use function Illuminate\Support\now;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['status'] === BlogStatus::Published && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
