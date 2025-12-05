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
                                            <h4>User Details</h4>
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

                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                                        data-bs-target="#nav-home" type="button" role="tab"
                                                        aria-controls="nav-home" aria-selected="true">Home</button>
                                                    <button class="nav-link" id="nav-likes-tab" data-bs-toggle="tab"
                                                        data-bs-target="#nav-likes" type="button" role="tab"
                                                        aria-controls="nav-likes" aria-selected="false">Likes</button>
                                                    <button class="nav-link" id="nav-dislikes-tab" data-bs-toggle="tab"
                                                        data-bs-target="#nav-dislikes" type="button" role="tab"
                                                        aria-controls="nav-dislikes" aria-selected="false">Dislikes</button>
                                                    <button class="nav-link" id="nav-gallery-tab" data-bs-toggle="tab"
                                                        data-bs-target="#nav-gallery" type="button" role="tab"
                                                        aria-controls="nav-gallery" aria-selected="false">Gallery</button>
                                                    <button class="nav-link" id="nav-match-profile-tab" data-bs-toggle="tab"
                                                        data-bs-target="#nav-match-profile" type="button" role="tab"
                                                        aria-controls="nav-match-profile" aria-selected="false">Match
                                                        Profile</button>
                                                </div>
                                            </nav>
                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                                    aria-labelledby="nav-home-tab">
                                                    <form action="{{ route('user.page-save') }}" method="POST"
                                                        id="pageDetailsForm">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label for="name">Name</label>
                                                                <input type="text" value="{{ $user->name ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="name">First Name</label>
                                                                <input type="text" value="{{ $user->first_name ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="name">Last Name</label>
                                                                <input type="text" value="{{ $user->last_name ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="name">Email</label>
                                                                <input type="text" value="{{ $user->email ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="name">Mobile</label>
                                                                <input type="text" value="{{ $user->mobile ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="name">DOB</label>
                                                                <input type="text" value="{{ $user->dob ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="name">Age</label>
                                                                <input type="text" value="{{ $user->age ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="name">Gender</label>
                                                                <input type="text"
                                                                    value="{{ $user->gender_id ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="name">height_id</label>
                                                                <input type="text"
                                                                    value="{{ $user->height_id ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="name">Language</label>
                                                                <input type="text" value="{{ $user->language ?? '' }}"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="zodaic_sign">Zodiac Sign</label>
                                                                <input type="text" value="{{ isset(
                                                                    $user->zodaic_sign) ? $user->zodaic_sign : '' }}" class="form-control">
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="looking_for">Looking For</label>
                                                                <input type="text" value="{{ is_array($user->looking_for) ? implode(', ', $user->looking_for) : $user->looking_for }}" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="description">About us</label>
                                                                <textarea name="description" id="description" class="form-control" placeholder="Enter Description">{!! $user->about_me ?? '' !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="tab-pane fade" id="nav-likes" role="tabpanel"
                                                    aria-labelledby="nav-likes-tab">
                                                    <div class="table-responsive text-nowrap mt-0">

                                                        <table class="table" id="dataTable" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>S.No.</th>
                                                                    <th>Name</th>
                                                                    <th>E-Mail</th>
                                                                    <th>Mobile</th>
                                                                    <th>Gender</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $series = 1;
                                                                @endphp
                                                                @foreach ($likeuser as $key => $item)
                                                                    <tr>
                                                                        <td>{{ $series++ }}</td>
                                                                        <td>{{ $item->name ?? '' }}</td>
                                                                        <td>{{ $item->email ?? '' }}</td>
                                                                        <td>{{ $item->mobile ?? '' }}</td>
                                                                        <td>{{ $item->gender_id ?? '' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="nav-dislikes" role="tabpanel"
                                                    aria-labelledby="nav-dislikes-tab">
                                                    <div class="table-responsive text-nowrap mt-0">

                                                        <table class="table" id="dataTable" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>S.No.</th>
                                                                    <th>Name</th>
                                                                    <th>E-Mail</th>
                                                                    <th>Mobile</th>
                                                                    <th>Gender</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $series = 1;
                                                                @endphp
                                                                @foreach ($dislikeuser as $key => $item)
                                                                    <tr>
                                                                        <td>{{ $series++ }}</td>
                                                                        <td>{{ $item->name ?? '' }}</td>
                                                                        <td>{{ $item->email ?? '' }}</td>
                                                                        <td>{{ $item->mobile ?? '' }}</td>
                                                                        <td>{{ $item->gender_id ?? '' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="nav-gallery" role="tabpanel"
                                                    aria-labelledby="nav-gallery-tab">
                                                    <div class="table-responsive text-nowrap mt-0">

                                                        <table class="table" id="dataTable" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>S.No.</th>
                                                                    <th>Image</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $series = 1;
                                                                @endphp
                                                                @foreach ($gallery as $key => $item)
                                                                    <tr>
                                                                        <td>{{ $series++ }}</td>
                                                                        <td>{{ asset($item->image_patg ?? '') }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>


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

    @push('styles')
        <link rel="stylesheet" href="{{ asset('public/vendors/css/extensions/sweetalert2.min.css') }}">
    @endpush

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.all.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
        <script>
            $(document).ready(function() {
                $('#pageDetailsForm').validate({
                    rules: {
                        name: {
                            required: true,
                            minlength: 3
                        },
                        description: {
                            required: true
                        }
                    },
                    messages: {
                        name: {
                            required: "Please enter a page name",
                            minlength: "Page name must be at least 3 characters long"
                        },
                        description: {
                            required: "Please enter a description"
                        }
                    },
                    submitHandler: function(form) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Form submitted successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            form.submit();
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
