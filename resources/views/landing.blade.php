<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNotepad - Your thoughts, organized beautifully</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary:#4F46E5;--primary-hover:#4338CA;--primary-light:#EEF2FF;
            --gray-50:#F9FAFB;--gray-100:#F3F4F6;--gray-200:#E5E7EB;
            --gray-400:#9CA3AF;--gray-500:#6B7280;--gray-600:#4B5563;
            --gray-800:#1F2937;--gray-900:#111827;
            --radius:12px;--radius-sm:8px;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Inter',sans-serif;color:var(--gray-800);background:#fff;-webkit-font-smoothing:antialiased;}
        a{text-decoration:none;}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:var(--radius-sm);font-size:14px;font-weight:600;border:none;cursor:pointer;transition:all .2s ease;font-family:inherit;}
        .btn-primary{background:var(--primary);color:#fff;}
        .btn-primary:hover{background:var(--primary-hover);transform:translateY(-1px);box-shadow:0 4px 12px rgba(79,70,229,.35);}
        .btn-ghost{background:transparent;color:var(--gray-600);border:1.5px solid var(--gray-200);}
        .btn-ghost:hover{background:var(--gray-100);color:var(--gray-900);}
        .btn-lg{padding:14px 32px;font-size:16px;border-radius:var(--radius);}
        .btn-outline-white{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.4);}
        .btn-outline-white:hover{background:rgba(255,255,255,.1);}
        .btn-white{background:#fff;color:var(--primary);font-weight:700;}
        .btn-white:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.2);}

        /* Nav */
        .nav{position:fixed;top:0;left:0;right:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:0 40px;height:64px;background:rgba(255,255,255,.92);backdrop-filter:blur(12px);border-bottom:1px solid var(--gray-200);transition:box-shadow .3s;}
        .nav.scrolled{box-shadow:0 2px 20px rgba(0,0,0,.08);}
        .nav-logo{display:flex;align-items:center;gap:10px;}
        .nav-logo-icon{width:36px;height:36px;background:var(--primary);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:18px;}
        .nav-logo-text{font-size:18px;font-weight:700;color:var(--gray-900);}
        .nav-links{display:flex;align-items:center;gap:8px;}

        /* Hero */
        .hero{min-height:100vh;background:linear-gradient(135deg,#F9FAFB 0%,#EEF2FF 50%,#E0E7FF 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:120px 24px 80px;text-align:center;position:relative;overflow:hidden;}
        .hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 80% 50% at 50% -20%,rgba(79,70,229,.12) 0%,transparent 70%);}
        .hero-badge{display:inline-flex;align-items:center;gap:6px;background:var(--primary-light);color:var(--primary);border:1px solid rgba(79,70,229,.2);padding:6px 16px;border-radius:999px;font-size:13px;font-weight:600;margin-bottom:28px;animation:fadeUp .6s ease;}
        .hero-badge-dot{width:7px;height:7px;background:var(--primary);border-radius:50%;animation:pulse 2s infinite;}
        @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.6;transform:scale(1.4)}}
        .hero h1{font-size:clamp(40px,6vw,70px);font-weight:800;color:var(--gray-900);line-height:1.1;margin-bottom:24px;animation:fadeUp .7s ease;}
        .hero h1 span{color:var(--primary);}
        .hero p{font-size:clamp(16px,2vw,20px);color:var(--gray-600);max-width:560px;margin:0 auto 40px;line-height:1.7;animation:fadeUp .8s ease;}
        .hero-ctas{display:flex;gap:16px;flex-wrap:wrap;justify-content:center;margin-bottom:64px;animation:fadeUp .9s ease;}
        @keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}

        /* App Preview */
        .hero-preview{width:100%;max-width:900px;margin:0 auto;background:#fff;border-radius:16px;box-shadow:0 25px 80px rgba(79,70,229,.15),0 0 0 1px rgba(79,70,229,.08);overflow:hidden;animation:fadeUp 1s ease;position:relative;z-index:1;}
        .preview-topbar{background:var(--gray-50);border-bottom:1px solid var(--gray-200);padding:14px 20px;display:flex;align-items:center;gap:8px;}
        .preview-dot{width:12px;height:12px;border-radius:50%;}
        .preview-body{display:flex;min-height:300px;}
        .preview-sidebar{width:210px;background:var(--gray-50);border-right:1px solid var(--gray-200);padding:20px 16px;flex-shrink:0;}
        .preview-nav-item{display:flex;align-items:center;gap:10px;padding:8px 12px;border-radius:8px;font-size:13px;font-weight:500;color:var(--gray-600);margin-bottom:4px;}
        .preview-nav-item.active{background:var(--primary-light);color:var(--primary);}
        .preview-main{flex:1;padding:24px;}
        .preview-cards{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
        .preview-card{background:#fff;border:1px solid var(--gray-200);border-radius:10px;padding:14px;}

        /* Features */
        .features{padding:96px 24px;max-width:1100px;margin:0 auto;}
        .section-label{text-align:center;margin-bottom:16px;font-size:13px;font-weight:600;color:var(--primary);letter-spacing:.06em;text-transform:uppercase;}
        .section-title{text-align:center;font-size:clamp(28px,4vw,42px);font-weight:800;color:var(--gray-900);margin-bottom:16px;}
        .section-sub{text-align:center;font-size:16px;color:var(--gray-600);max-width:520px;margin:0 auto 64px;}
        .features-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:28px;}
        .feature-card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius);padding:32px 28px;transition:all .25s ease;}
        .feature-card:hover{border-color:var(--primary);box-shadow:0 4px 12px rgba(0,0,0,.08);transform:translateY(-4px);}
        .feature-icon{width:52px;height:52px;border-radius:14px;background:var(--primary-light);display:flex;align-items:center;justify-content:center;font-size:24px;margin-bottom:20px;transition:transform .2s;}
        .feature-card:hover .feature-icon{transform:scale(1.1);}
        .feature-title{font-size:17px;font-weight:700;color:var(--gray-900);margin-bottom:10px;}
        .feature-desc{font-size:14px;color:var(--gray-600);line-height:1.6;}

        /* CTA */
        .cta-section{max-width:1100px;margin:0 auto;padding:0 24px 96px;}
        .cta-banner{background:linear-gradient(135deg,#4F46E5 0%,#7C3AED 100%);border-radius:24px;padding:72px 48px;text-align:center;position:relative;overflow:hidden;}
        .cta-banner::before{content:'';position:absolute;top:-40%;right:-10%;width:400px;height:400px;background:rgba(255,255,255,.05);border-radius:50%;}
        .cta-banner h2{font-size:clamp(28px,4vw,42px);font-weight:800;color:#fff;margin-bottom:16px;}
        .cta-banner p{font-size:17px;color:rgba(255,255,255,.8);margin-bottom:36px;}
        .cta-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap;}

        /* Footer */
        footer{border-top:1px solid var(--gray-200);padding:32px 40px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;}
        .footer-links{display:flex;gap:24px;}
        .footer-links a{font-size:14px;color:var(--gray-500);transition:color .2s;}
        .footer-links a:hover{color:var(--primary);}

        @media(max-width:768px){
            .nav{padding:0 20px;}
            .hero{padding:100px 20px 60px;}
            .hero-ctas{flex-direction:column;align-items:center;}
            .preview-sidebar{display:none;}
            .preview-cards{grid-template-columns:1fr;}
            .cta-banner{padding:48px 24px;}
            .cta-btns{flex-direction:column;align-items:center;}
            footer{flex-direction:column;text-align:center;padding:24px 20px;}
            .footer-links{justify-content:center;}
        }
    </style>
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
            <a href="{{ route('login') }}" class="btn btn-ghost">Sign In</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Get Started Free</a>
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
            <a href="{{ route('register') }}" class="btn btn-white btn-lg">🚀 Create Free Account</a>
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

<script>
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => { navbar.classList.toggle('scrolled', window.scrollY > 10); });
</script>
</body>
</html>
