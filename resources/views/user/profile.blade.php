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
                                            <h4>Profile</h4>
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

                                            <form action="{{ route('user.profile-save') }}" method="POST">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="admin_name">Admin Name</label>
                                                        <input type="text" name="name"
                                                            value="{{ Auth::guard('user')->user()->name ?? 'Admin' }}"
                                                            id="admin_name" class="form-control" placeholder="Enter admin name">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="email">Email</label>
                                                        <input type="email" name="email" id="email"
                                                            value="{{ Auth::guard('user')->user()->email ?? '' }}"
                                                            class="form-control" placeholder="Enter admin email" readonly>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="new_password">New Password</label>
                                                        <div class="input-group">
                                                            <input type="password" name="new_password" id="new_password"
                                                                class="form-control" placeholder="Enter new password">
                                                            <span class="input-group-text cursor-pointer" id="toggle-new-password">
                                                                <i class="fas fa-eye" id="toggle-new-icon"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="confirm_password">Confirm Password</label>
                                                        <div class="input-group">
                                                            <input type="password" name="confirm_password" id="confirm_password"
                                                                class="form-control" placeholder="Confirm new password">
                                                            <span class="input-group-text cursor-pointer" id="toggle-confirm-password">
                                                                <i class="fas fa-eye" id="toggle-confirm-icon"></i>
                                                            </span>
                                                        </div>
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
                    <div id="styleSelector"></div>
                </div>
            </div>
        </div>

    </main>
<div>
<div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('public/vendors/css/extensions/sweetalert2.min.css') }}">
        <style>
            .cursor-pointer {
                cursor: pointer;
            }
            .input-group-text {
                background-color: #f8f9fa;
                border-left: 0;
            }
            .form-control:focus + .input-group-text {
                border-color: #80bdff;
            }
            .card {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                border: 1px solid rgba(0, 0, 0, 0.125);
            }
            .btn-primary {
                background-color: #ffd86c;
                border-color: #ffd86c;
                color: #000;
                font-weight: 600;
            }
            .btn-primary:hover {
                background-color: #ffcc33;
                border-color: #ffcc33;
                color: #000;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.all.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>

        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('description');
            
            // Password toggle functionality
            $(document).ready(function() {
                $('#toggle-new-password').on('click', function() {
                    const passwordField = $('#new_password');
                    const toggleIcon = $('#toggle-new-icon');
                    
                    if (passwordField.attr('type') === 'password') {
                        passwordField.attr('type', 'text');
                        toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        passwordField.attr('type', 'password');
                        toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });
                
                $('#toggle-confirm-password').on('click', function() {
                    const passwordField = $('#confirm_password');
                    const toggleIcon = $('#toggle-confirm-icon');
                    
                    if (passwordField.attr('type') === 'password') {
                        passwordField.attr('type', 'text');
                        toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        passwordField.attr('type', 'password');
                        toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });
            });
        </script>
    @endpush
@endsection
