<?php

namespace Panelis\Blog\Panel\Resources\BlogResource\Forms;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\MentionProvider;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Panelis\Blog\Panel\Resources\BlogResource\Enums\BlogStatus;
use Panelis\Event\Models\Schedule;

class BlogForm
{
    public static function schema(): array
    {
        return [
            Section::make()
                ->columnSpan(2)
                ->schema([
                    TextInput::make('title')
                        ->label(__('blog.title'))
                        ->live(onBlur: true)
                        ->required()
                        ->afterStateUpdated(function (?string $state, Set $set): void {
                            if (! empty($state)) {
                                $set('slug', Str::slug($state));
                            }
                        }),

                    TextInput::make('slug')
                        ->label(__('ui.slug'))
                        ->unique()
                        ->required(),

                    RichEditor::make('content')
                        ->hiddenLabel()
                        ->json()
                        ->mergeTags(['app'])
                        ->extraInputAttributes([
                            'style' => 'min-height: 20rem; overflow-y: auto;',
                        ])
                        ->mentions([
                            MentionProvider::make('#')
                                ->getSearchResultsUsing(function (string $search): array {
                                    return Schedule::search($search)
                                        ->orderBy('title')
                                        ->get()
                                        ->mapWithKeys(fn (Schedule $schedule): array => [
                                            $schedule->slug => vsprintf('%s - %s', [
                                                $schedule->title,
                                                Carbon::parse($schedule->started_at)->timezone(get_timezone())->year,
                                            ]),
                                        ])
                                        ->all();
                                })
                                ->getLabelsUsing(function (array $ids): array {
                                    return Schedule::query()
                                        ->select('title', 'slug')
                                        ->whereIn('id', $ids)
                                        ->get()
                                        ->pluck('title', 'slug')
                                        ->all();
                                }),
                        ]),
                ]),

            Section::make()
                ->columnSpan(1)
                ->schema([
                    SpatieMediaLibraryFileUpload::make('image')
                        ->hiddenLabel()
                        ->image()
                        ->collection('images')
                        ->conversion('header'),

                    Radio::make('status')
                        ->label(__('blog.status'))
                        ->default(BlogStatus::Draft)
                        ->options(BlogStatus::class),

                    DateTimePicker::make('published_at')
                        ->label(__('blog.published_at'))
                        ->seconds(false)
                        ->native(false),
                ]),
        ];
    }
}
