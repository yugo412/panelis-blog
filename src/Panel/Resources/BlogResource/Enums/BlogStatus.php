<?php

namespace Panelis\Blog\Panel\Resources\BlogResource\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum BlogStatus: string implements HasColor, HasLabel
{
    case Draft = 'draft';

    case Published = 'published';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Published => 'success',
            default => 'grey',
        };
    }

    public function getLabel(): string|Htmlable|null
    {
        return __('blog.status_'.$this->value);
    }
}
