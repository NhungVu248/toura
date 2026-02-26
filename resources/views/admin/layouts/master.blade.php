<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .sidebar {
            height: 100vh;
            background: #1e293b;
            color: white;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #334155;
            color: white;
        }

        .sidebar .active {
            background: #0d6efd;
            color: white !important;
        }

        .content-wrapper {
            padding: 20px;
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-2 sidebar p-3">
            <h4 class="text-white mb-4">Admin Panel</h4>

            <ul class="nav flex-column">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa fa-chart-line me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                       class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa fa-users me-2"></i> Người dùng
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.tours.index') }}"
                       class="nav-link">
                        <i class="fa fa-plane me-2"></i> Tours
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.booking') ?? '#' }}"
                       class="nav-link">
                        <i class="fa fa-book me-2"></i> Booking
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.contact') ?? '#' }}"
                       class="nav-link">
                        <i class="fa fa-envelope me-2"></i> Liên hệ
                    </a>
                </li>

            </ul>

            <hr>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger w-100">
                    <i class="fa fa-sign-out-alt me-2"></i> Đăng xuất
                </button>
            </form>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-10">

            <!-- TOP NAV -->
            <nav class="navbar navbar-light bg-white shadow-sm mb-3 px-3">
                <span class="navbar-brand mb-0 h5">
                    Xin chào, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                </span>
            </nav>

            <div class="content-wrapper">
                @yield('content')
            </div>

        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>