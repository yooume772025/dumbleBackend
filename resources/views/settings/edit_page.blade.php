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

                                            <form action="{{ route('user.page-update') }}" method="POST">
                                                @csrf

                                                <input type="hidden" name="id" value="{{ $page->id ?? '' }}">
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="name">Page Name</label>
                                                        <input type="text" name="name" value="{{ $page->name ?? '' }}"
                                                            id="name" class="form-control"
                                                            placeholder="Enter Page Name">
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="description">Description</label>
                                                        <textarea name="description" id="description" class="form-control" placeholder="Enter Description">{!! $page->description !!}</textarea>
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
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
