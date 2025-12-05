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
                                            <h4>Caption List
                                                <button type="button" class="btn btn-success waves-effect"
                                                    data-bs-toggle="modal" data-bs-target="#saveform-modal">Add</button>
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
                                        <div >
                                            <div class="table-responsive text-nowrap mt-0">
                                                @if (Session::has('success'))
                                                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                                                @endif
                                                @if (Session::has('error'))
                                                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                                                @endif
                                                <table class="table" id="dataTable"  cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No.</th>
                                                            <th>Caption Name</th>
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

    <div class="modal fade" id="saveform-modal" tabindex="-1" User="dialog">
        <div class="modal-dialog" User="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Add Form</h6>

                </div>
                <form id="saveform" enctype="multipart/form-data">

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label >Caption Name<span class="inputlabelmedetory">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect " data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light updatestatus">Save</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="updateform-modal" tabindex="-1" User="dialog">
        <div class="modal-dialog modal-lg" User="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Update Form</h6>

                </div>
                <form id="updateform" enctype="multipart/form-data">

                    <div class="modal-body">

                        <input type="hidden" class="form-control" id="id" name="id">
                        <div class="modal-body">

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label >Caption Name<span class="inputlabelmedetory">*</span></label>
                                        <input type="text" class="form-control name" id="name" name="name"
                                            required>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect "
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light updatestatus">Save</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

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
                        scrollY: "50vh",
                        scrollCollapse: false,
                        paging: true,
                        pageLength: 10,
                        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                        dom: 'Bfrtip',
                        buttons: [],
                        language: {
                            paginate: {
                                first: "First",
                                last: "Last",
                                next: "Next",
                                previous: "Previous"
                            }
                        },
                        "ajax": {
                            "url": "{{ route('user.caption.ajaxcall') }}",
                            "type": "GET",
                            "datatype": "json",
                            "data": function(d) {

                            }
                        },
                        columns: [{
                                data: 'id'
                            },
                            {
                                data: 'name',
                                orderable: false
                            },
                            {
                                data: 'date',
                                orderable: false
                            },
                            {
                                data: 'action',
                                orderable: false
                            },
                        ]
                    });

                    $('#saveform').validate({
                        rules: {},
                        messages: {},
                        submitHandler: function(form) {
                            $('.Description_error').remove();
                            $('#overlay').show();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: "{{ route('user.caption-save') }}",
                                dataType: "json",
                                type: "post",
                                data: new FormData(form),
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    $('#overlay').hide();
                                    $('.submit').removeAttr('disabled');
                                    if (response.status == 'success') {

                                        $('#saveform-modal').hide();
                                        $('#saveform').trigger('reset');

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success!',
                                            text: 'Saved Successfully.',
                                        }).then(function(result) {
                                            window.location.reload();
                                        });

                                    } else if (response.status == 'errors') {
                                        $('.Description_error').remove();
                                        $.each(response.message, function(i, message) {
                                            $('#' + i).after(
                                                '<span class="Description_error">' +
                                                message + '</span>');
                                        });
                                    } else if (response.status == 'error') {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error!',
                                            text: 'Please fill the required details',
                                            confirmButtonText: 'ok',
                                            timer: 1500
                                        })
                                    }
                                },
                            });
                            return false;
                        }
                    });

                    $('body').on('click', '.update', function() {
                        var id = $(this).attr('data-id');
                        $('#updateform-modal').modal('show');

                        $.ajax({
                            url: "{{ route('user.getcaption') }}",
                            dataType: "json",
                            type: "get",
                            data: {
                                'update': id
                            },
                            success: function(response) {

                                if (response.status == 'success') {

                                    $('#id').val(response.data.id);
                                    $('.name').val(response.data.caption_name);

                                } else if (response.status == 'error') {
                                    alert(response.message);
                                }

                            },
                        });

                    });

                    $('#updateform').validate({
                        rules: {},
                        messages: {},
                        submitHandler: function(form) {
                            $('.Description_error').remove();
                            $('#overlay').show();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: "{{ route('user.captionupdate') }}",
                                dataType: "json",
                                type: "get",
                                data: new FormData(form),
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    $('#overlay').hide();
                                    $('.submit').removeAttr('disabled');
                                    if (response.status == 'success') {

                                        $('#updateform-modal').hide();
                                        $('#updateform').trigger('reset');

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success!',
                                            text: 'Saved Successfully.',
                                        }).then(function(result) {
                                            window.location.reload();
                                        });

                                    } else if (response.status == 'errors') {
                                        $('.Description_error').remove();
                                        $.each(response.message, function(i, message) {
                                            $('#' + i).after(
                                                '<span class="Description_error">' +
                                                message + '</span>');
                                        });
                                    } else if (response.status == 'error') {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error!',
                                            text: 'Please fill the required details',
                                            confirmButtonText: 'ok',
                                            timer: 1500
                                        })
                                    }
                                },
                            });
                            return false;
                        }
                    });

                    $('body').on('click', '.delete', function() {

                        var id = $(this).attr('data-id');
                        if (confirm("Are you sure you want to delete this record?")) {

                            $('#overlay').show();

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: "{{ route('user.getcaption') }}",
                                dataType: "json",
                                type: "get",
                                data: {
                                    'delete': id
                                },
                                success: function(response) {
                                    $('#overlay').hide();

                                    if (response.status == 'success') {

                                        table.ajax.reload();

                                    } else if (response.status == 'error') {

                                        alert(response.message);

                                    } else if (response.status == 'exceptionError') {
                                        alert(response.error)
                                    }
                                },
                            });

                        }
                        return false;
                    });

                });
            </script>
        @endpush
    @endsection
