@extends('layouts.app')

@section('content')
<style>
    /* Reuse design system tokens & custom fonts */
    :root {
        --primary: #1a73e8;
        --primary-hover: #1557b0;
        --primary-bg: #e8f0fe;
        --bg-main: #f1f3f4;
        --sidebar-width: 280px;
        
        --gray-50: #f8f9fa;
        --gray-100: #f1f3f4;
        --gray-200: #e0e0e0;
        --gray-300: #dadce0;
        --gray-400: #bdc1c6;
        --gray-500: #9ca3af;
        --gray-600: #5f6368;
        --gray-700: #3c4043;
        --gray-800: #202124;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px 0 rgba(60,64,67,0.3), 0 1px 3px 1px rgba(60,64,67,0.15);
        --shadow-md: 0 1px 3px 0 rgba(60,64,67,0.3), 0 4px 8px 3px rgba(60,64,67,0.15);
        --shadow-lg: 0 2px 6px 0 rgba(60,64,67,0.3), 0 8px 24px 6px rgba(60,64,67,0.15);
        
        --danger: #d93025;
        --danger-bg: #fce8e6;
    }

    body {
        background-color: #ffffff;
        color: var(--gray-800);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* Layout structure */
    .app-wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    
    /* Topbar styling */
    .topbar {
        height: 64px;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 24px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 100;
        background: #fff;
    }
    .topbar-left {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 232px;
    }
    .hamburger {
        background: none;
        border: none;
        color: var(--gray-600);
        cursor: pointer;
        padding: 12px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s;
    }
    .hamburger:hover {
        background: var(--gray-100);
    }
    .topbar-logo {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: var(--gray-800);
        font-weight: 500;
        font-size: 22px;
    }
    .topbar-logo-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
    }

    /* Search bar container */
    .search-container {
        flex: 1;
        max-width: 720px;
        margin-left: 20px;
    }
    .search-bar {
        background: var(--gray-100);
        border-radius: 8px;
        display: flex;
        align-items: center;
        padding: 0 16px;
        height: 48px;
        transition: background-color .2s, box-shadow .2s;
    }
    .search-bar:focus-within {
        background: #fff;
        box-shadow: 0 1px 1px 0 rgba(65,69,73,0.3), 0 1px 3px 1px rgba(65,69,73,0.15);
    }
    .search-bar input {
        border: none;
        background: transparent;
        outline: none;
        width: 100%;
        font-size: 16px;
        color: var(--gray-800);
        margin-left: 12px;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .topbar-icon-btn {
        background: none;
        border: none;
        color: var(--gray-600);
        padding: 12px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: background .2s;
    }
    .topbar-icon-btn:hover {
        background: var(--gray-100);
    }

    /* User Profile Dropdown */
    .user-menu {
        position: relative;
        cursor: pointer;
        margin-left: 8px;
    }
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--primary);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }
    .user-dropdown {
        position: absolute;
        top: 40px;
        right: 0;
        background: #fff;
        border-radius: 8px;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-200);
        width: 240px;
        display: none;
        z-index: 200;
        padding: 8px 0;
    }
    .user-menu.open .user-dropdown {
        display: block;
    }
    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 10px 16px;
        color: var(--gray-700);
        text-decoration: none;
        font-size: 14px;
        transition: background .2s;
    }
    .dropdown-item:hover {
        background: var(--gray-50);
    }
    .dropdown-item.danger {
        color: var(--danger);
    }
    .dropdown-item.danger:hover {
        background: var(--danger-bg);
    }
    .dropdown-divider {
        height: 1px;
        background: var(--gray-200);
        margin: 6px 0;
    }

    /* Sidebar Navigation */
    .sidebar {
        width: var(--sidebar-width);
        position: fixed;
        top: 64px;
        left: 0;
        bottom: 0;
        background: #fff;
        padding: 12px 0;
        overflow-y: auto;
        transition: width 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 90;
    }
    .sidebar.closed {
        width: 80px;
    }
    .nav-item {
        display: flex;
        align-items: center;
        padding: 0 24px;
        height: 48px;
        color: var(--gray-700);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        border-radius: 0 24px 24px 0;
        margin-right: 8px;
        transition: background-color 0.15s, color 0.15s;
        overflow: hidden;
        white-space: nowrap;
    }
    .nav-item:hover {
        background-color: var(--gray-100);
        color: var(--gray-900);
    }
    .nav-item.active {
        background-color: #feefc3;
        color: #202124;
        font-weight: 600;
    }
    .nav-icon {
        margin-right: 20px;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sidebar.closed .nav-item {
        padding: 0 28px;
    }

    /* Main Container space */
    .main-content {
        margin-left: var(--sidebar-width);
        margin-top: 64px;
        padding: 32px;
        background-color: #fff;
        min-height: calc(100vh - 64px);
        transition: margin-left 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .main-content.expanded {
        margin-left: 80px;
    }

    /* Grid configuration */
    .notes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
        margin-top: 24px;
    }

    /* Note Card & Theme variants */
    .note-card {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: 8px;
        padding: 16px;
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 120px;
        transition: box-shadow .2s, border-color .2s;
    }
    .note-card:hover {
        box-shadow: 0 1px 2px 0 rgba(60,64,67,0.3), 0 2px 6px 2px rgba(60,64,67,0.15);
        border-color: transparent;
    }
    .note-card.color-red { background: #f28b82 !important; }
    .note-card.color-yellow { background: #fff475 !important; }
    .note-card.color-green { background: #ccff90 !important; }
    .note-card.color-blue { background: #cbf0f8 !important; }
    .note-card.color-purple { background: #d7aefb !important; }

    .note-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--gray-900);
        word-break: break-word;
    }
    .note-content {
        font-size: 14px;
        line-height: 1.5;
        color: var(--gray-700);
        white-space: pre-wrap;
        word-break: break-word;
    }

    /* Time footer */
    .note-card-time {
        font-size: 11px;
        color: var(--gray-600);
        font-weight: 500;
    }

    /* Card hover Toolbar */
    .note-card-toolbar {
        display: none;
        background: rgba(255,255,255,0.85);
        padding: 2px 6px;
        border-radius: 4px;
        align-items: center;
        gap: 4px;
    }
    /* Inherit note card colors in toolbar overlays */
    .note-card.color-red .note-card-toolbar { background: rgba(242,139,130,0.9); }
    .note-card.color-yellow .note-card-toolbar { background: rgba(255,244,117,0.9); }
    .note-card.color-green .note-card-toolbar { background: rgba(204,255,144,0.9); }
    .note-card.color-blue .note-card-toolbar { background: rgba(203,240,248,0.9); }
    .note-card.color-purple .note-card-toolbar { background: rgba(215,174,251,0.9); }

    .note-card:hover .note-card-toolbar {
        display: flex;
    }
    .note-card:hover .note-card-time {
        display: none;
    }

    .card-toolbar-btn {
        background: none;
        border: none;
        color: var(--gray-600);
        font-size: 14px;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        cursor: pointer;
        transition: background .2s;
    }
    .card-toolbar-btn:hover {
        background: rgba(95,99,104,0.15);
        color: var(--gray-800);
    }
    .card-toolbar-btn.danger:hover {
        background: var(--danger-bg);
        color: var(--danger);
    }

    /* Empty states */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 80px 24px;
    }
    .empty-icon {
        font-size: 80px;
        color: var(--gray-200);
        margin-bottom: 16px;
    }
    .empty-title {
        font-size: 18px;
        font-weight: 500;
        color: var(--gray-600);
        margin-bottom: 8px;
    }
    .empty-sub {
        font-size: 14px;
        color: var(--gray-500);
        max-width: 320px;
        line-height: 1.5;
    }

    @media(max-width:768px){
        .sidebar { position:fixed; z-index:200; }
        .main-content { margin-left:0 !important; }
        .topbar-left { min-width:auto; gap:4px; }
        .notes-grid { grid-template-columns:1fr; }
        .note-card-toolbar { display: flex; background:transparent; }
    }
</style>

<div class="app-wrapper">

    <!-- Top Bar -->
    <header class="topbar">
        <div class="topbar-left">
            <button type="button" class="hamburger" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                <svg focusable="false" viewBox="0 0 24 24" style="width:24px;height:24px;fill:currentColor;"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path></svg>
            </button>
            <a href="{{ route('notes.index') }}" class="topbar-logo">
                <div class="topbar-logo-icon" style="background:#F5B041;color:#fff;font-size:18px;display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-lightbulb"></i></div>
                <span>Mynotepad</span>
            </a>
        </div>
        <div class="search-container">
            <form method="GET" action="{{ route('notes.trash') }}" style="width:100%;">
                <div class="search-bar">
                    <button type="submit" style="background:none;border:none;cursor:pointer;color:#5f6368;display:flex;">
                        <svg focusable="false" viewBox="0 0 24 24" style="width:20px;height:20px;fill:currentColor;"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>
                    </button>
                    <input type="text" name="search" placeholder="Search deleted notes" value="{{ request('search') }}" autocomplete="off">
                </div>
            </form>
        </div>
        <div class="topbar-right">
            <a href="{{ route('notes.trash') }}" class="topbar-icon-btn" title="Refresh">
                <svg focusable="false" viewBox="0 0 24 24" style="width:24px;height:24px;fill:currentColor;"><path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"></path></svg>
            </a>
            <div class="user-menu" id="userMenu" onclick="toggleUserMenu()">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-dropdown">
                    <div style="padding:8px 12px 12px;">
                        <div style="font-size:13px;font-weight:700;color:var(--gray-900);">{{ auth()->user()->name }}</div>
                        <div style="font-size:12px;color:var(--gray-400);">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('notes.index') }}" class="dropdown-item"><i class="fa-regular fa-file-lines" style="width:18px;"></i> Notes</a>
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
        <a href="{{ route('notes.index') }}" class="nav-item">
            <span class="nav-icon" style="width:24px;text-align:center;"><i class="fa-regular fa-lightbulb"></i></span> Notes
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon" style="width:24px;text-align:center;"><i class="fa-solid fa-pencil"></i></span> Edit labels
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon" style="width:24px;text-align:center;"><i class="fa-solid fa-box-archive"></i></span> Archive
        </a>
        <a href="{{ route('notes.trash') }}" class="nav-item active">
            <span class="nav-icon" style="width:24px;text-align:center;"><i class="fa-regular fa-trash-can"></i></span> Trash
        </a>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Trash Banner Alert -->
        <div class="trash-header-bar" style="display: flex; justify-content: center; align-items: center; gap: 16px; margin: 12px auto 24px; padding: 12px; max-width: 600px; text-align: center; border-radius: 8px;">
            <span style="font-size: 14px; color: var(--gray-700); font-style: italic;">Notes in Trash are deleted after 7 days.</span>
            @if($notes->count() > 0)
                <form method="POST" action="{{ route('notes.emptyTrash') }}" style="margin: 0;" onsubmit="return confirm('Empty entire trash forever?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color: #1a73e8; font-weight: 700; border: none; background: none; font-size: 14px; cursor: pointer; font-family: inherit;">Empty Trash</button>
                </form>
            @endif
        </div>

        @if($notes->count() > 0)
            <div class="notes-grid">
                @foreach($notes as $note)
                    @include('notes._trash_card', ['note' => $note])
                @endforeach
            </div>
        @else
            <!-- Trash Empty State -->
            <div class="empty-state" style="border:none;background:none;padding:120px 24px;">
                <div class="empty-icon" style="color:#e0e0e0;font-size:96px;margin-bottom:24px;line-height:1;">
                    <i class="fa-regular fa-trash-can"></i>
                </div>
                <div class="empty-title" style="color:#80868b;font-weight:500;">No notes in Trash</div>
            </div>
        @endif
    </main>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    sidebar.classList.toggle('closed');
    mainContent.classList.toggle('expanded');
}

function toggleUserMenu() {
    document.getElementById('userMenu').classList.toggle('open');
}
document.addEventListener('click', function(e) {
    const menu = document.getElementById('userMenu');
    if (menu && !menu.contains(e.target)) menu.classList.remove('open');
});

// Initialize mobile state
if (window.innerWidth <= 768) {
    document.getElementById('sidebar').classList.add('closed');
    document.querySelector('.main-content').classList.add('expanded');
}
</script>
@endsection
