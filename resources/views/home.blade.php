@extends('layouts.app')

@section('content')
    <main class="app-main">
        <div class="app-content">
            <div class="container-fluid">
                <div class="dashboard-header mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h1 class="dashboard-title mb-1">
                                <i class="fas fa-tachometer-alt me-3 text-warning"></i>
                                Dashboard Overview
                            </h1>
                            <p class="dashboard-subtitle text-muted">Welcome back! Here's what's happening with your Dumble app.</p>
                        </div>
                        <div class="text-end">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span class="fw-medium">{{ date('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 rounded-4 bg-warning bg-opacity-75 text-dark h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3 display-5"><i class="fas fa-users"></i></div>
                                <div>
                                    <div class="fs-3 fw-bold">{{ $user ?? '0' }}</div>
                                    <div class="fs-6">Total Users</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 rounded-4 bg-warning bg-opacity-50 text-dark h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3 display-5"><i class="fas fa-user-check"></i></div>
                                <div>
                                    <div class="fs-3 fw-bold">{{ $activeuser ?? '0' }}</div>
                                    <div class="fs-6">Active Users</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 rounded-4 bg-warning bg-opacity-25 text-dark h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3 display-5"><i class="fas fa-user-times"></i></div>
                                <div>
                                    <div class="fs-3 fw-bold">{{ $inactiveuser ?? '0' }}</div>
                                    <div class="fs-6">Inactive Users</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 rounded-4 bg-warning bg-opacity-100 text-dark h-100">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-3 display-5"><i class="fas fa-user-shield"></i></div>
                                <div>
                                    <div class="fs-3 fw-bold">{{ $verifyuser ?? '0' }}</div>
                                    <div class="fs-6">Verified Users</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="side-content">
                    <div class="stats-container">
                        <div class="stat-card fade-in">
                            <a href="{{ route('user.dashboard') }}#revenue" class="text-decoration-none">
                                <div class="inline-container">
                                    <div class="stat-icon text-success">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="text-container">
                                        <div class="stat-number">${{ number_format($totalrevenue ?? 0, 2) }}</div>
                                        <div class="stat-label">Total Revenue</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="stat-card fade-in">
                            <a href="{{ route('user.dashboard') }}#monthly-revenue" class="text-decoration-none">
                                <div class="inline-container">
                                    <div class="stat-icon text-info">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="text-container">
                                        <div class="stat-number">${{ number_format($currentMonthRevenue ?? 0, 2) }}</div>
                                        <div class="stat-label">Monthly Revenue</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="stat-card fade-in">
                            <a href="{{ route('user.dashboard') }}#admob-revenue" class="text-decoration-none">
                                <div class="inline-container">
                                    <div class="stat-icon text-warning">
                                        <i class="fab fa-google"></i>
                                    </div>
                                    <div class="text-container">
                                        <div class="stat-number">${{ number_format($revenueData ?? 0, 2) }}</div>
                                        <div class="stat-label">AdMob Revenue</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection