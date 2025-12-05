<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('public/css/core.css') }}" />
<div class="header-admin">
    <nav class="app-header navbar navbar-expand bg-body ">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-fill"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">

                        <li class="user-footer">
                            <a href="{{ route('user.profile') }}" class="btn btn-default btn-flat">Profile</a>
                        </li>

                        <li class="logouttrigger">
                            <a href="javascript:void(0)" class="dropdown-item">
                                <i class="feather icon-log-out"></i> Logout
                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
