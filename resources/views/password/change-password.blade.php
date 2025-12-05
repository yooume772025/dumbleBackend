<!DOCTYPE html>
<html class="loading " lang="en" data-textdirection="ltr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="csrf-token" content="Tq5tKjoHV8CJV9dhuSqQViKZEkLmZanCgLXEAVW5">

    <title>Change Password - DumbleApp</title>
    <link rel="apple-touch-icon" href="images/ico/favicon-32x32.png">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/base/themes/dark-layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/base/themes/bordered-layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/base/themes/semi-dark-layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/vendors/css/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/base/plugins/extensions/ext-component-toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('public/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/base/pages/authentication.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/overrides.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}" />
</head>

<body class="vertical-layout vertical-menu-modern    blank-page" data-menu="vertical-menu-modern" data-col="blank-page"
    data-framework="laravel">

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <h2> Dumble</h2>
                <div class="auth-wrapper auth-basic px-2">
                    <div class="auth-inner my-2">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="brand-logo">

                                    <h2 class="brand-text text-primary ms-1">Change Password</h2>
                                </a>
                                <p class="card-text mb-2">Provide e-mail to access admin panel</p>

                                <form method="POST" id="departmentForm">
                                    {!! csrf_field() !!}
                                    <label id="loginmessage"></label>

                                    <div class="mb-1 mt-1">
                                        <label for="login-email" class="form-label">Email</label>
                                        <input type="text" class="form-control " id="email" name="email"
                                            placeholder="admin@dumbleapp.in" tabindex="1" autofocus />
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100" tabindex="4">Change</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#departmentForm').validate({
                rules: {
                    email: {
                        required: true
                    },
                },
                messages: {
                    email: {
                        required: 'The User Email field is required'
                    },
                },
                submitHandler: function(form) {

                    $('.Description_error').remove();

                    $('#overlay').show();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ url('api/change/password') }}",
                        dataType: "json",
                        type: "post",
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#overlay').hide();
                            $('.submit').removeAttr('disabled');
                            if (response.status == 'success') {

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Login Successfully ',
                                    confirmButtonText: 'Proceed',
                                }).then(function(result) {
                                    if (result.isConfirmed) {
                                        window.location.href =
                                            "{{ route('user.index') }}"
                                    }
                                });

                            } else if (response.status == 'errors') {
                                $('.Description_error').remove();
                                $.each(response.message, function(i, message) {
                                    $('#' + i).after(
                                        '<span class="Description_error" >' +
                                        message + '</span>');
                                });
                            } else if (response.status == 'error') {
                                $('#loginmessage').html(
                                    '<span class="Description_error" >' + response
                                    .message + '</span>');

                                Swal.fire({

                                    icon: 'error',

                                    title: 'Error!',

                                    text: 'Invalid Credentials',

                                    confirmButtonText: 'ok',

                                    timer: 1500

                                })

                            }
                        },
                    });

                    return false;
                }
            });

            $('form').on('keypress', function(e) {
                var regex = new RegExp("^[a-zA-Z0-9_@&,. ]");
                var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (!regex.test(key)) {
                    e.preventDefault();
                    return false;
                }
            });

        });
    </script>


</body>

</html>
