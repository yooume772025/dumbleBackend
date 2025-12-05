<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dumble Installation Wizard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ (request()->getHost() === 'localhost' || request()->getHost() === '127.0.0.1' || str_contains(request()->getHost(), '.local') || str_contains(request()->getHost(), '.test') || request()->getPort() === 8000 || request()->getPort() === 3000) ? asset('css/install.css') : asset('public/css/install.css') }}">
</head>

<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-4">
        <div class="installer-container fade-in w-100">
            <div class="installer-header">
                <h2><i class="fas fa-magic me-2"></i> Dumble Installation Wizard</h2>
                <p class="mb-0 mt-2 opacity-75">Complete setup in just a few steps</p>
            </div>

            <div class="installer-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="progress-container">
                    <div class="progress-line"></div>
                    <div class="row g-0">
                        <div class="col">
                            <div class="progress-step {{ $step >= 1 ? ($step > 1 ? 'completed' : 'active') : '' }}">
                                <div class="step-number">1</div>
                                <div class="step-title d-none d-sm-block">Introduction</div>
                                <div class="step-title d-block d-sm-none">Intro</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress-step {{ $step >= 2 ? ($step > 2 ? 'completed' : 'active') : '' }}">
                                <div class="step-number">2</div>
                                <div class="step-title d-none d-sm-block">Requirements</div>
                                <div class="step-title d-block d-sm-none">Check</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress-step {{ $step >= 3 ? ($step > 3 ? 'completed' : 'active') : '' }}">
                                <div class="step-number">3</div>
                                <div class="step-title d-none d-sm-block">Database</div>
                                <div class="step-title d-block d-sm-none">DB</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress-step {{ $step >= 4 ? ($step > 4 ? 'completed' : 'active') : '' }}">
                                <div class="step-number">4</div>
                                <div class="step-title d-none d-sm-block">Install</div>
                                <div class="step-title d-block d-sm-none">Install</div>
                            </div>
                        </div>
                        @if(!(request()->getHost() === 'localhost' || request()->getHost() === '127.0.0.1' || str_contains(request()->getHost(), '.local') || str_contains(request()->getHost(), '.test') || request()->getPort() === 8000 || request()->getPort() === 3000))
                        <div class="col">
                            <div class="progress-step {{ $step >= 5 ? 'completed' : '' }}">
                                <div class="step-number">5</div>
                                <div class="step-title d-none d-sm-block">Purchase</div>
                                <div class="step-title d-block d-sm-none">Purchase</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

                @if ($step == 1)
                    <div class="text-center py-4 fade-in">
                        <div class="welcome-icon mb-4">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h2 class="fw-bold mb-3">Welcome to Dumble Installation</h2>
                        <p class="text-muted mb-4">This wizard will guide you through the installation process. Please have the following ready:</p>
                        
                        <div class="text-center">
                            <div class="alert alert-warning">
                                <h5 class="mb-3">What you'll need:</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><strong>Database Credentials:</strong> MySQL database name, username, and password</li>
                                    <li class="mb-2"><strong>Server Requirements:</strong> PHP 8.0+ with required extensions</li>
                                    <li class="mb-0"><strong>File Permissions:</strong> Writable storage and cache directories</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @elseif($step == 2)
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="mb-4 fw-bold">Server Requirements</h4>
                            <div class="mb-4">
                                @foreach ($requirements as $key => $value)
                                    <div class="requirement-item {{ $value ? 'valid' : 'invalid' }} mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas {{ $value ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }} me-3 requirement-status-icon"></i>
                                            <div class="flex-grow-1">
                                                <strong class="d-block">{{ $key }}</strong>
                                                <small class="text-muted">{{ $value ? 'Available' : 'Missing' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <h4 class="mb-4 fw-bold">Directory Permissions</h4>
                            <div class="mb-4">
                                <div class="requirement-item {{ $permissions['storage'] ? 'valid' : 'invalid' }} mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas {{ $permissions['storage'] ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }} me-3 requirement-status-icon"></i>
                                        <div class="flex-grow-1">
                                            <strong class="d-block">storage/ directory writable</strong>
                                            <small class="text-muted">{{ $permissions['storage'] ? 'Writable' : 'Not writable' }}</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="requirement-item {{ $permissions['cache'] ? 'valid' : 'invalid' }} mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas {{ $permissions['cache'] ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }} me-3 requirement-status-icon"></i>
                                        <div class="flex-grow-1">
                                            <strong class="d-block">bootstrap/cache/ directory writable</strong>
                                            <small class="text-muted">{{ $permissions['cache'] ? 'Writable' : 'Not writable' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($step == 3)
                    <h4 class="mb-4 fw-bold">Database Configuration</h4>
                    <p class="text-muted mb-4">Please provide your database connection details.</p>

                    <form method="POST" action="{{ route('install.step') }}" id="install-form">
                        @csrf
                        <input type="hidden" name="step" value="3">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="db_host" class="form-label fw-semibold">Database Host</label>
                                <input type="text" class="form-control" id="db_host" name="db_host" value="localhost" required>
                            </div>

                            <div class="col-md-6">
                                <label for="db_database" class="form-label fw-semibold">Database Name</label>
                                <input type="text" class="form-control" id="db_database" name="db_database" required>
                            </div>

                            <div class="col-md-6">
                                <label for="db_username" class="form-label fw-semibold">Database Username</label>
                                <input type="text" class="form-control" id="db_username" name="db_username" required>
                            </div>

                            <div class="col-md-6">
                                <label for="db_password" class="form-label fw-semibold">Database Password</label>
                                <input type="password" class="form-control" id="db_password" name="db_password">
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="mb-3 fw-bold">Admin Account Setup</h5>
                                <p class="text-muted mb-3">Create your admin account to access the admin panel after installation.</p>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="admin_name" class="form-label fw-semibold">Admin Name</label>
                                <input type="text" class="form-control" id="admin_name" name="admin_name" value="{{ old('admin_name', 'Admin') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="admin_email" class="form-label fw-semibold">Admin Email</label>
                                <input type="email" class="form-control" id="admin_email" name="admin_email" value="{{ old('admin_email') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="admin_password" class="form-label fw-semibold">Admin Password</label>
                                <input type="password" class="form-control" id="admin_password" name="admin_password" required minlength="8">
                                <div class="form-text">Password must be at least 8 characters long</div>
                            </div>

                            <div class="col-md-6">
                                <label for="admin_password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                                <input type="password" class="form-control" id="admin_password_confirmation" name="admin_password_confirmation" required>
                            </div>
                        </div>
                    </form>
                @elseif($step == 4)
                    <h4 class="mb-4 fw-bold">Ready to Install</h4>
                    <p class="text-muted mb-4">Database connection successful! Click the button below to start the installation process.</p>

                    <div class="alert alert-success mt-4">
                        <h5 class="mb-3">Installation will perform the following steps:</h5>
                        <ul class="mb-0">
                            <li class="mb-1">Creating database tables</li>
                            <li class="mb-1">Running database migrations</li>
                            <li class="mb-1">Seeding initial data</li>
                            <li class="mb-1">Setting up admin user</li>
                            <li class="mb-0">Finalizing installation</li>
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('install.step') }}" id="install-form">
                        @csrf
                        <input type="hidden" name="step" value="4">
                        <input type="hidden" name="db_host" value="{{ old('db_host', request('db_host')) }}">
                        <input type="hidden" name="db_database" value="{{ old('db_database', request('db_database')) }}">
                        <input type="hidden" name="db_username" value="{{ old('db_username', request('db_username')) }}">
                        <input type="hidden" name="db_password" value="{{ old('db_password', request('db_password')) }}">
                        <input type="hidden" name="admin_name" value="{{ old('admin_name', request('admin_name')) }}">
                        <input type="hidden" name="admin_email" value="{{ old('admin_email', request('admin_email')) }}">
                        <input type="hidden" name="admin_password" value="{{ old('admin_password', request('admin_password')) }}">
                        <input type="hidden" name="admin_password_confirmation" value="{{ old('admin_password_confirmation', request('admin_password_confirmation')) }}">
                    </form>
                @elseif($step == 5)
                    @if(request()->getHost() === 'localhost' || request()->getHost() === '127.0.0.1' || str_contains(request()->getHost(), '.local') || str_contains(request()->getHost(), '.test') || request()->getPort() === 8000 || request()->getPort() === 3000)
                        <h4 class="mb-4 fw-bold">Installation Complete</h4>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Localhost Detected:</strong> Purchase code verification is not required on localhost. 
                            Your installation is complete and you can now access the admin panel.
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('login') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Go to Login
                            </a>
                        </div>
                    @else
                        <h4 class="mb-4 fw-bold">Purchase Code Verification</h4>
                        <p class="text-muted mb-4">Please enter your CodeCanyon purchase code to complete the installation.</p>

                        <form method="POST" action="{{ route('purchase.store') }}" id="purchase-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="username" class="form-label fw-semibold">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="col-12">
                                    <label for="purchase_code" class="form-label fw-semibold">Purchase Code</label>
                                    <input type="text" class="form-control" id="purchase_code" name="purchase_code" required>
                                    <div class="form-text">You can find your purchase code in your CodeCanyon downloads page.</div>
                                </div>
                            </div>

                            <div class="alert alert-warning mt-4">
                                <h5 class="mb-3">Where to find your purchase code:</h5>
                                <ol class="mb-0">
                                    <li class="mb-1">Log in to your CodeCanyon account</li>
                                    <li class="mb-1">Go to your <strong>Downloads</strong> page</li>
                                    <li class="mb-1">Find this item in your downloads list</li>
                                    <li class="mb-0"><strong>Copy the purchase code</strong></li>
                                </ol>
                            </div>
                        </form>
                    @endif
                @endif
            </div>

            <div class="installer-footer">
                <div class="d-flex justify-content-between align-items-center w-100">
                    @if ($step > 1 && $step < 6)
                        <a href="{{ route('install.index') }}?step={{ $step - 1 }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if ($step == 1)
                        <form method="POST" action="{{ route('install.step') }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="step" value="2">
                            <button type="submit" class="btn btn-install">
                                Next <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                    @elseif($step == 2 && $allRequirementsMet)
                        <form method="POST" action="{{ route('install.step') }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="step" value="3">
                            <button type="submit" class="btn btn-install">
                                Next <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                    @elseif($step == 3)
                        <button type="submit" form="install-form" class="btn btn-install">
                            <i class="fas fa-download me-2"></i> Install Now
                        </button>
                    @elseif($step == 4)
                        <button type="submit" form="install-form" class="btn btn-install">
                            <i class="fas fa-download me-2"></i> Start Installation
                        </button>
                    @elseif($step == 5)
                        <button type="submit" form="purchase-form" class="btn btn-install">
                            <i class="fas fa-key me-2"></i> Verify & Complete
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
