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


@endsection
