@extends('errors.layout')

@section('content')
    <div class="error-icon text-info">
        <i class="fas fa-tools"></i>
    </div>
    <h1 class="error-code">503</h1>
    <h2 class="error-title">Service Unavailable</h2>
    <p class="error-message">
        We're currently undergoing maintenance. Please check back soon.
    </p>
    <div class="error-actions">
        <a href="javascript:location.reload()" class="btn btn-error btn-error-primary">
            <i class="fas fa-sync-alt me-2"></i> Try Again
        </a>
        <a href="{{ url('/') }}" class="btn btn-error btn-error-secondary">
            <i class="fas fa-home me-2"></i> Go Home
        </a>
    </div>

    @isset($exception)
        @if (config('app.debug'))
            <p id="toggleDetails" class="show-details" onclick="toggleDetails()">
                <i class="fas fa-chevron-down me-1"></i> Show Details
            </p>
            <div id="errorDetails" class="error-details">
                {{ $exception->getMessage() }}
            </div>
        @endif
    @endisset
@endsection
