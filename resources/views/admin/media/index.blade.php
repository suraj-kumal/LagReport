@extends('admin.layouts.app')
@section('page_title', 'Media')

@push('styles')
<style>
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1px;
        background: var(--n200);
        border-radius: var(--radius);
        overflow: hidden;
    }

    @media (max-width: 767px) {
        .media-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }

    .media-item {
        background: #fff;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: background 0.15s;
    }

    .media-item:hover { background: var(--n50); }

    .media-thumb {
        width: 100%;
        aspect-ratio: 4/3;
        object-fit: cover;
        display: block;
        background: var(--n100);
    }

    .media-info {
        padding: 0.75rem;
        border-top: 1px solid var(--n100);
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .media-filename {
        font-size: 0.75rem;
        color: var(--n600);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .media-actions {
        display: flex;
        gap: 0.4rem;
    }

    .media-actions .btn {
        flex: 1;
        justify-content: center;
        font-size: 0.72rem;
        padding: 0.3rem 0.5rem;
    }

    .upload-zone {
        border: 2px dashed var(--n200);
        border-radius: var(--radius);
        padding: 2rem;
        text-align: center;
        background: #fff;
        transition: border-color 0.15s, background 0.15s;
    }

    .upload-zone:hover {
        border-color: var(--teal);
        background: var(--teal-light);
    }

    .upload-zone input[type="file"] {
        display: none;
    }

    .upload-label {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        gap: 0.6rem;
        cursor: pointer;
    }

    .upload-icon {
        width: 40px;
        height: 40px;
        background: var(--n100);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .upload-icon svg {
        width: 20px;
        height: 20px;
        stroke: var(--n400);
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }

    .upload-text {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--n800);
    }

    .upload-hint {
        font-size: 0.78rem;
        color: var(--n400);
    }

    .upload-filename {
        font-size: 0.82rem;
        color: var(--teal);
        font-weight: 500;
        display: none;
    }

    .empty-media {
        padding: 3rem;
        text-align: center;
        color: var(--n400);
        font-size: 0.875rem;
        background: #fff;
        border-radius: var(--radius);
    }

    @media (max-width: 767px) {
        .upload-zone {
            padding: 1.5rem;
        }

        .empty-media {
            padding: 1.5rem;
        }

        .media-info {
            padding: 0.5rem;
        }

        .media-filename {
            font-size: 0.7rem;
        }

        .media-actions .btn {
            font-size: 0.65rem;
            padding: 0.2rem 0.4rem;
        }
    }
</style>
@endpush

@section('content')

<div style="display: flex; flex-direction: column; gap: 1.5rem;">

    {{-- Upload card --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Upload image</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.media.store') }}" method="POST"
                  enctype="multipart/form-data" id="upload-form">
                @csrf

                <div class="upload-zone" id="upload-zone">
                    <input type="file" name="image" id="image-input" accept="image/*" required>
                    <label class="upload-label" for="image-input">
                        <div class="upload-icon">
                            <svg viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0018 9h-1.26A8 8 0 103 16.3"/></svg>
                        </div>
                        <span class="upload-text">Click to select an image</span>
                        <span class="upload-hint">PNG, JPG, GIF, WebP</span>
                        <span class="upload-filename" id="upload-filename"></span>
                    </label>
                </div>

                @error('image')
                    <p class="form-error" style="margin-top: 0.5rem;">{{ $message }}</p>
                @enderror

                <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" id="upload-btn" disabled>
                        <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:currentColor;stroke-width:2;fill:none;stroke-linecap:round;stroke-linejoin:round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/></svg>
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Media grid --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Library</span>
            <span style="font-size: 0.8rem; color: var(--n400);">{{ $media->count() }} {{ Str::plural('file', $media->count()) }}</span>
        </div>

        @if($media->isEmpty())
            <div class="empty-media">No images uploaded yet.</div>
        @else
            <div style="padding: 1px;">
                <div class="media-grid">
                    @foreach($media as $item)
                        <div class="media-item">
                            <img class="media-thumb" src="{{ $item->url }}" alt="{{ $item->filename }}">
                            <div class="media-info">
                                <span class="media-filename" title="{{ $item->filename }}">{{ $item->filename }}</span>
                                <div class="media-actions">
                                    <button type="button"
                                            onclick="copyUrl('{{ asset($item->url) }}', this)"
                                            class="btn btn-ghost btn-sm">
                                        Copy URL
                                    </button>
                                    <form action="{{ route('admin.media.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Delete this image?')" style="margin:0; flex:1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="width:100%;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
    const input = document.getElementById('image-input');
    const filename = document.getElementById('upload-filename');
    const uploadBtn = document.getElementById('upload-btn');

    input.addEventListener('change', () => {
        if (input.files.length) {
            filename.textContent = input.files[0].name;
            filename.style.display = 'block';
            uploadBtn.disabled = false;
        }
    });

    function copyUrl(url, btn) {
        navigator.clipboard.writeText(url).then(() => {
            const original = btn.innerText;
            btn.innerText = 'Copied!';
            btn.style.color = 'var(--teal)';
            setTimeout(() => {
                btn.innerText = original;
                btn.style.color = '';
            }, 2000);
        });
    }
</script>
@endpush
