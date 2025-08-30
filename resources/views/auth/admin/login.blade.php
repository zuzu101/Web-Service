@extends('layouts.auth.common.app')

@section('content')
<div class="card shadow-lg border-0">
    <div class="card-body p-4 p-md-5">
        <div class="login-logo text-center mb-4">
            <h1 class="h3 fw-bold">Laptop<span class="text-primary">Service</span></h1>
            <p class="text-muted">Admin Panel Login</p>
        </div>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-floating mb-3">
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                <label for="email">
                    <i class="fas fa-envelope me-2"></i>Email address
                </label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-floating mb-4">
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                <label for="password">
                    <i class="fas fa-lock me-2"></i>Password
                </label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
