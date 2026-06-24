<?php

namespace Panelis\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Filament\Forms\Components\RichEditor\MentionProvider;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\View\View;
use Panelis\Blog\Models\Blog;
use Panelis\Event\Models\Schedule;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::query()
            ->published()
            ->paginate(10);

        seo()->title(__('blog.label'))
            ->description(__('blog.meta_description'));

        return view('blog::index', compact('blogs'));
    }

    public function view(string $slug): View
    {
        $blog = Blog::getBySlug($slug);
        $image = $blog->getMedia('images')?->first()?->getUrl('header');

        seo()->title($blog->title)
            ->description(__('blog.meta_description'))
            ->images($image);

        $content = RichContentRenderer::make($blog->content)
            ->mergeTags([
                'app' => config('app.name'),
            ])
            ->mentions([
                MentionProvider::make('#')
                    ->getLabelsUsing(function (array $ids): array {
                        return Schedule::query()
                            ->select('title', 'slug')
                            ->whereIn('id', $ids)
                            ->pluck('title', 'id')
                            ->all();
                    })
                    ->url(fn (string $slug): string => route('schedule.view', $slug)),
            ])
            ->toHtml();

        return view('blog::view', compact('blog', 'content', 'image'));
    }
}
