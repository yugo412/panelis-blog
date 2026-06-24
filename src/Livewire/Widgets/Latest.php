<?php

namespace Panelis\Blog\Livewire\Widgets;

use Illuminate\Contracts\Support\Renderable;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Panelis\Blog\Models\Blog;
use Panelis\Blog\Panel\Resources\BlogResource\Enums\BlogStatus;

#[Lazy]
class Latest extends Component
{
    public function render(): Renderable
    {
        $blogs = Blog::query()
            ->whereDate('published_at', '<=', now())
            ->whereStatus(BlogStatus::Published)
            ->orderByDesc('published_at')
            ->take(10)
            ->get();

        return view('blog::livewire.widgets.latest', compact('blogs'));
    }
}
