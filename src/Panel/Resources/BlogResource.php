<?php

namespace Panelis\Blog\Panel\Resources;

use BackedEnum;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Panelis\Blog\Models\Blog;
use Panelis\Blog\Panel\Resources\BlogResource\Enums\BlogStatus;
use Panelis\Blog\Panel\Resources\BlogResource\Forms\BlogForm;
use Panelis\Blog\Panel\Resources\BlogResource\Pages;

use function Illuminate\Support\now;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getLabel(): ?string
    {
        return __('blog.label');
    }

    public static function getNavigationLabel(): string
    {
        return __('blog.navigation');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'content'];
    }

    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            EditAction::make()
                ->url(static::getUrl('edit', ['record' => $record])),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components(BlogForm::schema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Blog')
            ->defaultSort('published_at', 'desc')
            ->columns([
                TextColumn::make('status')
                    ->label(__('blog.status'))
                    ->sortable()
                    ->badge(),

                TextColumn::make('title')
                    ->label(__('blog.title'))
                    ->size(TextSize::Medium)
                    ->url(fn (Blog $record): string => route('blog.view', $record->slug))
                    ->sortable()
                    ->searchable(),

                TextColumn::makeSinceDate('published_at', __('blog.published_at'), false),

                TextColumn::makeSinceDate('created_at', __('ui.created_at')),

                TextColumn::makeSinceDate('updated_at', __('ui.updated_at')),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('blog.status'))
                    ->options(BlogStatus::class),

                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('publish')
                    ->label(__('blog.btn.publish'))
                    ->icon(Heroicon::ArrowUp)
                    ->requiresConfirmation()
                    ->visible(fn (Blog $record): bool => $record->status !== BlogStatus::Published)
                    ->action(function (Blog $record): void {
                        $record->update([
                            'published_at' => now(),
                            'status' => BlogStatus::Published,
                        ]);
                    }),

                Action::make('unpublish')
                    ->label(__('blog.btn.unpublish'))
                    ->icon(Heroicon::ArrowDown)
                    ->requiresConfirmation()
                    ->visible(fn (Blog $record): bool => $record->status === BlogStatus::Published)
                    ->action(function (Blog $record): void {
                        $record->update([
                            'status' => BlogStatus::Draft,
                        ]);
                    }),

                ActionGroup::make([
                    EditAction::make(),

                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\ForceDeleteBulkAction::make(),
                    Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
