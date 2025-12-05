@extends('errors.layout')

@section('content')
    <div class="error-icon text-danger">
        <i class="fas fa-ban"></i>
    </div>
    <h1 class="error-code">403</h1>
    <h2 class="error-title">Forbidden</h2>
    <p class="error-message">
        You don't have permission to access this resource.
    </p>
    <div class="error-actions">
        <a href="{{ url('/') }}" class="btn btn-error btn-error-primary">
            <i class="fas fa-home me-2"></i> Go Home
        </a>
        <a href="javascript:history.back()" class="btn btn-error btn-error-secondary">
            <i class="fas fa-arrow-left me-2"></i> Go Back
        </a>
    </div>

    @if (auth()->check())
        <div class="mt-4">
            <p class="small">Logged in as: {{ auth()->user()->email }}</p>
        </div>
    @endif
@endsection
