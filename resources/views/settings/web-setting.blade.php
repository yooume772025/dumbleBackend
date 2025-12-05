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
                                            <h4>Web Settings</h4>
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

                                            <form action="{{ route('user.webupdate') }}" method="POST">
                                                @csrf

                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="name">App Name</label>
                                                        <input type="text" name="name" id="name"
                                                            class="form-control" placeholder="Enter App Name" value="{{env('APP_NAME')}}" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="name">App URL</label>
                                                        <input type="text" name="url" id="name"
                                                            class="form-control" placeholder="Enter App Name" value="{{env('APP_URL')}}" required>
                                                    </div>
                                                </div>

                                                <div class="row">
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
@endsection
