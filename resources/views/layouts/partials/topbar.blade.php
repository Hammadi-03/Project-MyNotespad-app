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
        <form method="GET" action="{{ Request::routeIs('notes.trash') ? route('notes.trash') : route('notes.index') }}" style="width:100%;">
            <div class="search-bar">
                <button type="submit" style="background:none;border:none;cursor:pointer;color:#5f6368;display:flex;">
                    <svg focusable="false" viewBox="0 0 24 24" style="width:20px;height:20px;fill:currentColor;"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>
                </button>
                <input type="text" name="search" placeholder="Search {{ Request::routeIs('notes.trash') ? 'deleted notes' : 'notes' }}" value="{{ request('search') }}" autocomplete="off">
            </div>
        </form>
    </div>
    <div class="topbar-right">
        <a href="{{ Request::routeIs('notes.trash') ? route('notes.trash') : route('notes.index') }}" class="topbar-icon-btn hide-mobile" title="Refresh">
            <svg focusable="false" viewBox="0 0 24 24" style="width:24px;height:24px;fill:currentColor;"><path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"></path></svg>
        </a>
        @if(!Request::routeIs('notes.trash'))
        <button type="button" class="topbar-icon-btn hide-mobile" id="viewModeToggleBtn" onclick="toggleViewMode()" title="Toggle View Mode">
            <svg focusable="false" viewBox="0 0 24 24" style="width:24px;height:24px;fill:currentColor;"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"></path></svg>
        </button>
        @endif
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
            <div class="user-avatar">{{ auth()->user() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'U' }}</div>
            <div class="user-dropdown">
                <div style="padding:8px 12px 12px;">
                    <div style="font-size:13px;font-weight:700;color:var(--gray-900);">{{ auth()->user() ? auth()->user()->name : 'Guest' }}</div>
                    <div style="font-size:12px;color:var(--gray-400);">{{ auth()->user() ? auth()->user()->email : '' }}</div>
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
