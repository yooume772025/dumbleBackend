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
                                            <h4>Banned or Suspended Accounts
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="page-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div>
                                            <div class="table-responsive text-nowrap mt-0">
                                                @if (Session::has('success'))
                                                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                                                @endif
                                                @if (Session::has('error'))
                                                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                                                @endif
                                                <table class="table" id="dataTable" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No.</th>
                                                            <th>User ID</th>
                                                            <th>Name</th>
                                                            <th>E-Mail</th>
                                                            <th>Mobile</th>
                                                            <th>Created On</th>
                                                            <th>Actions Taken</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
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


    <div class="modal fade" id="viewform-modal" tabindex="-1" aria-labelledby="userProfileModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">User Profile</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center mb-3">
                        <button class="btn btn-outline-secondary"><i class="bi bi-eye"></i> View Likes</button>
                        <button class="btn btn-outline-secondary"><i class="bi bi-eye-slash"></i> View Dislikes</button>
                        <button class="btn btn-outline-secondary"><i class="bi bi-images"></i> View Gallery</button>
                        <button class="btn btn-outline-secondary"><i class="bi bi-person-check"></i> View Match
                            Profile</button>
                    </div>

                    <div class="row my-5">
                        <div class="col-md-3 text-center">
                            <img src="../../dist/assets/img/user2-160x160.jpg" class="rounded-circle img-fluid"
                                alt="User Image">
                            <div class="mt-2">
                                <button class="btn btn-danger btn-sm">Suspend Account</button>
                                <button class="btn btn-warning btn-sm mt-2">Ban Account</button>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-6">
                                    <strong>Name:</strong>
                                    <input type="text" class="form-control" value="Rishabh Sharma" readonly>
                                </div>
                                <div class="col-6">
                                    <strong>Date of Birth:</strong>
                                    <input type="text" class="form-control" value="08-02-1999" readonly>
                                </div>
                                <div class="col-6 mt-2">
                                    <strong>Email:</strong>
                                    <input type="text" class="form-control" value="Rishabhsharma@gmail.com" readonly>
                                </div>
                                <div class="col-6 mt-2">
                                    <strong>Phone Number:</strong>
                                    <input type="text" class="form-control" value="3894759034" readonly>
                                </div>
                                <div class="col-6 mt-2">
                                    <strong>Job Title:</strong>
                                    <input type="text" class="form-control" value="Bank Manager" readonly>
                                </div>
                                <div class="col-6 mt-2">
                                    <strong>Company:</strong>
                                    <input type="text" class="form-control" value="Asian Bank" readonly>
                                </div>
                                <div class="col-6 mt-2">
                                    <strong>School:</strong>
                                    <input type="text" class="form-control" value="DAV public school" readonly>
                                </div>
                                <div class="col-6 mt-2">
                                    <strong>Country:</strong>
                                    <input type="text" class="form-control" value="India" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
<div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('public/vendors/css/extensions/sweetalert2.min.css') }}">
    @endpush
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.all.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {


                var table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": "{{ route('user.userbanned.ajaxcall') }}",
                        "type": "GET",
                        "datatype": "json",
                        "data": function(d) {

                        }
                    },
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'user_id',
                            orderable: false
                        },
                        {
                            data: 'name',
                            orderable: false
                        },
                        {
                            data: 'email',
                            orderable: false
                        },
                        {
                            data: 'mobile',
                            orderable: false
                        },
                        {
                            data: 'date',
                            orderable: false
                        },
                        {
                            data: 'Action',
                            orderable: false
                        },
                    ]
                });


                $('body').on('click', '.viewprofile', function() {
                    var id = $(this).attr('data-id');
                    $('#viewform-modal').modal('show');
                });

                $('body').on('click', '.unbanned', function() {
                    var id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('user.suspend-user') }}",
                        type: "GET",
                        data: {
                            'id': id,
                            'type': '1'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Saved Successfully.',
                                }).then(function(result) {
                                    window.location.reload();
                                });
                            } else {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'error!',
                                    text: 'No record found!.',
                                }).then(function(result) {
                                    window.location.reload();
                                });

                            }
                        }
                    });
                });

                $('body').on('click', '.delete', function() {

                    var id = $(this).attr('data-id');

                    $.ajax({
                        url: "{{ route('user.deleteById') }}",
                        type: "GET",
                        data: {
                            'id': id
                        },

                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Saved Successfully.',
                                }).then(function(result) {
                                    window.location.reload();
                                });
                            } else {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'error!',
                                    text: 'No record found!.',
                                }).then(function(result) {
                                    window.location.reload();
                                });

                            }
                        }

                    });

                });

            });
        </script>
    @endpush
@endsection
