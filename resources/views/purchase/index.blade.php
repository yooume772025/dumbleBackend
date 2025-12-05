<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Code Verification - Dumble</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ (request()->getHost() === 'localhost' || request()->getHost() === '127.0.0.1' || str_contains(request()->getHost(), '.local') || str_contains(request()->getHost(), '.test') || request()->getPort() === 8000 || request()->getPort() === 3000) ? asset('css/install.css') : asset('public/css/install.css') }}">
</head>

<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-4">
        <div class="installer-container fade-in w-100">
            <div class="installer-header">
                <h2><i class="fas fa-key me-2"></i> Purchase Code Verification</h2>
                <p class="mb-0 mt-2 opacity-75">Verify your CodeCanyon purchase code to continue</p>
            </div>

            <div class="installer-body">
                <div class="progress-container">
                    <div class="progress-line"></div>
                    <div class="row g-0">
                        <div class="col">
                            <div class="progress-step completed">
                                <div class="step-number">1</div>
                                <div class="step-title d-none d-sm-block">Introduction</div>
                                <div class="step-title d-block d-sm-none">Intro</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress-step completed">
                                <div class="step-number">2</div>
                                <div class="step-title d-none d-sm-block">Requirements</div>
                                <div class="step-title d-block d-sm-none">Check</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress-step completed">
                                <div class="step-number">3</div>
                                <div class="step-title d-none d-sm-block">Database</div>
                                <div class="step-title d-block d-sm-none">DB</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress-step completed">
                                <div class="step-number">4</div>
                                <div class="step-title d-none d-sm-block">Install</div>
                                <div class="step-title d-block d-sm-none">Install</div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress-step active">
                                <div class="step-number">5</div>
                                <div class="step-title d-none d-sm-block">Purchase</div>
                                <div class="step-title d-block d-sm-none">Purchase</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center py-4 fade-in">
                    <div class="welcome-icon mb-4">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Purchase Code Verification</h2>
                    <p class="text-muted mb-4">Please enter your CodeCanyon purchase code along with your username and email to complete the setup.</p>
                    
                    <div class="text-center">
                        <div class="alert alert-info">
                            <h5 class="mb-3">Where to find your purchase code:</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><strong>1.</strong> Log into your CodeCanyon account</li>
                                <li class="mb-2"><strong>2.</strong> Go to "Downloads" section</li>
                                <li class="mb-2"><strong>3.</strong> Find your Dumble purchase</li>
                                <li class="mb-0"><strong>4.</strong> Copy the purchase code</li>
                            </ul>
                        </div>
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

            <form method="POST" action="{{ route('purchase.store') }}" id="purchase-form">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <input 
                            type="text" 
                            class="form-control @error('username') is-invalid @enderror" 
                            id="username" 
                            name="username" 
                            placeholder="Enter your username..."
                            value="{{ old('username') }}"
                            required
                        >
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            placeholder="Enter your email address..."
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="purchase_code" class="form-label fw-semibold">Purchase Code</label>
                        <input 
                            type="text" 
                            class="form-control @error('purchase_code') is-invalid @enderror" 
                            id="purchase_code" 
                            name="purchase_code" 
                            placeholder="Enter your purchase code here..."
                            value="{{ old('purchase_code') }}"
                            required
                        >
                        @error('purchase_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle me-2"></i>
                    The purchase code will be verified securely with CodeCanyon. Your username and email will be stored for verification purposes.
                </div>
            </form>
        </div>

        <div class="installer-footer">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div></div>
                <button type="submit" form="purchase-form" class="btn btn-install">
                    <i class="fas fa-shield-alt me-2"></i> Verify Purchase Code
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>