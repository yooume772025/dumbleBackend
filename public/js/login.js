$(document).ready(function () {
    $('#toggle-password').on('click', function() {
        const passwordField = $('#password');
        const toggleIcon = $('#toggle-icon');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $("#departmentForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 6,
            },
        },
        messages: {
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address",
            },
            password: {
                required: "Please enter your password",
                minlength: "Password must be at least 6 characters",
            },
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.addClass("invalid-feedback");
            element.closest('.mb-3, .mb-4').append(error);
        },
        submitHandler: function (form) {
            $(".Description_error").remove();
            $("#overlay").show();

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            $.ajax({
                url: adminLoginUrl,
                dataType: "json",
                type: "post",
                data: new FormData(form),
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#overlay").hide();
                    $(".submit").removeAttr("disabled");

                    if (response.status == "success") {
                        if (response.status == "success") {
                            Swal.fire({
                                title: "Login Successful!",
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                toast: true,
                                customClass: {
                                    popup: "swal-custom-popup",
                                    title: "swal-custom-title",
                                    htmlContainer: "swal-custom-html",
                                },
                                didOpen: () => {
                                    $(".swal2-popup").css({
                                        width: "320px",
                                        "font-size": "16px",
                                        "border-bottom": "4px solid #28a745",
                                        "box-shadow":
                                            "0 0 8px rgba(0, 0, 0, 0.15)",
                                    });
                                },
                                didClose: () => {
                                    window.location.href = redirectUrl;
                                },
                            });
                        }
                    } else if (response.status == "errors") {
                        $(".Description_error").remove();
                        $.each(response.message, function (i, message) {
                            $("#" + i).after(
                                '<span class="Description_error">' +
                                    message +
                                    "</span>"
                            );
                        });
                    } else if (response.status == "error") {
                        $("#loginmessage").html(
                            '<span class="Description_error">' +
                                response.message +
                                "</span>"
                        );

                        Swal.fire({
                            title: "Login Failed",
                            text: "Invalid email or password. Please try again.",
                            icon: "error",
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            toast: true,
                            customClass: {
                                popup: "swal-custom-popup",
                                title: "swal-custom-title",
                                htmlContainer: "swal-custom-html",
                            },
                            didOpen: () => {
                                $(".swal2-popup").css({
                                    width: "350px",
                                    "font-size": "16px",
                                    "border-bottom": "4px solid #dc3545",
                                    "box-shadow": "0 0 8px rgba(0, 0, 0, 0.15)",
                                });
                            },
                        });
                    }
                },
            });

            return false;
        },
    });

    $("form").on("keypress", function (e) {
        var regex = new RegExp("^[a-zA-Z0-9_@&,. ]");
        var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (!regex.test(key)) {
            e.preventDefault();
            return false;
        }
    });
});
