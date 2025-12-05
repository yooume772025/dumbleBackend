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
                                            <h4>Panel Settings</h4>
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

                                            <form action="{{ route('user.webpanel-save') }}" method="POST" enctype="multipart/form-data">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="name">Logo </label>
                                                        <input type="file" name="logo" id="name"
                                                            class="form-control" placeholder="">
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="name">Favicon</label>
                                                        <input type="file" name="favicon" id="name"
                                                            class="form-control" placeholder="">
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
    @endpush

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.all.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>

        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('description');
        </script>
    @endpush
@endsection
