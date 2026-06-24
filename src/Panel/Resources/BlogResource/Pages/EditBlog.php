<?php

namespace Panelis\Blog\Panel\Resources\BlogResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Panelis\Blog\Models\Blog;
use Panelis\Blog\Panel\Resources\BlogResource;
use Panelis\Blog\Panel\Resources\BlogResource\Enums\BlogStatus;

use function Illuminate\Support\now;

class EditBlog extends EditRecord
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label(__('ui.btn.preview'))
                ->openUrlInNewTab()
                ->url(fn (Blog $record): string => route('blog.view', $record->slug)),

            ActionGroup::make([
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ]),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['published_at']) && $data['status'] === BlogStatus::Published) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
