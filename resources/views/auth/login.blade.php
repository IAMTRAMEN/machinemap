@extends('layouts.app')

@section('title', 'Login - MK Gilze Africa')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f4f7fb 0%, #e9eef5 100%);
        font-family: 'Inter', sans-serif;
    }

    .login-container {
        
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        background: #ffffff;
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: translateY(-3px);
    }

    .card-header {
        
        border-bottom: none;

    }

    .card-header h4 {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .form-control {
        border-radius: 0.5rem;
        padding: 0.7rem 1rem;
    }

    .btn-primary {
        background: linear-gradient(90deg, #004aad, #0077cc);
        border: none;
        border-radius: 0.5rem;
        padding: 0.7rem 1rem;
        font-weight: 500;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(90deg, #003a88, #0060a8);
    }

    .card-footer {
        background: #f9fafc;
        border-top: none;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .brand-logo {
        width: 80px;
        height: auto;
        margin-bottom: 1rem;
    }

    .text-brand {
        color: #004aad;
        font-weight: 600;
    }
</style>

<div class="login-container">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header text-white text-center pt-4">
                <img src="{{ asset('storage/mk-logo.png') }}" alt="MK Gilze Africa" class="brand-logo">
                
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <small class="text-muted">© {{ date('Y') }} <span class="text-brand">MK Gilze Africa</span></small>
            </div>
        </div>
    </div>
</div>
@endsection
