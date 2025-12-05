@extends('errors.layout')

@section('content')
    <div class="error-icon animate__animated animate__shakeX">
        <i class="fas fa-server"></i>
    </div>
    <h1 class="error-code animate__animated animate__fadeIn">500</h1>
    <h2 class="error-title animate__animated animate__fadeIn">Server Meltdown</h2>
    <p class="error-message animate__animated animate__fadeIn animate__delay-1s">
        Our servers are currently doing the electric slide when they should be working.
        Our team of highly trained monkeys is on the case!
    </p>

    @if (app()->bound('sentry') && !empty(Sentry::getLastEventID()))
        <div class="my-4 text-sm text-gray-500 animate__animated animate__fadeIn animate__delay-2s">
            <p>Error ID: {{ Sentry::getLastEventID() }}</p>
        </div>
    @endif

    <div class="error-actions">
        <a href="javascript:location.reload()"
            class="btn-error btn-error-primary animate__animated animate__fadeInUp animate__delay-1s">
            <i class="fas fa-sync-alt me-2"></i> Try Again
        </a>
        <a href="{{ url('/') }}"
            class="btn-error btn-error-secondary animate__animated animate__fadeInUp animate__delay-1s">
            <i class="fas fa-home me-2"></i> Home Sweet Home
        </a>
    </div>
@endsection
