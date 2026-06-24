@use(Panelis\Blog\Panel\Resources\BlogResource\Pages\EditBlog)

@extends('layouts.daisy')

@section('content')

<article class="max-w-4xl mx-auto py-6 lg:py-8">

  <div class="overflow-hidden rounded-3xl border border-base-300 bg-base-100 shadow-sm">

    @if ($image)
      <div class="relative overflow-hidden border-b border-base-300">

        <img
          src="{{ $image }}"
          alt="{{ $blog->title }}"
          class="w-full aspect-[16/8] object-cover"
        />

        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/5 to-transparent"></div>

      </div>
    @endif

    <div class="px-6 py-8 md:px-10 md:py-10">

      <header class="mb-10">

        <div class="flex flex-wrap items-center gap-3">

          @admin
            @if (!$blog->is_published)

              <span class="inline-flex items-center rounded-xl bg-info/10 px-3 py-1 text-sm font-medium text-info">
                Preview mode
              </span>

            @endif
          @endadmin

          <span class="inline-flex items-center rounded-xl border border-base-300 bg-base-200/70 px-3 py-1 text-sm text-base-content/60">

            <x-icons.line.calendar-2 class="w-4 h-4 mr-2" />

            @datetime($blog->published_at)

          </span>

        </div>

        <h1 class="mt-5 text-3xl md:text-4xl font-bold tracking-tight leading-tight">

          {{ $blog->title }}

        </h1>

      </header>

      <div
        class="
          prose prose-sm max-w-none leading-relaxed

          [&_p]:my-4

          [&_a]:text-primary
          [&_a]:underline
          [&_a]:underline-offset-2
          [&_a:hover]:text-primary-focus

          [&_h2]:mt-8 [&_h2]:mb-3 [&_h2]:text-xl [&_h2]:font-semibold
          [&_h3]:mt-6 [&_h3]:mb-2 [&_h3]:text-lg [&_h3]:font-semibold

          [&_ul]:list-disc [&_ul]:pl-6 [&_ul]:my-4
          [&_ol]:list-decimal [&_ol]:pl-6 [&_ol]:my-4
        "
      >
        {!! $content !!}
      </div>

    </div>

  </div>

  <div class="mt-5 flex items-center justify-between gap-4">

    <a
      wire:navigate
      href="{{ route('blog.index') }}"
      class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-primary-focus transition"
    >

      <x-icons.line.arrow-left class="w-4 h-4" />

      <span>
        @lang('blog.btn.back')
      </span>

    </a>

  </div>

  @admin

    <div class="fab fixed right-6 z-50 bottom-[5rem] sm:bottom-[2rem]">

      <div tabindex="0" role="button" class="btn btn-primary btn-circle shadow-lg">
        <x-icons.fill.tools class="h-4 w-4"/>
      </div>

      <div class="fab-close">
        <span class="btn btn-circle btn-error">✕</span>
      </div>

      <div class="tooltip tooltip-left" data-tip="@lang('ui.btn.edit')">

        <a
          href="{{ EditBlog::getUrl(['record' => $blog]) }}"
          class="btn btn-circle btn-secondary shadow-lg"
        >
          <x-icons.line.file-edit class="h-5 w-5" />
        </a>

      </div>

    </div>

  @endadmin

</article>

@endsection
