@extends('layouts.guest')

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card-header">
                <!-- SVG Logo from the original Shadcn component -->
                <svg class="auth-logo" fill="currentColor" viewBox="0 0 40 48">
                    <clipPath id="a"><path d="m0 0h40v48h-40z" /></clipPath>
                    <g clipPath="url(#a)">
                        <path d="m25.0887 5.05386-3.933-1.05386-3.3145 12.3696-2.9923-11.16736-3.9331 1.05386 3.233 12.0655-8.05262-8.0526-2.87919 2.8792 8.83271 8.8328-10.99975-2.9474-1.05385625 3.933 12.01860625 3.2204c-.1376-.5935-.2104-1.2119-.2104-1.8473 0-4.4976 3.646-8.1436 8.1437-8.1436 4.4976 0 8.1436 3.646 8.1436 8.1436 0 .6313-.0719 1.2459-.2078 1.8359l10.9227 2.9267 1.0538-3.933-12.0664-3.2332 11.0005-2.9476-1.0539-3.933-12.0659 3.233 8.0526-8.0526-2.8792-2.87916-8.7102 8.71026z" />
                        <path d="m27.8723 26.2214c-.3372 1.4256-1.0491 2.7063-2.0259 3.7324l7.913 7.9131 2.8792-2.8792z" />
                        <path d="m25.7665 30.0366c-.9886 1.0097-2.2379 1.7632-3.6389 2.1515l2.8794 10.746 3.933-1.0539z" />
                        <path d="m21.9807 32.2274c-.65.1671-1.3313.2559-2.0334.2559-.7522 0-1.4806-.102-2.1721-.2929l-2.882 10.7558 3.933 1.0538z" />
                        <path d="m17.6361 32.1507c-1.3796-.4076-2.6067-1.1707-3.5751-2.1833l-7.9325 7.9325 2.87919 2.8792z" />
                        <path d="m13.9956 29.8973c-.9518-1.019-1.6451-2.2826-1.9751-3.6862l-10.95836 2.9363 1.05385 3.933z" />
                    </g>
                </svg>
                <h2 class="auth-title">Create an account</h2>
                <p class="auth-description">Welcome! Create an account to get started.</p>
            </div>
            
            <div class="auth-card-content">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div class="auth-form-group">
                            <label class="auth-label" for="name">Full name</label>
                            <input class="auth-input {{ $errors->has('name') ? 'has-error' : '' }}" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                            @error('name')<div class="auth-error-message">{{ $message }}</div>@enderror
                        </div>

                        <div class="auth-form-group">
                            <label class="auth-label" for="email">Email address</label>
                            <input class="auth-input {{ $errors->has('email') ? 'has-error' : '' }}" id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com">
                            @error('email')<div class="auth-error-message">{{ $message }}</div>@enderror
                        </div>

                        <div class="auth-form-group">
                            <label class="auth-label" for="password">Password</label>
                            <div class="auth-input-wrapper">
                                <input class="auth-input {{ $errors->has('password') ? 'has-error' : '' }}" id="password" type="password" name="password" style="padding-right: 2.5rem;" required placeholder="••••••••">
                                <button type="button" class="auth-password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                                    <i class="fa-regular fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password')<div class="auth-error-message">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="auth-form-group">
                            <label class="auth-label" for="password_confirmation">Confirm Password</label>
                            <div class="auth-input-wrapper">
                                <input class="auth-input" id="password_confirmation" type="password" name="password_confirmation" style="padding-right: 2.5rem;" required placeholder="••••••••">
                                <button type="button" class="auth-password-toggle" id="toggleConfirmPassword" aria-label="Toggle confirm password visibility">
                                    <i class="fa-regular fa-eye" id="confirmEyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="auth-checkbox-wrapper">
                            <input type="checkbox" id="terms" class="auth-checkbox" required>
                            <label for="terms" class="auth-checkbox-label">
                                I agree to the <a href="#" class="auth-link">Terms</a> and <a href="#" class="auth-link">Conditions</a>
                            </label>
                        </div>

                        <button type="submit" class="auth-button">Create free account</button>
                    </div>
                </form>
            </div>
            
            <div class="auth-card-footer">
                <p class="auth-footer-text">
                    Already have an account? <a href="{{ route('login') }}" class="auth-link">Log in</a>
                </p>
            </div>
        </div>
    </div>
@endsection
