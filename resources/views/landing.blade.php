<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNotepad - Your thoughts, organized beautifully</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body>
<nav class="nav" id="navbar">
    <div class="nav-logo">
        <div class="nav-logo-icon">📝</div>
        <span class="nav-logo-text">MyNotepad</span>
    </div>
    <div class="nav-links">
        @auth
            <a href="{{ route('notes.index') }}" class="btn btn-primary">Open App</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-ghost">Log in</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
        @endauth
    </div>
</nav>

<section class="hero">
    <div class="hero-badge"><span class="hero-badge-dot"></span>Free forever — no credit card needed</div>
    <h1>Your thoughts,<br><span>organized beautifully</span></h1>
    <p>The modern note-taking app that keeps up with your mind. Capture ideas, organize your work, and never lose a thought again.</p>
    <div class="hero-ctas">
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">🚀 Get Started Free</a>
        <a href="{{ route('login') }}" class="btn btn-ghost btn-lg">Sign In →</a>
    </div>
    <div class="hero-preview">
        <div class="preview-topbar">
            <div class="preview-dot" style="background:#FF5F56"></div>
            <div class="preview-dot" style="background:#FFBD2E"></div>
            <div class="preview-dot" style="background:#27C93F"></div>
            <div style="margin-left:12px;font-size:12px;color:var(--gray-400);">MyNotepad — Dashboard</div>
        </div>
        <div class="preview-body">
            <div class="preview-sidebar">
                <div style="font-size:11px;font-weight:600;color:var(--gray-400);letter-spacing:.06em;text-transform:uppercase;margin-bottom:12px;">Workspace</div>
                <div class="preview-nav-item active">📊 Dashboard</div>
                <div class="preview-nav-item">📝 All Notes</div>
                <div class="preview-nav-item">⭐ Pinned</div>
                <div class="preview-nav-item">⚙️ Settings</div>
            </div>
            <div class="preview-main">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                    <div>
                        <div style="font-size:16px;font-weight:700;color:var(--gray-900);">All Notes</div>
                        <div style="font-size:12px;color:var(--gray-400);">6 notes · Last updated today</div>
                    </div>
                    <div style="background:var(--primary);color:#fff;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:600;">+ New Note</div>
                </div>
                <div class="preview-cards">
                    <div class="preview-card"><div style="font-size:12px;font-weight:600;color:var(--gray-900);margin-bottom:6px;">📌 Project Ideas</div><div style="font-size:11px;color:var(--gray-400);">Feature brainstorm for Q3 sprint planning...</div><div style="margin-top:10px;font-size:10px;color:var(--gray-400);">2 hours ago</div></div>
                    <div class="preview-card"><div style="font-size:12px;font-weight:600;color:var(--gray-900);margin-bottom:6px;">🎯 Weekly Goals</div><div style="font-size:11px;color:var(--gray-400);">Complete redesign by Friday deadline...</div><div style="margin-top:10px;font-size:10px;color:var(--gray-400);">Yesterday</div></div>
                    <div class="preview-card"><div style="font-size:12px;font-weight:600;color:var(--gray-900);margin-bottom:6px;">💡 Meeting Notes</div><div style="font-size:11px;color:var(--gray-400);">Discussed new product roadmap updates...</div><div style="margin-top:10px;font-size:10px;color:var(--gray-400);">3 days ago</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features">
    <div class="section-label">✨ Features</div>
    <h2 class="section-title">Everything you need to stay organized</h2>
    <p class="section-sub">Built for speed and simplicity — MyNotepad removes the friction between your thoughts and the page.</p>
    <div class="features-grid">
        <div class="feature-card"><div class="feature-icon">📝</div><div class="feature-title">Quick Note Taking</div><div class="feature-desc">Capture ideas instantly with our streamlined editor. Zero clutter, maximum focus on your content.</div></div>
        <div class="feature-card"><div class="feature-icon">🔒</div><div class="feature-title">Secure & Private</div><div class="feature-desc">Your notes belong to you. Every note is securely tied to your account with no data sharing.</div></div>
        <div class="feature-card"><div class="feature-icon">⚡</div><div class="feature-title">Lightning Fast</div><div class="feature-desc">Built on Laravel with optimized queries. Everything loads in milliseconds, always.</div></div>
        <div class="feature-card"><div class="feature-icon">📌</div><div class="feature-title">Pin & Organize</div><div class="feature-desc">Pin important notes to the top. Search through all your notes in real time with instant results.</div></div>
    </div>
</section>

<div class="cta-section">
    <div class="cta-banner">
        <h2>Start taking better notes today</h2>
        <p>Join and organize your thoughts in a beautifully designed workspace.</p>
        <div class="cta-btns">
            <a href="{{ route('register') }}" class="btn btn-white btn-lg">Create Account</a>
            <a href="{{ route('login') }}" class="btn btn-outline-white btn-lg">Sign In →</a>
        </div>
    </div>
</div>

<footer>
    <div style="display:flex;align-items:center;gap:10px;">
        <div style="width:28px;height:28px;background:var(--primary);border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:14px;">📝</div>
        <span style="font-size:15px;font-weight:700;color:var(--gray-900);">MyNotepad</span>
    </div>
    <div class="footer-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('login') }}">Sign In</a>
        <a href="{{ route('register') }}">Register</a>
    </div>
    <div style="font-size:13px;color:var(--gray-400);">© {{ date('Y') }} MyNotepad. All rights reserved.</div>
</footer>


</body>
</html>
