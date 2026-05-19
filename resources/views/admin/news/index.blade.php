@extends('admin.layouts.app')
@section('page_title', 'News Articles')

@push('styles')
<style>
    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    @media (max-width: 767px) {
        .table-wrapper {
            margin: 0 -1.5rem;
            border-left: 1px solid var(--n200);
            border-right: 1px solid var(--n200);
        }
        
        .data-table {
            min-width: 600px;
        }
        
        .data-table td {
            padding: 0.75rem;
            font-size: 0.8rem;
        }
        
        .data-table th {
            padding: 0.6rem 0.75rem;
            font-size: 0.65rem;
        }
    }
</style>
@endpush

@section('content')

<div class="card">
    <div class="card-header">
        <span class="card-title">All articles</span>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New article
        </a>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
        <thead>
            <tr>
                <th>Headline</th>
                <th>Published</th>
                <th>Top story</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($news as $item)
            <tr>
                <td style="max-width: 360px;">
                    <span style="font-weight: 500; color: var(--n900); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $item->headline }}
                    </span>
                </td>
                <td>
                    @if($item->publish)
                        <span class="badge badge-success">Published</span>
                    @else
                        <span class="badge badge-neutral">Draft</span>
                    @endif
                </td>
                <td>
                    @if($item->headline_news)
                        <span class="badge badge-teal">Top story</span>
                    @else
                        <span style="color: var(--n300); font-size: 0.82rem;">—</span>
                    @endif
                </td>
                <td style="color: var(--n400); font-size: 0.82rem; white-space: nowrap;">
                    {{ $item->created_at->format('d M Y') }}
                </td>
                <td>
                    <div class="table-actions">
                        <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-ghost btn-sm">Edit</a>
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST"
                              onsubmit="return confirm('Delete this article?')" style="margin:0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--n400); padding: 3rem 1rem;">
                        No articles yet. <a href="{{ route('admin.news.create') }}" style="color: var(--teal);">Create the first one →</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

@endsection
