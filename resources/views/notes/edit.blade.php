@extends('layouts.app')

@section('content')
<style>
    :root{--primary:#4F46E5;--primary-hover:#4338CA;--primary-light:#EEF2FF;--danger:#EF4444;--gray-50:#F9FAFB;--gray-100:#F3F4F6;--gray-200:#E5E7EB;--gray-300:#D1D5DB;--gray-400:#9CA3AF;--gray-500:#6B7280;--gray-600:#4B5563;--gray-700:#374151;--gray-800:#1F2937;--gray-900:#111827;--topbar-h:64px;--radius:12px;--radius-sm:8px;}
    .editor-wrapper{display:flex;min-height:100vh;background:var(--gray-50);}
    .topbar{position:fixed;top:0;left:0;right:0;height:var(--topbar-h);background:#fff;border-bottom:1px solid var(--gray-200);display:flex;align-items:center;justify-content:space-between;padding:0 24px;z-index:200;}
    .topbar-logo{display:flex;align-items:center;gap:10px;text-decoration:none;}
    .topbar-logo-icon{width:34px;height:34px;background:var(--primary);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:17px;}
    .topbar-logo span{font-size:17px;font-weight:700;color:var(--gray-900);}
    .topbar-actions{display:flex;align-items:center;gap:10px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:var(--radius-sm);font-size:14px;font-weight:600;border:none;cursor:pointer;transition:all .2s ease;text-decoration:none;font-family:inherit;}
    .btn-primary{background:var(--primary);color:#fff;}
    .btn-primary:hover{background:var(--primary-hover);transform:translateY(-1px);box-shadow:0 4px 12px rgba(79,70,229,.35);}
    .btn-ghost{background:#fff;color:var(--gray-600);border:1.5px solid var(--gray-200);}
    .btn-ghost:hover{background:var(--gray-50);}
    .editor-container{margin-top:var(--topbar-h);flex:1;display:flex;justify-content:center;padding:48px 24px;}
    .editor-card{background:#fff;border:1px solid var(--gray-200);border-radius:16px;width:100%;max-width:720px;box-shadow:0 4px 24px rgba(0,0,0,.06);overflow:hidden;}
    .editor-meta{padding:16px 40px;background:var(--gray-50);border-bottom:1px solid var(--gray-200);display:flex;align-items:center;gap:12px;font-size:13px;color:var(--gray-500);}
    .editor-card-top{padding:32px 40px 0;}
    .title-input{width:100%;border:none;outline:none;font-size:32px;font-weight:800;color:var(--gray-900);font-family:'Inter',sans-serif;padding:0;background:transparent;}
    .title-input::placeholder{color:var(--gray-300);}
    .title-divider{height:2px;background:var(--gray-200);margin:20px 0;border-radius:2px;transition:background .2s;}
    .editor-card:focus-within .title-divider{background:var(--primary);}
    .content-area{width:100%;border:none;outline:none;font-size:16px;color:var(--gray-700);font-family:'Inter',sans-serif;line-height:1.75;resize:none;min-height:360px;padding:0 40px 32px;background:transparent;}
    .content-area::placeholder{color:var(--gray-300);}
    .options-bar{padding:20px 40px;border-top:1px solid var(--gray-100);background:var(--gray-50);display:flex;align-items:center;gap:20px;flex-wrap:wrap;}
    .options-label{font-size:13px;font-weight:600;color:var(--gray-500);}
    .color-picker{display:flex;gap:8px;align-items:center;}
    .color-swatch{width:22px;height:22px;border-radius:50%;cursor:pointer;border:2.5px solid transparent;transition:all .15s;position:relative;}
    .color-swatch:hover{transform:scale(1.15);}
    .color-swatch.selected{border-color:var(--gray-800);transform:scale(1.15);}
    .color-swatch.selected::after{content:'✓';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:#fff;font-size:10px;font-weight:700;}
    .char-count{margin-left:auto;font-size:12px;color:var(--gray-400);}
    .editor-footer{padding:20px 40px;border-top:1px solid var(--gray-200);display:flex;align-items:center;justify-content:flex-end;gap:12px;}
    @media(max-width:640px){
        .editor-container{padding:24px 12px;}
        .editor-meta,.editor-card-top{padding-left:20px;padding-right:20px;}
        .content-area{padding-left:20px;padding-right:20px;}
        .options-bar,.editor-footer{padding-left:20px;padding-right:20px;}
        .title-input{font-size:24px;}
        .topbar{padding:0 16px;}
    }
</style>

<div class="editor-wrapper">
    <header class="topbar">
        <a href="{{ route('notes.index') }}" class="topbar-logo">
            <div class="topbar-logo-icon">📝</div>
            <span>MyNotepad</span>
        </a>
        <div class="topbar-actions">
            <a href="{{ route('notes.index') }}" class="btn btn-ghost">← Back</a>
            <button type="submit" form="editForm" class="btn btn-primary">💾 Save Changes</button>
        </div>
    </header>

    <div class="editor-container">
        <div class="editor-card">
            <div class="editor-meta">
                <span>✏️ Editing note</span>
                <span style="color:var(--gray-300);">·</span>
                <span>Created {{ $note->created_at->format('M j, Y') }}</span>
                <span style="color:var(--gray-300);">·</span>
                <span>Updated {{ $note->updated_at->diffForHumans() }}</span>
            </div>

            <form id="editForm" method="POST" action="{{ route('notes.update', $note) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="color" id="selectedColor" value="{{ old('color', $note->color) }}">

                <div class="editor-card-top">
                    <input
                        type="text"
                        name="title"
                        id="titleInput"
                        class="title-input"
                        placeholder="Untitled note"
                        value="{{ old('title', $note->title) }}"
                        required
                        autofocus
                    >
                    @error('title')<p style="color:var(--danger);font-size:13px;margin-top:4px;">{{ $message }}</p>@enderror
                    <div class="title-divider"></div>
                </div>

                <textarea
                    name="content"
                    class="content-area"
                    id="contentArea"
                    placeholder="Start writing your note..."
                >{{ old('content', $note->content) }}</textarea>

                <div class="options-bar">
                    <span class="options-label">🎨 Color:</span>
                    <div class="color-picker">
                        <div class="color-swatch {{ old('color',$note->color)==='default' ? 'selected' : '' }}" data-color="default" style="background:#E5E7EB;" title="Default" onclick="selectColor(this)"></div>
                        <div class="color-swatch {{ old('color',$note->color)==='blue' ? 'selected' : '' }}"    data-color="blue"    style="background:#3B82F6;" title="Blue"    onclick="selectColor(this)"></div>
                        <div class="color-swatch {{ old('color',$note->color)==='green' ? 'selected' : '' }}"   data-color="green"   style="background:#10B981;" title="Green"   onclick="selectColor(this)"></div>
                        <div class="color-swatch {{ old('color',$note->color)==='yellow' ? 'selected' : '' }}"  data-color="yellow"  style="background:#F59E0B;" title="Yellow"  onclick="selectColor(this)"></div>
                        <div class="color-swatch {{ old('color',$note->color)==='red' ? 'selected' : '' }}"     data-color="red"     style="background:#EF4444;" title="Red"     onclick="selectColor(this)"></div>
                        <div class="color-swatch {{ old('color',$note->color)==='purple' ? 'selected' : '' }}"  data-color="purple"  style="background:#8B5CF6;" title="Purple"  onclick="selectColor(this)"></div>
                    </div>
                    <span class="char-count" id="charCount">0 characters</span>
                </div>

                <div class="editor-footer">
                    <button type="button" class="btn btn-ghost" style="color:#EF4444;border-color:#EF4444;" onclick="confirmDelete({{ $note->id }},'{{ addslashes($note->title) }}','{{ route('notes.destroy',$note) }}')">🗑️ Delete</button>
                    <a href="{{ route('notes.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">💾 Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function selectColor(el) {
    document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selectedColor').value = el.dataset.color;
}
const contentArea = document.getElementById('contentArea');
const charCount = document.getElementById('charCount');
function updateCount() {
    const len = contentArea.value.length;
    charCount.textContent = len.toLocaleString() + ' character' + (len !== 1 ? 's' : '');
}
contentArea.addEventListener('input', function() {
    updateCount();
    this.style.height = 'auto';
    this.style.height = Math.max(360, this.scrollHeight) + 'px';
});
// Auto-resize on load
window.addEventListener('DOMContentLoaded', () => {
    contentArea.style.height = 'auto';
    contentArea.style.height = Math.max(360, contentArea.scrollHeight) + 'px';
    updateCount();
});
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('editForm').submit();
    }
});
</script>
@endsection
