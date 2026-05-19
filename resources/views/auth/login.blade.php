<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — MyNotepad</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root{--primary:#4F46E5;--primary-hover:#4338CA;--primary-light:#EEF2FF;--danger:#EF4444;--gray-50:#F9FAFB;--gray-100:#F3F4F6;--gray-200:#E5E7EB;--gray-400:#9CA3AF;--gray-500:#6B7280;--gray-600:#4B5563;--gray-700:#374151;--gray-800:#1F2937;--gray-900:#111827;}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Inter',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#F9FAFB 0%,#EEF2FF 60%,#E0E7FF 100%);padding:24px;-webkit-font-smoothing:antialiased;}
        .auth-card{background:#fff;border-radius:20px;padding:48px;width:100%;max-width:440px;box-shadow:0 20px 60px rgba(79,70,229,.12),0 0 0 1px rgba(79,70,229,.06);}
        .auth-logo{display:flex;align-items:center;gap:10px;margin-bottom:32px;justify-content:center;}
        .auth-logo-icon{width:44px;height:44px;background:var(--primary);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;}
        .auth-logo-text{font-size:22px;font-weight:800;color:var(--gray-900);}
        .auth-title{font-size:26px;font-weight:800;color:var(--gray-900);margin-bottom:8px;text-align:center;}
        .auth-sub{font-size:15px;color:var(--gray-500);margin-bottom:36px;text-align:center;}
        .form-group{margin-bottom:20px;}
        .form-label{display:block;font-size:14px;font-weight:500;color:var(--gray-700);margin-bottom:8px;}
        .input-field{width:100%;padding:12px 16px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;font-family:inherit;color:var(--gray-800);background:#fff;transition:all .2s;outline:none;}
        .input-field:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(79,70,229,.12);}
        .input-field::placeholder{color:var(--gray-400);}
        .input-field.is-invalid{border-color:var(--danger);}
        .invalid-msg{color:var(--danger);font-size:12px;margin-top:6px;}
        .btn-submit{width:100%;padding:13px;background:var(--primary);color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:600;font-family:inherit;cursor:pointer;transition:all .2s;margin-top:8px;}
        .btn-submit:hover{background:var(--primary-hover);transform:translateY(-1px);box-shadow:0 4px 16px rgba(79,70,229,.35);}
        .btn-submit:active{transform:translateY(0);}
        .auth-footer{text-align:center;margin-top:24px;font-size:14px;color:var(--gray-500);}
        .auth-footer a{color:var(--primary);font-weight:600;text-decoration:none;}
        .auth-footer a:hover{text-decoration:underline;}
        .divider{display:flex;align-items:center;gap:12px;margin:24px 0;color:var(--gray-400);font-size:13px;}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--gray-200);}
        .remember-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;}
        .checkbox-label{display:flex;align-items:center;gap:8px;font-size:14px;color:var(--gray-600);cursor:pointer;}
        .checkbox-label input{accent-color:var(--primary);}
        .back-home{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--gray-400);text-decoration:none;margin-bottom:24px;transition:color .2s;}
        .back-home:hover{color:var(--primary);}
    </style>
</head>
<body>
    <div class="auth-card">
        <a href="{{ route('home') }}" class="back-home">← Back to home</a>
        <div class="auth-logo">
            <div class="auth-logo-icon">📝</div>
            <span class="auth-logo-text">MyNotepad</span>
        </div>
        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-sub">Sign in to your account to continue</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Email address</label>
                <input id="email" type="email" name="email" placeholder="you@example.com"
                    class="input-field {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    value="{{ old('email') }}" required autofocus>
                @error('email')<div class="invalid-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Enter your password"
                    class="input-field {{ $errors->has('password') ? 'is-invalid' : '' }}" required>
                @error('password')<div class="invalid-msg">{{ $message }}</div>@enderror
            </div>
            <div class="remember-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <button type="submit" class="btn-submit">Sign In →</button>
        </form>

        <div class="divider">or</div>
        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Create one free</a>
        </div>
    </div>
</body>
</html>
