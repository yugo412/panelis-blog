<?php

namespace Panelis\Blog\Models;

use Database\Factories\BlogFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Panelis\Blog\Panel\Resources\BlogResource\Enums\BlogStatus;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property array<array-key, mixed>|null $content
 * @property BlogStatus $status
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read mixed $is_published
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @method static \Database\Factories\BlogFactory factory($count = null, $state = [])
 * @method static Builder<static>|Blog newModelQuery()
 * @method static Builder<static>|Blog newQuery()
 * @method static Builder<static>|Blog onlyTrashed()
 * @method static Builder<static>|Blog published($isAdmin = false)
 * @method static Builder<static>|Blog query()
 * @method static Builder<static>|Blog whereContent($value)
 * @method static Builder<static>|Blog whereCreatedAt($value)
 * @method static Builder<static>|Blog whereDeletedAt($value)
 * @method static Builder<static>|Blog whereId($value)
 * @method static Builder<static>|Blog wherePublishedAt($value)
 * @method static Builder<static>|Blog whereSlug($value)
 * @method static Builder<static>|Blog whereStatus($value)
 * @method static Builder<static>|Blog whereTitle($value)
 * @method static Builder<static>|Blog whereUpdatedAt($value)
 * @method static Builder<static>|Blog withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Blog withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Blog extends Model implements HasMedia, Sitemapable
{
    /** @use HasFactory<BlogFactory> */
    use HasFactory;

    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'status' => BlogStatus::class,
            'published_at' => 'datetime',
        ];
    }

    public function isPublished(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->status && BlogStatus::Published && $this->published_at->lte(now());
            },
        );
    }

    public function scopePublished(Builder $builder, $isAdmin = false): Builder
    {
        if ($isAdmin) {
            return $builder;
        }

        return $builder->whereDate('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->whereStatus(BlogStatus::Published);
    }

    public static function getBySlug(string $slug): Blog
    {
        return self::query()
            ->whereSlug(trim($slug))
            ->published((Auth::user()?->is_admin || Auth::user()?->is_root) ?? false) // always display for admin
            ->firstOrFail();
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('blog.view', $this->slug))
            ->setLastModificationDate($this->updated_at);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('header')
            ->width(1200)
            ->quality(85)
            ->performOnCollections('images');
    }
}
