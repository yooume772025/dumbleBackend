@extends('layouts.app')
@section('content')
    <main class="app-main p-3">

        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="page-header">
                            <div class="row align-items-end">
                                <div class="col-lg-8">
                                    <div class="page-header-title">
                                        <div class="d-inline">
                                            <h4>Twilio SMS Settings</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="page-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">

                                            @if (Session::has('success'))
                                                <div class="alert alert-success">{{ Session::get('success') }}</div>
                                            @endif
                                            @if (Session::has('error'))
                                                <div class="alert alert-danger">{{ Session::get('error') }}</div>
                                            @endif

                                            <form action="{{ route('user.sms-update') }}" method="POST">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="name">Twilio SID</label>
                                                        <input type="text" name="twilwo_sid" id="name"
                                                            class="form-control" placeholder="Enter App Name"
                                                            value="{{ env('TWILIO_SID') }}" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="name">Twilio AUTH TOKEN</label>
                                                        <input type="text" name="twileo_auth" id="name"
                                                            class="form-control" placeholder="Enter App Name"
                                                            value="{{ env('TWILIO_AUTH_TOKEN') }}" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="name">Twilio FROM (twilio phone)</label>
                                                        <input type="text" name="twileo_phone" id="name"
                                                            class="form-control" placeholder="Enter App Name"
                                                            value="{{ env('TWILIO_FROM') }}" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="twilio_demo_mode"
                                                                id="twilio_demo_mode" value="1"
                                                                {{ env('TWILIO_DEMO_MODE') == 'true' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="twilio_demo_mode">
                                                                Demo Mode (Always send OTP: 123456)
                                                            </label>
                                                        </div>
                                                        <small class="form-text text-muted">
                                                            When enabled, all OTPs will be 123456 (no real SMS sent)
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </main>
    <div>
<div>
@endsection
