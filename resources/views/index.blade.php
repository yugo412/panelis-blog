@use(Panelis\Blog\Panel\Resources\BlogResource\Pages\CreateBlog)

@extends('layouts.daisy')

@section('content')

<div class="max-w-5xl mx-auto py-6 lg:py-8">

  <div class="rounded-3xl overflow-hidden bg-gradient-to-r from-primary to-secondary text-primary-content">

    <div class="px-6 py-8 md:px-8 md:py-10">

      <div class="flex items-start gap-4">

        <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-white/10 backdrop-blur shrink-0">

          <x-icons.line.article class="w-7 h-7" />

        </div>

        <div>

          <h1 class="text-3xl md:text-4xl font-bold tracking-tight">
            @lang('blog.label')
          </h1>

          <p class="mt-3 max-w-2xl text-sm md:text-base leading-7 text-primary-content/80">
            Insight, tips, cerita komunitas, dan berbagai panduan seputar dunia lari untuk membantu pelari tetap berkembang dan termotivasi.
          </p>

        </div>

      </div>

    </div>

  </div>

  <div class="mt-6 bg-base-100 rounded-2xl border border-base-300 overflow-hidden">

    @foreach ($blogs as $blog)

      <article @class([
        'group',
        !$loop->last ? 'border-b border-base-300/70' : ''
      ])>

        <a
          wire:navigate
          href="{{ route('blog.view', $blog->slug) }}"
          class="block px-6 py-6 transition-colors hover:bg-base-200/40"
        >

          <div class="flex items-start justify-between gap-6">

            <div class="min-w-0 flex-1">

              <h2 class="text-xl md:text-2xl font-semibold tracking-tight leading-snug group-hover:text-primary transition">

                {{ $blog->title }}

              </h2>

              <div class="mt-4 flex items-center gap-2 text-sm text-base-content/55">

                <x-icons.line.calendar-2 class="w-4 h-4 shrink-0" />

                <span>
                  @datetimeDiff($blog->published_at)
                </span>

              </div>

            </div>

            <div class="hidden sm:flex shrink-0 pt-1">

              <x-icons.line.arrow-right-s class="w-7 h-7 text-base-content/20 group-hover:text-primary transition" />

            </div>

          </div>

        </a>

      </article>

    @endforeach

  </div>

  <div class="mt-6">
    {{ $blogs->links() }}
  </div>

  @admin

    <div class="fab fixed right-6 z-50 bottom-[5rem] sm:bottom-[2rem]">

      <div tabindex="0" role="button" class="btn btn-primary btn-circle shadow-lg">
        <x-icons.fill.tools class="h-4 w-4"/>
      </div>

      <div class="fab-close">
        <span class="btn btn-circle btn-error">✕</span>
      </div>

      <div class="tooltip tooltip-left" data-tip="@lang('ui.btn.create')">

        <a
          href="{{ CreateBlog::getUrl() }}"
          class="btn btn-circle btn-secondary shadow-lg"
        >
          <x-icons.line.file-add class="h-5 w-5" />
        </a>

      </div>

    </div>

  @endadmin

</div>

@endsection
