@extends('errors.layout')

@section('content')
    <div class="error-icon text-danger">
        <i class="fas fa-clock"></i>
    </div>
    <h1 class="error-code">419</h1>
    <h2 class="error-title">Page Expired</h2>
    <p class="error-message">
        Your session has expired. Please refresh the page and try again.
    </p>
    <div class="error-actions">
        <a href="javascript:location.reload()" class="btn btn-error btn-error-primary">
            <i class="fas fa-sync-alt me-2"></i> Refresh Page
        </a>
        <a href="{{ url('/') }}" class="btn btn-error btn-error-secondary">
            <i class="fas fa-home me-2"></i> Go Home
        </a>
    </div>
@endsection
