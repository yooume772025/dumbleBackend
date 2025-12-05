@extends('errors.layout')

@section('content')
    <div class="error-icon text-warning">
        <i class="fas fa-exclamation-triangle"></i>
    </div>
    <h1 class="error-code">404</h1>
    <h2 class="error-title">Page Not Found</h2>
    <p class="error-message">
        The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
    </p>
    <div class="error-actions">
        <a href="{{ url('/') }}" class="btn btn-error btn-error-primary">
            <i class="fas fa-home me-2"></i> Go Home
        </a>
        <a href="javascript:history.back()" class="btn btn-error btn-error-secondary">
            <i class="fas fa-arrow-left me-2"></i> Go Back
        </a>
    </div>
@endsection
