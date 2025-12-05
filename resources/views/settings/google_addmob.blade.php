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
                                            <h4>Add Info Page</h4>
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

                                            <form action="{{ route('user.googleadd-save') }}" method="POST">
                                                @csrf

                                                <div class="row">

                                                    <div class="col-md-4 mb-3">
                                                        <label for="name">Google Select Device</label>
                                                        <select name="device" id="" class="form-control">
                                                            <option value="android">Android</option>
                                                            <option value="ios">IOS</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="app_id">AdMob App ID</label>
                                                        <input type="text" name="app_id" id="app_id"
                                                            class="form-control" placeholder="ca-app-pub-xxxxxxxxxxxxxxxx~xxxxxxxxxx">
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="banner_unit_id">Banner Ad Unit ID</label>
                                                        <input type="text" name="banner_unit_id" id="banner_unit_id"
                                                            class="form-control" placeholder="ca-app-pub-xxxxxxxxxxxxxxxx/xxxxxxxxxx">
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="interstitial_unit_id">Interstitial Ad Unit ID</label>
                                                        <input type="text" name="interstitial_unit_id" id="interstitial_unit_id"
                                                            class="form-control" placeholder="ca-app-pub-xxxxxxxxxxxxxxxx/xxxxxxxxxx">
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="rewarded_unit_id">Rewarded Ad Unit ID</label>
                                                        <input type="text" name="rewarded_unit_id" id="rewarded_unit_id"
                                                            class="form-control" placeholder="ca-app-pub-xxxxxxxxxxxxxxxx/xxxxxxxxxx">
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
