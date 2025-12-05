@extends('layouts.app')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid"></div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="side-content">
                    <div class="stats-container">
                        <div class="stat-card">
                            <a href="{{ route('user.info') }}" class="text-decoration-none">
                                <div class="inline-container">
                                    <div class="stat-icon text-info">
                                        <i class="bi bi-info-circle-fill"></i>
                                    </div>
                                    <div class="text-container">
                                        <div class="stat-number">Info Pages</div>
                                        <div class="stat-label">Manage Info</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="stat-card">
                            <a href="{{ route('user.google-addmob') }}" class="text-decoration-none">
                                <div class="inline-container">
                                    <div class="stat-icon text-warning">
                                        <i class="bi bi-google"></i>
                                    </div>
                                    <div class="text-container">
                                        <div class="stat-number">Google Admob</div>
                                        <div class="stat-label">Ad Settings</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="stat-card">
                            <a href="{{ route('user.panel-setting') }}" class="text-decoration-none">
                                <div class="inline-container">
                                    <div class="stat-icon text-success">
                                        <i class="bi bi-graph-up"></i>
                                    </div>
                                    <div class="text-container">
                                        <div class="stat-number">Images</div>
                                        <div class="stat-label">Logo & Favicon</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="stat-card">
                            <a href="{{ route('user.country') }}" class="text-decoration-none">
                                <div class="inline-container">
                                    <div class="stat-icon text-primary">
                                        <i class="bi bi-globe"></i>
                                    </div>
                                    <div class="text-container">
                                        <div class="stat-number">Twilio Country</div>
                                        <div class="stat-label">Manage Country Code</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="stat-card">
                            <a href="{{ route('user.web-settings') }}" class="text-decoration-none">
                                <div class="inline-container">
                                    <div class="stat-icon text-primary">
                                        <i class="bi bi-gear-fill"></i>
                                    </div>
                                    <div class="text-container">
                                        <div class="stat-number">Web Settings</div>
                                        <div class="stat-label">Manage Countries</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="stat-card">
                            <a href="{{ route('user.sms-settings') }}" class="text-decoration-none">
                                <div class="inline-container">
                                    <div class="stat-icon text-primary">
                                        <i class="bi bi-chat-dots-fill fs-2"></i>
                                    </div>
                                    <div class="text-container">
                                        <div class="stat-number fw-bold text-dark">Twilio SMS Settings</div>
                                        <div class="stat-label text-muted">Configure Twilio Messaging</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="stat-card">
                            <a href="{{ route('user.general-settings') }}" class="text-decoration-none">
                                <div class="inline-container">
                                    <div class="stat-icon text-primary">
                                        <i class="bi bi-gear-fill fs-2"></i>
                                    </div>
                                    <div class="text-container">
                                        <div class="stat-number fw-bold text-dark">General Settings</div>
                                        <div class="stat-label text-muted">Manage General Settings</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="stat-card">
                            <a href="{{ route('user.social-settings') }}" class="text-decoration-none">
                                <div class="inline-container">
                                    <div class="stat-icon text-primary">
                                        <i class="bi bi-gear-fill fs-2"></i>
                                    </div>
                                    <div class="text-container">
                                        <div class="stat-number fw-bold text-dark">Social Login Settings</div>
                                        <div class="stat-label text-muted">Manage Social Login Settings</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <div>
<div>
@endsection
