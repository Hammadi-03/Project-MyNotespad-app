@extends('layouts.app')

@section('content')


<div class="app-wrapper">

    <!-- Top Bar -->
    <header class="topbar">
        <div class="topbar-left">
            <button type="button" class="hamburger" onclick="toggleSidebar(event)" aria-label="Toggle sidebar">
                <svg focusable="false" viewBox="0 0 24 24" style="width:24px;height:24px;fill:currentColor;"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path></svg>
            </button>
            <a href="{{ route('notes.index') }}" class="topbar-logo">
                <div class="topbar-logo-icon" style="background:#F5B041;color:#fff;font-size:18px;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-lightbulb"></i></div>
                <span>Mynotepad</span>
            </a>
        </div>
        <div class="search-container">
            <form method="GET" action="{{ route('notes.index') }}" style="width:100%;">
                <div class="search-bar">
                    <button type="submit" style="background:none;border:none;cursor:pointer;color:#5f6368;display:flex;">
                        <svg focusable="false" viewBox="0 0 24 24" style="width:20px;height:20px;fill:currentColor;"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>
                    </button>
                    <input type="text" name="search" placeholder="Search" value="{{ request('search') }}" autocomplete="off">
                </div>
            </form>
        </div>
        <div class="topbar-right">
            <a href="{{ route('notes.index') }}" class="topbar-icon-btn hide-mobile" title="Refresh">
                <svg focusable="false" viewBox="0 0 24 24" style="width:24px;height:24px;fill:currentColor;"><path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"></path></svg>
            </a>
            <button type="button" class="topbar-icon-btn hide-mobile" id="viewModeToggleBtn" onclick="toggleViewMode()" title="Toggle View Mode">
                <svg focusable="false" viewBox="0 0 24 24" style="width:24px;height:24px;fill:currentColor;"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"></path></svg>
            </button>
            <div style="position: relative; display: inline-block;">
                <button type="button" class="topbar-icon-btn" onclick="toggleSettingsDropdown(event)" title="Settings">
                    <svg focusable="false" viewBox="0 0 24 24" style="width:24px;height:24px;fill:currentColor;"><path d="M19.43 12.98c.04-.32.07-.64.07-.98 0-.34-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98 0 .33.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.23.09.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"></path></svg>
                </button>
                <div class="user-dropdown" id="settingsDropdown" style="display:none; position:absolute; right:0; top:42px; width:180px; z-index:1000; box-shadow:var(--shadow-md);">
                    <button type="button" class="dropdown-item" onclick="openSettingsModal()"><i class="fa-solid fa-gear" style="width:18px;"></i> Settings</button>
                    <button type="button" class="dropdown-item" onclick="openFeedbackModal()"><i class="fa-regular fa-comment-dots" style="width:18px;"></i> Send feedback</button>
                </div>
            </div>
            <div class="user-menu" id="userMenu" onclick="toggleUserMenu(event)">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-dropdown">
                    <div style="padding:8px 12px 12px;">
                        <div style="font-size:13px;font-weight:700;color:var(--gray-900);">{{ auth()->user()->name }}</div>
                        <div style="font-size:12px;color:var(--gray-400);">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item danger"><i class="fa-solid fa-right-from-bracket" style="width:18px;"></i> Sign Out</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('notes.index') }}" class="nav-item {{ (Request::routeIs('notes.index') && !isset($currentLabel) && !isset($isArchivePage)) ? 'active' : '' }}">
            <span class="nav-icon" style="width:24px;text-align:center;"><i class="fa-regular fa-lightbulb"></i></span> Notes
        </a>
        
        <!-- Display dynamic user labels -->
        @foreach($globalLabels as $lbl)
        <a href="{{ route('labels.show', $lbl->id) }}" class="nav-item {{ (isset($currentLabel) && $currentLabel->id === $lbl->id) ? 'active' : '' }}">
            <span class="nav-icon" style="width:24px;text-align:center;"><i class="fa-solid fa-tag"></i></span> {{ $lbl->name }}
        </a>
        @endforeach

        <a href="#" class="nav-item" onclick="openEditLabelsModal(); return false;">
            <span class="nav-icon" style="width:24px;text-align:center;"><i class="fa-solid fa-pencil"></i></span> Edit labels
        </a>
        <a href="{{ route('notes.archive') }}" class="nav-item {{ isset($isArchivePage) ? 'active' : '' }}">
            <span class="nav-icon" style="width:24px;text-align:center;"><i class="fa-solid fa-box-archive"></i></span> Archive
        </a>
        <a href="{{ route('notes.trash') }}" class="nav-item {{ Request::routeIs('notes.trash') ? 'active' : '' }}">
            <span class="nav-icon" style="width:24px;text-align:center;"><i class="fa-regular fa-trash-can"></i></span> Trash
        </a>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        @if(request('search'))
        <div class="search-results-bar">
            <span>🔍 Results for "{{ request('search') }}" — {{ $notes->count() }} note{{ $notes->count() !== 1 ? 's' : '' }} found</span>
            <a href="{{ route('notes.index') }}" style="color:var(--primary);font-size:13px;text-decoration:none;font-weight:600;">Clear ✕</a>
        </div>
        <div class="page-header">
            <div class="page-title-block">
                <h1>Search Results</h1>
                <p>{{ $totalNotes }} note{{ $totalNotes !== 1 ? 's' : '' }} · Last updated {{ now()->format('M j, Y') }}</p>
            </div>
        </div>
        @elseif(isset($isArchivePage))
        <div class="page-header">
            <div class="page-title-block">
                <h1>Archive</h1>
            </div>
        </div>
        @elseif(isset($currentLabel))
        <div class="page-header">
            <div class="page-title-block">
                <h1>Label: {{ $currentLabel->name }}</h1>
            </div>
        </div>
        @endif

        {{-- Show Quick Note Creator (unless it is Archive page) --}}
        @if(!isset($isArchivePage) && !request('search'))
        <!-- Quick Note Creator -->
        <div class="quick-note-wrapper" id="quickNoteWrapper">
            <form action="{{ route('notes.store') }}" method="POST" id="quickNoteForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="color" id="quickNoteColor" value="default">
                <input type="hidden" name="is_archived" id="quickNoteIsArchived" value="0">
                @if(isset($currentLabel))
                    <input type="hidden" name="label_ids[]" value="{{ $currentLabel->id }}">
                @endif
                <input type="file" name="image" id="quickNoteImageInput" style="display:none;" accept="image/*" onchange="previewQuickNoteImage(this)">
                
                <div class="quick-note-card" id="quickNoteCard">
                    <!-- Image Preview Section (At the top, initially hidden) -->
                    <div id="quickNoteImagePreview" style="display:none; position:relative; overflow:hidden; border-radius: 8px 8px 0 0; max-height: 240px; border-bottom: 1px solid var(--gray-100);">
                        <img src="" style="width: 100%; height: auto; display: block; object-fit: cover;">
                        <button type="button" onclick="removeQuickNoteImage()" style="position:absolute; top:8px; right:8px; background:rgba(0,0,0,0.6); color:#fff; border:none; border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center; cursor:pointer;" title="Remove image"><i class="fa-solid fa-xmark"></i></button>
                    </div>

                    <!-- Title (Visible when expanded) -->
                    <div class="qn-title-wrap">
                        <input type="text" name="title" id="quickNoteTitle" class="qn-title" placeholder="Title">
                    </div>
                    
                    <!-- Content -->
                    <div class="qn-content-wrap">
                        <textarea name="content" class="qn-content" id="qnContent" rows="1" placeholder="Take a note..." onfocus="expandQuickNote()"></textarea>
                        
                        <!-- Unexpanded right icons -->
                        <div class="qn-icons" id="qnIcons">
                            <button type="button" class="qn-tool-btn" title="New list"><i class="fa-regular fa-square-check"></i></button>
                            <button type="button" class="qn-tool-btn" title="New note with drawing"><i class="fa-solid fa-paint-brush"></i></button>
                            <button type="button" class="qn-tool-btn" title="New note with image" onclick="document.getElementById('quickNoteImageInput').click(); expandQuickNote();"><i class="fa-regular fa-image"></i></button>
                        </div>
                    </div>

                    <!-- Footer Toolbar (Visible when expanded) -->
                    <div class="qn-footer">
                        <div class="qn-toolbar">
                            <button type="button" class="qn-tool-btn" title="Remind me"><i class="fa-regular fa-bell"></i></button>
                            <button type="button" class="qn-tool-btn" title="Collaborator"><i class="fa-solid fa-user-plus"></i></button>
                            
                            <!-- Color Picker Palette inside Quick Note Toolbar -->
                            <div style="position: relative; display: inline-block;">
                                <button type="button" class="qn-tool-btn" title="Change color" onclick="event.stopPropagation(); toggleQuickNoteColorMenu(event)">
                                    <i class="fa-solid fa-palette"></i>
                                </button>
                                <div class="color-menu" id="quickNoteColorMenu" style="display: none; position: absolute; bottom: 38px; left: 50%; transform: translateX(-50%); background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.2); border-radius: 8px; padding: 6px; gap: 6px; z-index: 100; border: 1px solid var(--gray-200); flex-wrap: nowrap; align-items: center;">
                                    <button type="button" onclick="event.stopPropagation(); selectQuickNoteColor('default')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid #ccc; background: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Default"><i class="fa-solid fa-ban" style="font-size: 10px; color: #5f6368;"></i></button>
                                    <button type="button" onclick="event.stopPropagation(); selectQuickNoteColor('red')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid transparent; background: #f28b82; cursor: pointer;" title="Red"></button>
                                    <button type="button" onclick="event.stopPropagation(); selectQuickNoteColor('yellow')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid transparent; background: #fff475; cursor: pointer;" title="Yellow"></button>
                                    <button type="button" onclick="event.stopPropagation(); selectQuickNoteColor('green')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid transparent; background: #ccff90; cursor: pointer;" title="Green"></button>
                                    <button type="button" onclick="event.stopPropagation(); selectQuickNoteColor('blue')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid transparent; background: #cbf0f8; cursor: pointer;" title="Blue"></button>
                                    <button type="button" onclick="event.stopPropagation(); selectQuickNoteColor('purple')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid transparent; background: #d7aefb; cursor: pointer;" title="Purple"></button>
                                </div>
                            </div>

                            <button type="button" class="qn-tool-btn" title="Add image" onclick="document.getElementById('quickNoteImageInput').click();"><i class="fa-regular fa-image"></i></button>
                            <button type="button" class="qn-tool-btn" onclick="archiveQuickNote()" title="Archive"><i class="fa-solid fa-box-archive"></i></button>
                            <button type="button" class="qn-tool-btn" title="More"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                        </div>
                        <div class="qn-actions">
                            <button type="button" class="btn btn-ghost btn-sm" style="border:none;" onclick="closeQuickNote()">Close</button>
                            <button type="submit" class="btn btn-ghost btn-sm" style="border:none;color:var(--primary);font-weight:700;">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif

        {{-- Pinned Notes --}}
        @if($pinned->count() > 0)
        <div id="pinned-section">
            <div class="section-header">
                <span style="color:#5f6368;font-size:12px;transform:rotate(45deg);display:inline-block;"><i class="fa-solid fa-thumbtack"></i></span>
                <h2 style="font-size:11px;font-weight:600;color:#5f6368;text-transform:uppercase;letter-spacing:0.8px;">Pinned</h2>
                <span class="section-count">{{ $pinned->count() }}</span>
            </div>
            <div class="notes-grid">
                @foreach($pinned as $note)
                    @include('notes._card', ['note' => $note])
                @endforeach
            </div>
        </div>
        @endif

        {{-- All / Unpinned Notes --}}
        @if($unpinned->count() > 0)
        <div class="section-header">
            <span style="color:#5f6368;font-size:12px;display:inline-block;"><i class="fa-regular fa-note-sticky"></i></span>
            <h2 style="font-size:11px;font-weight:600;color:#5f6368;text-transform:uppercase;letter-spacing:0.8px;">{{ $pinned->count() > 0 ? 'Others' : 'Notes' }}</h2>
            <span class="section-count">{{ $unpinned->count() }}</span>
        </div>
        <div class="notes-grid">
            @foreach($unpinned as $note)
                @include('notes._card', ['note' => $note])
            @endforeach
        </div>
        @endif

        {{-- Empty State --}}
        @if($notes->count() === 0)
        <div class="empty-state" style="border:none;background:none;padding:120px 24px;">
            <div class="empty-icon" style="color:#e0e0e0;font-size:96px;margin-bottom:24px;line-height:1;">
                @if(request('search'))
                    <i class="fa-solid fa-magnifying-glass"></i>
                @else
                    <i class="fa-regular fa-lightbulb"></i>
                @endif
            </div>
            <div class="empty-title" style="color:#80868b;font-weight:500;">{{ request('search') ? 'No notes found' : 'No noteyyyyy' }}</div>
            <div class="empty-sub">
                @if(request('search'))
                    No notes match "{{ request('search') }}". Try a different keyword.
                @else
                @endif
            </div>
        </div>
        @endif

    </main>
</div>

<!-- Edit Note Modal (Keep Style Pop-up) -->
<div id="editNoteModal" class="modal-backdrop" onclick="closeEditModalOutside(event)">
    <div class="edit-modal-card" id="editModalCard">
        <form id="editNoteForm" enctype="multipart/form-data" onsubmit="event.preventDefault(); saveEditModal();">
            <!-- Modal Image Header -->
            <div id="editModalImageWrap" style="display:none; position:relative; overflow:hidden; border-radius: 8px 8px 0 0; max-height: 320px; border-bottom: 1px solid var(--gray-100);">
                <img id="editModalImg" src="" style="width: 100%; height: auto; display: block; object-fit: cover;">
                <button type="button" onclick="removeEditModalImage()" style="position:absolute; top:8px; right:8px; background:rgba(0,0,0,0.6); color:#fff; border:none; border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center; cursor:pointer;" title="Remove image"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <!-- Title field -->
            <div style="padding: 16px 20px 0; display: flex; align-items: center; justify-content: space-between;">
                <input type="text" id="editModalTitle" name="title" placeholder="Title" style="width:100%; border:none; outline:none; font-size:18px; font-weight:600; color:var(--gray-900); font-family:inherit; background:transparent;">
                <button type="button" id="editModalPinBtn" class="card-toolbar-btn" style="color: #5f6368;" onclick="toggleEditModalPin()"><i class="fa-solid fa-thumbtack"></i></button>
            </div>

            <!-- Content textarea -->
            <div style="padding: 12px 20px 16px;">
                <textarea id="editModalContent" name="content" rows="4" placeholder="Note" style="width:100%; border:none; outline:none; font-size:15px; color:var(--gray-800); font-family:inherit; resize:none; background:transparent; padding:0; line-height: 1.5;"></textarea>
            </div>

            <!-- Hidden input for note ID, color, is_pinned -->
            <input type="hidden" id="editModalNoteId">
            <input type="hidden" id="editModalColor" name="color">
            <input type="hidden" id="editModalIsPinned" name="is_pinned">
            <input type="file" id="editModalImageInput" name="image" style="display:none;" accept="image/*" onchange="previewEditModalImage(this)">

            <!-- Modal Footer Toolbar -->
            <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 20px; border-radius: 0 0 8px 8px;">
                <div style="display:flex; gap:8px;">
                    <button type="button" class="card-toolbar-btn" title="Remind me"><i class="fa-regular fa-bell"></i></button>
                    <button type="button" class="card-toolbar-btn" title="Collaborator"><i class="fa-solid fa-user-plus"></i></button>
                    
                    <!-- Color Picker inside Edit Modal -->
                    <div style="position: relative; display: inline-block;">
                        <button type="button" class="card-toolbar-btn" title="Change color" onclick="event.stopPropagation(); toggleEditModalColorMenu(event)">
                            <i class="fa-solid fa-palette"></i>
                        </button>
                        <div class="color-menu" id="editModalColorMenu" style="display: none; position: absolute; bottom: 34px; left: 50%; transform: translateX(-50%); background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.2); border-radius: 8px; padding: 6px; gap: 6px; z-index: 1100; border: 1px solid var(--gray-200); flex-wrap: nowrap; align-items: center;">
                            <button type="button" onclick="event.stopPropagation(); changeEditModalColor('default')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid #ccc; background: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;" title="Default"><i class="fa-solid fa-ban" style="font-size: 10px; color: #5f6368;"></i></button>
                            <button type="button" onclick="event.stopPropagation(); changeEditModalColor('red')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid transparent; background: #f28b82; cursor: pointer;" title="Red"></button>
                            <button type="button" onclick="event.stopPropagation(); changeEditModalColor('yellow')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid transparent; background: #fff475; cursor: pointer;" title="Yellow"></button>
                            <button type="button" onclick="event.stopPropagation(); changeEditModalColor('green')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid transparent; background: #ccff90; cursor: pointer;" title="Green"></button>
                            <button type="button" onclick="event.stopPropagation(); changeEditModalColor('blue')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid transparent; background: #cbf0f8; cursor: pointer;" title="Blue"></button>
                            <button type="button" onclick="event.stopPropagation(); changeEditModalColor('purple')" style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid transparent; background: #d7aefb; cursor: pointer;" title="Purple"></button>
                        </div>
                    </div>

                    <button type="button" class="card-toolbar-btn" title="Add image" onclick="document.getElementById('editModalImageInput').click();"><i class="fa-regular fa-image"></i></button>
                    
                    <!-- 3 Dot Options Button inside Modal -->
                    <div style="position: relative; display: inline-block;">
                        <button type="button" class="card-toolbar-btn" title="More" onclick="event.stopPropagation(); toggleEditModalMoreMenu(event)">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <div id="editModalMoreMenu" style="display: none; position: absolute; bottom: 34px; left: 0; background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.2); border-radius: 4px; padding: 4px 0; z-index: 1100; border: 1px solid var(--gray-200); min-width: 140px; text-align: left; flex-direction: column;">
                            <button type="button" onclick="deleteModalNote()" style="width: 100%; border: none; background: none; padding: 6px 12px; font-size: 14px; text-align: left; cursor: pointer; color: var(--danger); display: block; font-family: inherit;">Delete note</button>
                            <button type="button" onclick="duplicateModalNote()" style="width: 100%; border: none; background: none; padding: 6px 12px; font-size: 14px; text-align: left; cursor: pointer; color: var(--gray-800); display: block; font-family: inherit;">Make a copy</button>
                        </div>
                    </div>
                </div>
                <div style="display:flex; gap:8px;">
                    <button type="button" class="btn btn-ghost btn-sm" style="border:none; color:var(--gray-900); font-weight:700; font-family: inherit; font-size: 14px;" onclick="saveEditModal()">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
