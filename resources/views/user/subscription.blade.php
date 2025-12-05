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
                                            <h4>User Subscription
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
                                                            <th>Name</th>
                                                            <th>E-Mail</th>
                                                            <th>Amount</th>
                                                            <th>Payment Method</th>
                                                            <th>Status</th>
                                                            <th>Is Active</th>
                                                            <th>Duration</th>
                                                            <th>Start Date</th>
                                                            <th>Expiry Date</th>
                                                            <th>Created On</th>
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
                        "url": "{{ route('user.user-subscription-ajaxcall') }}",
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
                            data: 'email',
                            orderable: false
                        },
                        {
                            data: 'amount',
                            orderable: false
                        },
                        {
                            data: 'payment_method',
                            orderable: false
                        },
                        {
                            data: 'status',
                            orderable: false
                        },
                        {
                            data: 'is_current',
                            orderable: false
                        },
                        {
                            data: 'duration',
                            orderable: false
                        },
                        {
                            data: 'start_date',
                            orderable: false
                        },
                        {
                            data: 'end_date',
                            orderable: false
                        },
                        {
                            data: 'date',
                            orderable: false
                        },
                    ]
                });

            });
        </script>
    @endpush
@endsection
