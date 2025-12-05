<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Dumble Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ (request()->getHost() === 'localhost' || request()->getHost() === '127.0.0.1' || str_contains(request()->getHost(), '.local') || str_contains(request()->getHost(), '.test') || request()->getPort() === 8000 || request()->getPort() === 3000) ? asset('css/login-yellow.css') : asset('public/css/login-yellow.css') }}">
</head>
<body>
    <div class="floating-elements"></div>
    <div class="login-page">
        <div class="auth-wrapper">
            <div class="auth-inner fade-in">
                <h1 class="loginlogo">
                    {{ config('app.name', 'Dumble') }}
                </h1>
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">
                            <i class="fas fa-shield-alt me-2"></i>
                            Welcome back! Please sign in to access the admin panel
                        </p>
                        
                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" id="departmentForm" action="{{ route('admin.login') }}">
                            @csrf
                            <div id="loginmessage" class="d-none"></div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       placeholder="Enter your email address" 
                                       value="{{ old('email') }}"
                                       tabindex="1" 
                                       autofocus 
                                       required />
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label" for="password">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" 
                                           class="form-control form-control-merge @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           tabindex="2" 
                                           placeholder="Enter your password" 
                                           required />
                                    <span class="input-group-text cursor-pointer" id="toggle-password">
                                        <i class="fas fa-eye" id="toggle-icon"></i>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In to Admin Panel
                            </button>
                        </form>
                        
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Secure admin access with encrypted connection
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.all.min.js"></script>
    <script>
        var adminLoginUrl = "{{ route('admin.login') }}";
        var redirectUrl = "{{ route('user.dashboard') }}";
        
        // Password toggle functionality
        $(document).ready(function() {
            $('#toggle-password').on('click', function() {
                const passwordField = $('#password');
                const toggleIcon = $('#toggle-icon');
                
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
    <script src="{{ (request()->getHost() === 'localhost' || request()->getHost() === '127.0.0.1' || str_contains(request()->getHost(), '.local') || str_contains(request()->getHost(), '.test') || request()->getPort() === 8000 || request()->getPort() === 3000) ? asset('js/login.js') : asset('public/js/login.js') }}"></script>
</body>
</html>
