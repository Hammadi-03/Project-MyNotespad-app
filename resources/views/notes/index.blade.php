@extends('layouts.app')

@section('content')
<style>
    :root{--primary:#4F46E5;--primary-hover:#4338CA;--primary-light:#EEF2FF;--secondary:#06B6D4;--success:#10B981;--danger:#EF4444;--danger-hover:#DC2626;--gray-50:#F9FAFB;--gray-100:#F3F4F6;--gray-200:#E5E7EB;--gray-300:#D1D5DB;--gray-400:#9CA3AF;--gray-500:#6B7280;--gray-600:#4B5563;--gray-700:#374151;--gray-800:#1F2937;--gray-900:#111827;--sidebar-w:260px;--topbar-h:64px;--radius:12px;--radius-sm:8px;}
    /* Layout */
    .app-wrapper{display:flex;min-height:100vh;background:var(--gray-50);}
    /* Topbar */
    .topbar{position:fixed;top:0;left:0;right:0;height:var(--topbar-h);background:#fff;border-bottom:1px solid var(--gray-200);display:flex;align-items:center;justify-content:space-between;padding:0 24px;z-index:200;}
    .topbar-left{display:flex;align-items:center;gap:16px;}
    .topbar-logo{display:flex;align-items:center;gap:10px;}
    .topbar-logo-icon{width:34px;height:34px;background:var(--primary);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:17px;}
    .topbar-logo span{font-size:17px;font-weight:700;color:var(--gray-900);}
    .hamburger{display:none;background:none;border:none;cursor:pointer;padding:8px;border-radius:8px;color:var(--gray-600);}
    .hamburger:hover{background:var(--gray-100);}
    .search-bar{display:flex;align-items:center;gap:10px;background:var(--gray-50);border:1.5px solid var(--gray-200);border-radius:10px;padding:8px 14px;min-width:240px;transition:all .2s;}
    .search-bar:focus-within{border-color:var(--primary);background:#fff;box-shadow:0 0 0 3px rgba(79,70,229,.08);}
    .search-bar input{background:none;border:none;outline:none;font-size:14px;color:var(--gray-700);font-family:inherit;width:100%;}
    .search-bar input::placeholder{color:var(--gray-400);}
    .topbar-right{display:flex;align-items:center;gap:12px;}
    .user-menu{display:flex;align-items:center;gap:10px;padding:8px 12px;border-radius:10px;cursor:pointer;transition:background .2s;position:relative;}
    .user-menu:hover{background:var(--gray-100);}
    .user-avatar{width:34px;height:34px;background:linear-gradient(135deg,var(--primary),#7C3AED);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:700;}
    .user-name{font-size:14px;font-weight:600;color:var(--gray-800);}
    .user-dropdown{position:absolute;top:calc(100% + 8px);right:0;background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius);padding:8px;min-width:180px;box-shadow:0 10px 40px rgba(0,0,0,.12);opacity:0;pointer-events:none;transform:translateY(-6px);transition:all .15s ease;}
    .user-menu.open .user-dropdown{opacity:1;pointer-events:all;transform:translateY(0);}
    .dropdown-item{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;font-size:14px;color:var(--gray-700);cursor:pointer;transition:background .15s;text-decoration:none;border:none;background:none;width:100%;font-family:inherit;}
    .dropdown-item:hover{background:var(--gray-100);}
    .dropdown-item.danger{color:var(--danger);}
    .dropdown-item.danger:hover{background:#FEF2F2;}
    .dropdown-divider{height:1px;background:var(--gray-200);margin:6px 0;}

    /* Sidebar */
    .sidebar{position:fixed;top:var(--topbar-h);left:0;width:var(--sidebar-w);height:calc(100vh - var(--topbar-h));background:#fff;border-right:1px solid var(--gray-200);padding:20px 12px;overflow-y:auto;z-index:150;transition:transform .3s ease;}
    .sidebar-section-label{font-size:11px;font-weight:600;color:var(--gray-400);letter-spacing:.06em;text-transform:uppercase;padding:0 12px;margin-bottom:8px;margin-top:16px;}
    .sidebar-section-label:first-child{margin-top:0;}
    .nav-item{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:10px;font-size:14px;font-weight:500;color:var(--gray-600);cursor:pointer;transition:all .15s;text-decoration:none;border:none;background:none;width:100%;font-family:inherit;}
    .nav-item:hover{background:var(--gray-100);color:var(--gray-900);}
    .nav-item.active{background:var(--primary-light);color:var(--primary);font-weight:600;}
    .nav-item.active .nav-icon{color:var(--primary);}
    .nav-icon{font-size:16px;flex-shrink:0;}
    .nav-badge{margin-left:auto;background:var(--primary);color:#fff;font-size:11px;font-weight:600;padding:2px 8px;border-radius:999px;}

    /* Main */
    .main-content{margin-left:var(--sidebar-w);margin-top:var(--topbar-h);flex:1;padding:32px;min-width:0;}

    /* Page header */
    .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px;}
    .page-title-block h1{font-size:26px;font-weight:800;color:var(--gray-900);}
    .page-title-block p{font-size:14px;color:var(--gray-500);margin-top:4px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:var(--radius-sm);font-size:14px;font-weight:600;border:none;cursor:pointer;transition:all .2s ease;text-decoration:none;font-family:inherit;}
    .btn-primary{background:var(--primary);color:#fff;}
    .btn-primary:hover{background:var(--primary-hover);transform:translateY(-1px);box-shadow:0 4px 12px rgba(79,70,229,.35);}
    .btn-ghost{background:#fff;color:var(--gray-600);border:1.5px solid var(--gray-200);}
    .btn-ghost:hover{background:var(--gray-50);color:var(--gray-800);}
    .btn-sm{padding:7px 14px;font-size:13px;}
    .btn-icon-sm{padding:6px;border-radius:8px;background:none;border:none;cursor:pointer;transition:all .15s;display:inline-flex;align-items:center;font-size:15px;}
    .btn-icon-sm:hover{background:var(--gray-100);}
    .btn-icon-sm.pin-active{color:var(--warning);}

    /* Stats */
    .stats-row{display:flex;gap:16px;margin-bottom:32px;flex-wrap:wrap;}
    .stat-card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius);padding:20px 24px;display:flex;align-items:center;gap:16px;flex:1;min-width:160px;}
    .stat-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
    .stat-icon.blue{background:#EEF2FF;}
    .stat-icon.green{background:#ECFDF5;}
    .stat-icon.amber{background:#FFFBEB;}
    .stat-value{font-size:26px;font-weight:800;color:var(--gray-900);}
    .stat-label{font-size:13px;color:var(--gray-500);margin-top:2px;}

    /* Section headers */
    .section-header{display:flex;align-items:center;gap:10px;margin-bottom:16px;}
    .section-header h2{font-size:15px;font-weight:700;color:var(--gray-700);}
    .section-count{background:var(--gray-100);color:var(--gray-500);font-size:12px;font-weight:600;padding:3px 10px;border-radius:999px;}

    /* Notes Grid */
    .notes-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;margin-bottom:40px;}
    .note-card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius);padding:22px;transition:all .2s ease;display:flex;flex-direction:column;cursor:pointer;position:relative;}
    .note-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.09);transform:translateY(-3px);border-color:rgba(79,70,229,.2);}
    .note-card.pinned{border-top:3px solid var(--primary);}
    .note-color-dot{width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:6px;}
    .note-title{font-size:16px;font-weight:700;color:var(--gray-900);margin-bottom:10px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
    .note-content{font-size:14px;color:var(--gray-500);line-height:1.6;flex:1;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:16px;}
    .note-card-footer{display:flex;align-items:center;justify-content:space-between;padding-top:14px;border-top:1px solid var(--gray-100);}
    .note-date{font-size:12px;color:var(--gray-400);}
    .note-actions{display:flex;gap:4px;opacity:0;transition:opacity .15s;}
    .note-card:hover .note-actions{opacity:1;}
    .note-action-btn{padding:6px 8px;border-radius:7px;border:none;background:none;cursor:pointer;font-size:13px;color:var(--gray-500);transition:all .15s;display:inline-flex;align-items:center;gap:4px;}
    .note-action-btn:hover{background:var(--gray-100);color:var(--gray-800);}
    .note-action-btn.danger:hover{background:#FEF2F2;color:var(--danger);}

    /* Color variants */
    .color-blue .note-title{color:#1D4ED8;}
    .color-green .note-title{color:#065F46;}
    .color-yellow .note-title{color:#92400E;}
    .color-red .note-title{color:#991B1B;}
    .color-purple .note-title{color:#5B21B6;}
    .color-blue{border-top-color:#3B82F6;background:#F0F9FF;}
    .color-green{border-top-color:var(--success);background:#F0FDF4;}
    .color-yellow{border-top-color:var(--warning);background:#FFFBEB;}
    .color-red{border-top-color:var(--danger);background:#FFF5F5;}
    .color-purple{border-top-color:#8B5CF6;background:#FAF5FF;}

    /* Empty state */
    .empty-state{text-align:center;padding:80px 24px;background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius);}
    .empty-icon{font-size:64px;margin-bottom:20px;line-height:1;}
    .empty-title{font-size:20px;font-weight:700;color:var(--gray-900);margin-bottom:10px;}
    .empty-sub{font-size:15px;color:var(--gray-500);max-width:360px;margin:0 auto 28px;}

    /* Search results bar */
    .search-results-bar{background:var(--primary-light);border:1px solid rgba(79,70,229,.2);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;font-size:14px;color:var(--primary);font-weight:500;}

    @media(max-width:768px){
        .sidebar{transform:translateX(-100%);position:fixed;z-index:200;}
        .sidebar.open{transform:translateX(0);}
        .main-content{margin-left:0;}
        .hamburger{display:flex;}
        .search-bar{min-width:0;flex:1;}
        .stats-row{gap:12px;}
        .stat-card{padding:16px;}
        .notes-grid{grid-template-columns:1fr;}
        .note-actions{opacity:1;}
    }
    @media(max-width:480px){
        .main-content{padding:20px 16px;}
        .topbar{padding:0 16px;}
        .page-header{flex-direction:column;align-items:flex-start;}
    }
</style>

<div class="app-wrapper">

    <!-- Top Bar -->
    <header class="topbar">
        <div class="topbar-left">
            <button class="hamburger" onclick="toggleSidebar()" aria-label="Toggle sidebar">☰</button>
            <a href="{{ route('notes.index') }}" class="topbar-logo">
                <div class="topbar-logo-icon">📝</div>
                <span>MyNotepad</span>
            </a>
        </div>
        <form method="GET" action="{{ route('notes.index') }}" style="flex:1;max-width:400px;margin:0 24px;">
            <div class="search-bar">
                <span style="color:var(--gray-400);font-size:15px;">🔍</span>
                <input type="text" name="search" placeholder="Search notes..." value="{{ request('search') }}" autocomplete="off">
            </div>
        </form>
        <div class="topbar-right">
            <a href="{{ route('notes.create') }}" class="btn btn-primary btn-sm">+ New Note</a>
            <div class="user-menu" id="userMenu" onclick="toggleUserMenu()">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="user-name" style="display:none;">{{ auth()->user()->name }}</span>
                <span style="color:var(--gray-400);font-size:12px;">▾</span>
                <div class="user-dropdown">
                    <div style="padding:8px 12px 12px;">
                        <div style="font-size:13px;font-weight:700;color:var(--gray-900);">{{ auth()->user()->name }}</div>
                        <div style="font-size:12px;color:var(--gray-400);">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('notes.create') }}" class="dropdown-item">📝 New Note</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item danger">🚪 Sign Out</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-section-label">Workspace</div>
        <a href="{{ route('notes.index') }}" class="nav-item active">
            <span class="nav-icon">📝</span> All Notes
            @if($totalNotes > 0)
                <span class="nav-badge">{{ $totalNotes }}</span>
            @endif
        </a>
        @if($pinned->count() > 0)
        <a href="#pinned-section" class="nav-item">
            <span class="nav-icon">📌</span> Pinned
            <span class="nav-badge" style="background:var(--warning);">{{ $pinned->count() }}</span>
        </a>
        @endif

        <div class="sidebar-section-label">Actions</div>
        <a href="{{ route('notes.create') }}" class="nav-item">
            <span class="nav-icon">➕</span> New Note
        </a>

        <div class="sidebar-section-label" style="margin-top:auto;"></div>
        <div style="margin-top:16px;padding:14px;background:var(--primary-light);border-radius:10px;">
            <div style="font-size:12px;font-weight:600;color:var(--primary);margin-bottom:4px;">👋 Hello, {{ auth()->user()->name }}!</div>
            <div style="font-size:12px;color:var(--gray-500);">{{ $totalNotes }} note{{ $totalNotes !== 1 ? 's' : '' }} total</div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        @if(request('search'))
        <div class="search-results-bar">
            <span>🔍 Results for "{{ request('search') }}" — {{ $notes->count() }} note{{ $notes->count() !== 1 ? 's' : '' }} found</span>
            <a href="{{ route('notes.index') }}" style="color:var(--primary);font-size:13px;text-decoration:none;font-weight:600;">Clear ✕</a>
        </div>
        @endif

        <div class="page-header">
            <div class="page-title-block">
                <h1>{{ request('search') ? 'Search Results' : 'All Notes' }}</h1>
                <p>{{ $totalNotes }} note{{ $totalNotes !== 1 ? 's' : '' }} · Last updated {{ now()->format('M j, Y') }}</p>
            </div>
            <a href="{{ route('notes.create') }}" class="btn btn-primary">
                <span>+</span> New Note
            </a>
        </div>

        <!-- Stats -->
        @if(!request('search'))
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon blue">📝</div>
                <div>
                    <div class="stat-value">{{ $totalNotes }}</div>
                    <div class="stat-label">Total Notes</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon amber">📌</div>
                <div>
                    <div class="stat-value">{{ $pinned->count() }}</div>
                    <div class="stat-label">Pinned</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">📅</div>
                <div>
                    <div class="stat-value">{{ auth()->user()->notes()->whereDate('updated_at', today())->count() }}</div>
                    <div class="stat-label">Updated Today</div>
                </div>
            </div>
        </div>
        @endif

        {{-- Pinned Notes --}}
        @if($pinned->count() > 0)
        <div id="pinned-section">
            <div class="section-header">
                <span style="font-size:16px;">📌</span>
                <h2>Pinned</h2>
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
            <span style="font-size:16px;">📄</span>
            <h2>{{ $pinned->count() > 0 ? 'Other Notes' : 'Notes' }}</h2>
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
        <div class="empty-state">
            <div class="empty-icon">{{ request('search') ? '🔍' : '📋' }}</div>
            <div class="empty-title">{{ request('search') ? 'No notes found' : 'No notes yet' }}</div>
            <div class="empty-sub">
                @if(request('search'))
                    No notes match "{{ request('search') }}". Try a different keyword.
                @else
                    Create your first note to get started. Your ideas deserve a good home.
                @endif
            </div>
            @if(!request('search'))
                <a href="{{ route('notes.create') }}" class="btn btn-primary">+ Create Your First Note</a>
            @else
                <a href="{{ route('notes.index') }}" class="btn btn-ghost">← Back to Notes</a>
            @endif
        </div>
        @endif

    </main>
</div>

<script>
function toggleUserMenu() {
    document.getElementById('userMenu').classList.toggle('open');
}
document.addEventListener('click', function(e) {
    const menu = document.getElementById('userMenu');
    if (menu && !menu.contains(e.target)) menu.classList.remove('open');
});
// Close sidebar on overlay click (mobile)
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.querySelector('.hamburger');
    if (window.innerWidth <= 768 && sidebar && sidebar.classList.contains('open')) {
        if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    }
});
</script>
@endsection
