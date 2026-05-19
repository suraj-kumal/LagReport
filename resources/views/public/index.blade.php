@extends('public.layouts.app')

@section('seo_title', config('app.name') . ' — Tech Blog')
@section('seo_description', 'Latest tech posts')

@push('styles')
<style>
    /* ── FEATURED GRID ── */
    .featured-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1px;
        background: #0A0A0A;
        border: 1px solid #0A0A0A;
    }

    @media (max-width: 768px) {
        .featured-grid { grid-template-columns: 1fr; }
    }

    .featured-grid .card-span-full {
        grid-column: 1 / -1;
    }

    /* ── LATEST LIST ── */
    .latest-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1px;
        background: #D4D4D4;
        border: 1px solid #D4D4D4;
    }

    @media (max-width: 900px) {
        .latest-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 600px) {
        .latest-grid { grid-template-columns: 1fr; }
    }

    /* Image zoom on hover */
    .img-zoom { overflow: hidden; }
    .img-zoom img { transition: transform 0.4s ease; }
    .img-zoom:hover img { transform: scale(1.04); }
</style>
@endpush

@section('content')

{{-- ── SECTION LABEL ── --}}
@if($headlineNews->isNotEmpty())

    <div class="flex items-center gap-4 mb-4">
        <span class="block w-3 h-3 bg-swiss-blue flex-shrink-0"></span>
        <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray">Top Posts</span>
        <span class="rule rule-light flex-1" style="height:1px;"></span>
        <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray">{{ $headlineNews->count() }} posts</span>
    </div>

    {{-- ── FEATURED GRID ── --}}
    <div class="featured-grid mb-12">
        @foreach($headlineNews as $item)
            @php $isFeatured = $loop->first; @endphp

            <article class="bg-white {{ $isFeatured ? 'card-span-full' : '' }} group">

                @if($item->cover_image)
                    <div class="img-zoom {{ $isFeatured ? 'h-80 md:h-96' : 'h-48' }}">
                        <img src="{{ $item->cover_image }}"
                             alt="{{ $item->headline }}"
                             class="w-full h-full object-cover"
                             loading="{{ $isFeatured ? 'eager' : 'lazy' }}">
                    </div>
                @endif

                <div class="{{ $isFeatured ? 'p-8 md:p-10' : 'p-5' }} flex flex-col gap-3">

                    {{-- Meta row --}}
                    <div class="flex items-center gap-3">
                        <span class="block w-2 h-2 bg-swiss-blue flex-shrink-0"></span>
                        @if($item->byline)
                            <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray">{{ $item->byline }}</span>
                            <span class="w-px h-3 bg-swiss-gray-light"></span>
                        @endif
                        <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray">{{ $item->created_at->format('d M Y') }}</span>
                    </div>

                    {{-- Headline --}}
                    <h2 class="{{ $isFeatured ? 'text-3xl md:text-4xl' : 'text-lg' }} font-bold tracking-tight-swiss leading-tight text-swiss-black">
                        <a href="{{ route('news.show', $item->slug) }}"
                           class="swiss-link">{{ $item->headline }}</a>
                    </h2>

                    @if($item->lead && $isFeatured)
                        <p class="text-swiss-gray text-base leading-relaxed max-w-2xl">{{ $item->lead }}</p>
                    @endif

                    {{-- Read link --}}
                    <div class="mt-auto pt-2">
                        <a href="{{ route('news.show', $item->slug) }}"
                           class="inline-flex items-center gap-2 font-mono text-2xs tracking-swiss uppercase text-swiss-black border border-swiss-black px-4 py-2 hover:bg-swiss-blue hover:border-swiss-blue hover:text-white transition-all duration-150">
                            Read Post
                            <!--<span aria-hidden="true">→</span>-->
                        </a>
                    </div>

                </div>
            </article>
        @endforeach
    </div>

@endif


{{-- ── LATEST SECTION ── --}}
<section>

    <div class="flex items-center gap-4 mb-4">
        <span class="block w-3 h-3 bg-swiss-black flex-shrink-0"></span>
        <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray">Latest Posts</span>
        <span class="rule rule-light flex-1" style="height:1px;"></span>
    </div>

    @forelse($latestNews as $item)
        @if($loop->first)
            <div class="latest-grid">
        @endif

        <article class="bg-white p-5 flex flex-col gap-3 group">

            @if($item->cover_image)
                <div class="img-zoom h-36">
                    <img src="{{ $item->cover_image }}"
                         alt="{{ $item->headline }}"
                         class="w-full h-full object-cover"
                         loading="lazy">
                </div>
            @endif

            <div class="flex items-center gap-2">
                <span class="block w-1.5 h-1.5 bg-swiss-blue flex-shrink-0"></span>
                <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray">{{ $item->created_at->format('d M Y') }}</span>
            </div>

            <h3 class="text-base font-bold tracking-tight-swiss leading-snug text-swiss-black">
                <a href="{{ route('news.show', $item->slug) }}" class="swiss-link">{{ $item->headline }}</a>
            </h3>

            @if($item->byline)
                <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray mt-auto">{{ $item->byline }}</span>
            @endif

        </article>

        @if($loop->last)
            </div>
        @endif

    @empty
        <div class="border border-swiss-gray-light p-12 text-center">
            <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray">No posts available yet</span>
        </div>
    @endforelse

    {{-- ── PAGINATION ── --}}
    @if($latestNews->hasPages())
        <div class="mt-10 flex justify-center">
            <div class="flex items-center gap-px border border-swiss-black">
                {{-- Previous --}}
                @if($latestNews->onFirstPage())
                    <span class="font-mono text-2xs tracking-swiss uppercase px-4 py-2 text-swiss-gray-light border-r border-swiss-gray-light cursor-not-allowed select-none">← Prev</span>
                @else
                    <a href="{{ $latestNews->previousPageUrl() }}"
                       class="font-mono text-2xs tracking-swiss uppercase px-4 py-2 text-swiss-black border-r border-swiss-gray-light hover:bg-swiss-blue hover:text-white hover:border-swiss-blue transition-all duration-150">← Prev</a>
                @endif

                {{-- Page numbers --}}
                @foreach($latestNews->getUrlRange(1, $latestNews->lastPage()) as $page => $url)
                    @if($page == $latestNews->currentPage())
                        <span class="font-mono text-2xs tracking-swiss uppercase px-4 py-2 bg-swiss-black text-white border-r border-swiss-black select-none">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="font-mono text-2xs tracking-swiss uppercase px-4 py-2 text-swiss-black border-r border-swiss-gray-light hover:bg-swiss-gray-pale transition-all duration-150">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($latestNews->hasMorePages())
                    <a href="{{ $latestNews->nextPageUrl() }}"
                       class="font-mono text-2xs tracking-swiss uppercase px-4 py-2 text-swiss-black hover:bg-swiss-blue hover:text-white transition-all duration-150">Next →</a>
                @else
                    <span class="font-mono text-2xs tracking-swiss uppercase px-4 py-2 text-swiss-gray-light cursor-not-allowed select-none">Next →</span>
                @endif
            </div>
        </div>
    @endif

</section>

@endsection
