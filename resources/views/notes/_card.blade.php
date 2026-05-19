@php
$colorMap = [
    'default' => '',
    'blue'    => 'color-blue',
    'green'   => 'color-green',
    'yellow'  => 'color-yellow',
    'red'     => 'color-red',
    'purple'  => 'color-purple',
];
$colorDots = [
    'default' => '#9CA3AF',
    'blue'    => '#3B82F6',
    'green'   => '#10B981',
    'yellow'  => '#F59E0B',
    'red'     => '#EF4444',
    'purple'  => '#8B5CF6',
];
$colorClass = $colorMap[$note->color] ?? '';
@endphp
<div class="note-card {{ $note->is_pinned ? 'pinned' : '' }} {{ $colorClass }}">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;margin-bottom:8px;">
        <h3 class="note-title" style="flex:1;margin-bottom:0;">
            <span class="note-color-dot" style="background:{{ $colorDots[$note->color] ?? '#9CA3AF' }};"></span>
            {{ $note->title }}
        </h3>
        <form method="POST" action="{{ route('notes.pin', $note) }}" style="flex-shrink:0;">
            @csrf
            <button type="submit" class="btn-icon-sm {{ $note->is_pinned ? 'pin-active' : '' }}" title="{{ $note->is_pinned ? 'Unpin' : 'Pin' }}" style="color:{{ $note->is_pinned ? '#F59E0B' : '#9CA3AF' }};">
                📌
            </button>
        </form>
    </div>

    @if($note->content)
    <p class="note-content">{{ $note->content }}</p>
    @else
    <p class="note-content" style="font-style:italic;color:#C4C4C4;">No content yet...</p>
    @endif

    <div class="note-card-footer">
        <span class="note-date" title="{{ $note->updated_at->format('M j, Y g:ia') }}">
            {{ $note->updated_at->diffForHumans() }}
        </span>
        <div class="note-actions">
            <a href="{{ route('notes.edit', $note) }}" class="note-action-btn" title="Edit">
                ✏️ Edit
            </a>
            <button
                class="note-action-btn danger"
                title="Delete"
                onclick="confirmDelete({{ $note->id }}, '{{ addslashes($note->title) }}', '{{ route('notes.destroy', $note) }}')"
            >
                🗑️ Delete
            </button>
        </div>
    </div>
</div>
