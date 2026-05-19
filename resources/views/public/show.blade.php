@extends('public.layouts.app')

@section('seo_title', $news->seo_title ?? $news->headline)
@section('seo_description', $news->seo_description ?? $news->lead)
@section('seo_keywords', $news->seo_keywords ?? '')
@section('og_image', $news->cover_image ?? '')

@push('styles')
<style>
    /* ── ARTICLE BODY CONTENT ── */
    .article-body { line-height: 1.8; color: #0A0A0A; }

    .article-body p {
        margin-bottom: 1.4rem;
        font-size: 1.0625rem;
    }

    .article-body h2 {
        font-size: 1.4rem;
        font-weight: 700;
        letter-spacing: -0.03em;
        text-transform: uppercase;
        color: #0A0A0A;
        margin: 2.5rem 0 1rem;
        padding-top: 1.5rem;
        border-top: 1px solid #D4D4D4;
    }

    .article-body h3 {
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: #0A0A0A;
        margin: 2rem 0 0.75rem;
    }

    .article-body a {
        color: #0057FF;
        text-decoration: underline;
        text-decoration-thickness: 1px;
        text-underline-offset: 3px;
    }

    .article-body a:hover { color: #0040CC; }

    .article-body ul,
    .article-body ol {
        margin-bottom: 1.4rem;
        padding-left: 1.5rem;
    }

    .article-body li { margin-bottom: 0.5rem; font-size: 1.0625rem; }

    .article-body blockquote {
        border-left: 3px solid #0057FF;
        margin: 2rem 0;
        padding: 1rem 1.5rem;
        background: #F2F2F2;
    }

    .article-body blockquote p {
        font-size: 1.1rem;
        font-style: italic;
        color: #0A0A0A;
        margin: 0;
    }

    .article-body img {
        width: 100%;
        margin: 2rem auto;
    }

    .article-body code {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.875rem;
        background: #F2F2F2;
        padding: 2px 5px;
        color: #0A0A0A;
    }

    .article-body pre {
        background: #0A0A0A;
        color: #F2F2F2;
        padding: 1.5rem;
        overflow-x: auto;
        margin: 1.5rem 0;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.875rem;
        line-height: 1.7;
    }

    .article-body pre code {
        background: transparent;
        color: inherit;
        padding: 0;
    }
</style>
@endpush

@section('content')

{{-- ── TWO-COLUMN SWISS LAYOUT ── --}}
<div class="max-w-screen-lg mx-auto">

    {{-- Back link --}}
    <!--<div class="mb-8 flex items-center gap-3">
        <span class="block w-2 h-2 bg-swiss-blue flex-shrink-0"></span>
        <a href="{{ route('news.index') }}"
           class="underline font-mono text-2xs tracking-swiss uppercase text-swiss-gray hover:text-swiss-blue transition-colors duration-150">
             Back to Home
        </a>
    </div>-->

    {{-- ── FULL-WIDTH HEADLINE BLOCK ── --}}
    <div class="border border-swiss-black mb-0">
        {{-- Red rule --}}
        <span class="block w-full h-1 bg-swiss-blue"></span>

        <div class="p-8 md:p-12">
            {{-- Category + date row --}}
            <div class="flex items-center gap-4 mb-6">
                <span class="font-mono text-2xs tracking-swiss uppercase text-white bg-swiss-blue px-3 py-1">Tech Post</span>
                <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray">{{ $news->created_at->format('d M Y') }}</span>
                @if($news->byline)
                    <span class="w-px h-3 bg-swiss-gray-light"></span>
                    <span class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray">By {{ $news->byline }}</span>
                @endif
            </div>

            {{-- Headline --}}
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight-swiss leading-none text-swiss-black uppercase mb-6">
                {{ $news->headline }}
            </h1>

            @if($news->lead)
                <p class="text-lg text-swiss-gray leading-relaxed max-w-2xl font-sans border-l-4 border-swiss-blue pl-5">
                    {{ $news->lead }}
                </p>
            @endif
        </div>
    </div>

    {{-- ── COVER IMAGE ── --}}
    @if($news->cover_image)
        <div class="border-l border-r border-b border-swiss-black">
            <img src="{{ $news->cover_image }}"
                 alt="{{ $news->headline }}"
                 class="w-full max-h-[520px] object-cover">
        </div>
    @endif

    {{-- ── BODY: sidebar + content ── --}}
    <div class="grid grid-cols-1 md:grid-cols-12 border-l border-r border-b border-swiss-black">

        {{-- Sidebar --}}
        <aside class="md:col-span-3 border-b md:border-b-0 md:border-r border-swiss-gray-light p-6 flex flex-col gap-8">

            {{-- Post info block --}}
            <div>
                <span class="rule rule-light mb-4" style="height:1px;"></span>
                <dl class="flex flex-col gap-3">
                    <div>
                        <dt class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray mb-1">Published</dt>
                        <dd class="font-mono text-xs text-swiss-black">{{ $news->created_at->format('d M Y') }}</dd>
                    </div>
                    @if($news->byline)
                    <div>
                        <dt class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray mb-1">Author</dt>
                        <dd class="font-mono text-xs text-swiss-black">{{ $news->byline }}</dd>
                    </div>
                    @endif
                    <!--<div>
                        <dt class="font-mono text-2xs tracking-swiss uppercase text-swiss-gray mb-1">Category</dt>
                        <dd class="font-mono text-xs text-swiss-black">Technology</dd>
                    </div>-->
                </dl>
                <span class="rule rule-light mt-4" style="height:1px;"></span>
            </div>

            {{-- Issue label --}}
            <div class="border border-swiss-black p-4">
                <span class="block font-mono text-2xs tracking-swiss uppercase text-swiss-gray mb-2">Tech Journal</span>
                <span class="block font-bold text-sm uppercase tracking-tight-swiss text-swiss-black">{{ config('app.name') }}</span>
            </div>

        </aside>

        {{-- Main article body --}}
        <div class="md:col-span-9 p-8 md:p-12">
            <div class="article-body">
                {!! $news->body !!}
            </div>

            @if($news->conclusion)
                {{-- Takeaway block --}}
                <div class="mt-10 border border-swiss-black">
                    <div class="bg-swiss-black px-5 py-2 flex items-center gap-3">
                        <span class="block w-2 h-2 bg-swiss-blue flex-shrink-0"></span>
                        <span class="font-mono text-2xs tracking-swiss uppercase text-white">Key Takeaway</span>
                    </div>
                    <div class="p-6 text-swiss-black text-base leading-relaxed border-l-4 border-swiss-blue">
                        {{ $news->conclusion }}
                    </div>
                </div>
            @endif
        </div>

    </div>

    {{-- ── FOOTER NAV ── --}}
    <div class="mt-10 flex items-center gap-4">
        <span class="block w-2 h-2 bg-swiss-blue flex-shrink-0"></span>
        <a href="{{ route('news.index') }}"
           class="font-mono text-2xs tracking-swiss uppercase text-swiss-black border border-swiss-black px-4 py-2 hover:bg-swiss-blue hover:border-swiss-blue hover:text-white transition-all duration-150">
            Back to Home
        </a>
    </div>

</div>

@endsection
