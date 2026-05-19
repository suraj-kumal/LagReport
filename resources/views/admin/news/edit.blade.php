@extends('admin.layouts.app')
@section('page_title', 'Edit Article')

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar {
        border-radius: 6px 6px 0 0;
        border-color: var(--n200) !important;
        font-family: var(--font) !important;
    }
    .ql-container {
        border-radius: 0 0 6px 6px;
        border-color: var(--n200) !important;
        font-family: var(--font) !important;
        font-size: 0.9rem;
        min-height: 320px;
    }
    .ql-editor { min-height: 320px; line-height: 1.7; }
    .ql-toolbar.ql-snow .ql-formats { margin-right: 10px; }

    @media (max-width: 767px) {
        body {
            font-size: 14px;
        }
    }

    /* Image URL modal */
    .img-modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 200;
        align-items: center;
        justify-content: center;
    }
    .img-modal-backdrop.open { display: flex; }
    .img-modal {
        background: #fff;
        border-radius: 10px;
        padding: 1.5rem;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    }
    .img-modal-title {
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--n800);
        margin-bottom: 1rem;
    }
    .img-modal-hint {
        font-size: 0.78rem;
        color: var(--n400);
        margin-top: 0.4rem;
    }
    .img-modal-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
        justify-content: flex-end;
    }

    @media (max-width: 767px) {
        .ql-container {
            min-height: 240px;
        }
        .ql-editor {
            min-height: 240px;
        }

        .img-modal {
            padding: 1.25rem;
            max-width: calc(100% - 2rem);
        }

        .img-modal-actions {
            flex-wrap: wrap;
        }

        .img-modal-actions button {
            flex: 1;
            min-width: 80px;
        }

        .news-form-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }
        .news-form-grid > div:last-child {
            position: static !important;
            top: auto !important;
            gap: 0.75rem !important;
        }

        .delete-form-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }
        .delete-form-grid > div:first-child {
            display: none !important;
        }
        .delete-form-grid > div:last-child {
            gap: 0.75rem !important;
        }

        .btn {
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@section('content')

@if($errors->any())
    <div class="error-list">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.news.update', $news) }}" method="POST" id="news-form">
@csrf
@method('PUT')

<div style="display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; align-items: start;" class="news-form-grid">

    {{-- ── Left column ── --}}
    <div style="display: flex; flex-direction: column; gap: 1.25rem;">

        <div class="card">
            <div class="card-header"><span class="card-title">Content</span></div>
            <div class="card-body">

                <div class="form-group">
                    <label class="form-label" for="headline">Headline <span class="required">*</span></label>
                    <input class="form-input" type="text" id="headline" name="headline"
                           value="{{ old('headline', $news->headline) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="byline">Byline</label>
                    <input class="form-input" type="text" id="byline" name="byline"
                           value="{{ old('byline', $news->byline) }}" placeholder="e.g. Dr. Anita Sharma">
                </div>

                <div class="form-group">
                    <label class="form-label" for="cover_image">Cover image URL</label>
                    <input class="form-input" type="text" id="cover_image" name="cover_image"
                           value="{{ old('cover_image', $news->cover_image) }}"
                           placeholder="Paste URL from Media Manager">
                    @if($news->cover_image)
                        <div style="margin-top: 0.6rem; border-radius: 6px; overflow: hidden; width: 120px; height: 80px; background: var(--n100);">
                            <img src="{{ $news->cover_image }}" alt=""
                                 style="width:100%; height:100%; object-fit:cover;">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label" for="lead">Lead paragraph</label>
                    <textarea class="form-textarea" id="lead" name="lead"
                              rows="3">{{ old('lead', $news->lead) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Body <span class="required">*</span></label>
                    <div id="quill-editor"></div>
                    <textarea id="body" name="body" style="display:none;">{{ old('body', $news->body) }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="conclusion">Conclusion / Takeaway</label>
                    <textarea class="form-textarea" id="conclusion" name="conclusion"
                              rows="3">{{ old('conclusion', $news->conclusion) }}</textarea>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">SEO</span></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="seo_title">SEO title</label>
                    <input class="form-input" type="text" id="seo_title" name="seo_title"
                           value="{{ old('seo_title', $news->seo_title) }}">
                </div>
                <div class="form-group">
                    <label class="form-label" for="seo_description">SEO description</label>
                    <input class="form-input" type="text" id="seo_description" name="seo_description"
                           value="{{ old('seo_description', $news->seo_description) }}">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="seo_keywords">Keywords</label>
                    <input class="form-input" type="text" id="seo_keywords" name="seo_keywords"
                           value="{{ old('seo_keywords', $news->seo_keywords) }}">
                </div>
            </div>
        </div>

    </div>

    {{-- ── Right column ── --}}
    <div style="display: flex; flex-direction: column; gap: 1.25rem; position: sticky; top: calc(56px + 1.5rem);">

        <div class="card">
            <div class="card-header"><span class="card-title">Publish</span></div>
            <div class="card-body" style="display: flex; flex-direction: column; gap: 0.85rem;">
                <label class="form-checkbox">
                    <input type="checkbox" name="publish" value="1"
                           {{ old('publish', $news->publish) ? 'checked' : '' }}>
                    <span>Publish article</span>
                </label>
                <label class="form-checkbox">
                    <input type="checkbox" name="headline_news" value="1"
                           {{ old('headline_news', $news->headline_news) ? 'checked' : '' }}>
                    <span>Feature as top story</span>
                </label>
            </div>
            <div style="padding: 0 1.5rem 1.5rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    Save changes
                </button>
            </div>
        </div>

    </div>

</div>

</form>

{{-- Delete form (outside main form to avoid nesting conflict) --}}
<div style="display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; margin-top: 1rem;" class="delete-form-grid">
    <div></div>
    <div style="display: flex; flex-direction: column; gap: 1.25rem;">

        <div class="card" style="border-color: #f0b8b3;">
            <div class="card-body" style="padding: 1rem 1.25rem;">
                <p style="font-size: 0.8rem; color: var(--n400); margin-bottom: 0.75rem;">Danger zone</p>
                <form action="{{ route('admin.news.destroy', $news) }}" method="POST"
                      onsubmit="return confirm('Permanently delete this article?')" style="margin:0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            style="width: 100%; justify-content: center;">
                        Delete article
                    </button>
                </form>
            </div>
        </div>

        <a href="{{ route('admin.news.index') }}" class="btn btn-ghost" style="justify-content: center;">
            ← Back to articles
        </a>

    </div>
</div>

{{-- Image URL modal --}}
<div class="img-modal-backdrop" id="img-modal-backdrop">
    <div class="img-modal">
        <p class="img-modal-title">Insert image</p>
        <label class="form-label" for="img-url-input">Image URL</label>
        <input class="form-input" type="url" id="img-url-input"
               placeholder="https://your-domain.com/storage/image.jpg">
        <p class="img-modal-hint">Copy a URL from the Media Manager and paste it here.</p>
        <div class="img-modal-actions">
            <button type="button" class="btn btn-ghost" id="img-modal-cancel">Cancel</button>
            <button type="button" class="btn btn-primary" id="img-modal-insert">Insert image</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    let savedRange = null;

    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: {
                container: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'image', 'blockquote'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['clean']
                ],
                handlers: {
                    image: function () {
                        savedRange = quill.getSelection();
                        document.getElementById('img-url-input').value = '';
                        document.getElementById('img-modal-backdrop').classList.add('open');
                        setTimeout(() => document.getElementById('img-url-input').focus(), 50);
                    }
                }
            }
        }
    });

    // Load existing body content into Quill
    const existing = document.getElementById('body').value;
    if (existing) quill.root.innerHTML = existing;

    // Insert image from modal
    document.getElementById('img-modal-insert').addEventListener('click', () => {
        const url = document.getElementById('img-url-input').value.trim();
        if (url) {
            const index = savedRange ? savedRange.index : quill.getLength();
            quill.insertEmbed(index, 'image', url);
            quill.setSelection(index + 1);
        }
        document.getElementById('img-modal-backdrop').classList.remove('open');
    });

    document.getElementById('img-modal-cancel').addEventListener('click', () => {
        document.getElementById('img-modal-backdrop').classList.remove('open');
    });

    // Close on backdrop click
    document.getElementById('img-modal-backdrop').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });

    // Keyboard shortcuts in modal
    document.getElementById('img-url-input').addEventListener('keydown', function(e) {
        if (e.key === 'Enter')  document.getElementById('img-modal-insert').click();
        if (e.key === 'Escape') document.getElementById('img-modal-cancel').click();
    });

    // Sync Quill HTML → hidden textarea before form submit
    document.getElementById('news-form').addEventListener('submit', function() {
        document.getElementById('body').value = quill.root.innerHTML;
    });
</script>
@endpush
