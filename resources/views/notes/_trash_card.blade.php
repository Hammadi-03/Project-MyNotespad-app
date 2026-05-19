@php
$colorMap = [
    'default' => '',
    'blue'    => 'color-blue',
    'green'   => 'color-green',
    'yellow'  => 'color-yellow',
    'red'     => 'color-red',
    'purple'  => 'color-purple',
];
$colorClass = $colorMap[$note->color] ?? '';
@endphp
<div class="note-card {{ $colorClass }}" id="note-card-{{ $note->id }}">
    <!-- Card Image Header -->
    @if($note->image)
    <div class="note-card-image-wrap" style="margin: -16px -16px 12px; overflow: hidden; border-radius: 8px 8px 0 0; max-height: 240px; border-bottom: 1px solid var(--gray-100);">
        <img src="{{ asset('storage/' . $note->image) }}" style="width: 100%; height: auto; display: block; object-fit: cover;">
    </div>
    @endif

    <!-- Content -->
    <div style="flex:1;">
        <h3 class="note-title" style="margin-right:24px;">{{ $note->title }}</h3>
        @if($note->content)
            <p class="note-content">{{ $note->content }}</p>
        @else
            <p class="note-content" style="font-style:italic;color:#9ca3af;">No content...</p>
        @endif
    </div>

    <!-- Bottom Container for Actions -->
    <div style="height: 28px; display: flex; align-items: center; margin-top: 12px; position: relative; width: 100%;">
        <!-- Time footer (visible before hover) -->
        <span class="note-card-time" style="position: absolute; left: 0; bottom: 6px;">
            Trashed {{ $note->deleted_at->diffForHumans() }}
        </span>

        <!-- Hover Toolbar (visible on hover) -->
        <div class="note-card-toolbar" style="position: absolute; left: 0; right: 0; bottom: 0;">
            <!-- Delete Forever Form -->
            <form method="POST" action="{{ route('notes.forceDelete', $note->id) }}" style="margin:0;padding:0; display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="card-toolbar-btn danger" title="Delete forever">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>

            <!-- Restore Form -->
            <form method="POST" action="{{ route('notes.restore', $note->id) }}" style="margin:0;padding:0; display:inline;">
                @csrf
                <button type="submit" class="card-toolbar-btn" title="Restore note">
                    <i class="fa-solid fa-trash-arrow-up"></i>
                </button>
            </form>
        </div>
    </div>
</div>
