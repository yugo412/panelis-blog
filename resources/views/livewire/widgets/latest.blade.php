<div>

  @if ($blogs->isNotEmpty())

    <div class="overflow-hidden rounded-2xl border border-base-300 bg-base-100 shadow-sm">

      <div class="bg-gradient-to-r from-primary to-secondary px-5 py-5 text-primary-content">

        <div class="flex items-center gap-3">

          <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 backdrop-blur">

            <x-icons.line.article class="w-5 h-5" />

          </div>

          <div>

            <h3 class="text-xl font-semibold tracking-tight">
              @lang('blog.label')
            </h3>

            <p class="mt-0.5 text-sm text-primary-content/75">
              Artikel dan insight dunia lari
            </p>

          </div>

        </div>

      </div>

      <div class="divide-y divide-base-300/70">

        @foreach ($blogs as $blog)

          <a
            wire:navigate
            href="{{ route('blog.view', $blog->slug) }}"
            title="{{ $blog->title }}"
            class="group block px-5 py-4 transition-colors hover:bg-base-200/40"
          >

            <div class="flex items-start justify-between gap-4">

              <div class="min-w-0 flex-1">

                <h4 class="line-clamp-2 font-medium leading-snug group-hover:text-primary transition">

                  {{ $blog->title }}

                </h4>

                <div class="mt-2 text-sm text-base-content/50">

                  @datetimeDiff($blog->published_at)

                </div>

              </div>

              <div class="shrink-0 pt-1">

                <x-icons.line.arrow-right-s class="w-5 h-5 text-base-content/25 group-hover:text-primary transition" />

              </div>

            </div>

          </a>

        @endforeach

      </div>

      <div class="border-t border-base-300/70 px-5 py-4">

        <a
          wire:navigate
          href="{{ route('blog.index') }}"
          class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-primary-focus transition"
        >

          <span>
            @lang('blog.btn.view_all')
          </span>

          <x-icons.line.arrow-right class="w-4 h-4" />

        </a>

      </div>

    </div>

  @endif

</div>
