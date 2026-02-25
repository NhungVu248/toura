{{-- resources/views/admin/blocks/sidebar.blade.php --}}
@php $admin = Auth::guard('admin')->user(); @endphp

<div class="col-md-3 left_col">
    <div class="left_col scroll-view">

        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('admin.dashboard') }}" class="site_title"><i class="fa fa-paw"></i> <span>Admin Panel</span></a>
        </div>

        <div class="clearfix"></div>

        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ asset('admin/assets/images/user-profile/avt_admin.jpg') }}" alt="avatar" class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Xin chào,</span>
                <h2>{{ $admin->name ?? 'Admin' }}</h2>
            </div>
        </div>

        <br />

        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>TỔNG QUAN</h3>
                <ul class="nav side-menu">
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>

                    <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}"><i class="fa fa-user"></i> Quản lý người dùng</a>
                    </li>

                    <li class="{{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-users"></i> Quản lý Admin</a>
                    </li>

                    <li class="{{ request()->routeIs('admin.tours*') ? 'active' : '' }}">
                        <a><i class="fa fa-plane"></i> Quản lý Tours <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="{{ request()->routeIs('admin.tours*') ? 'display:block;' : '' }}">
                            <li class="{{ request()->routeIs('admin.page-add-tours') ? 'current-page' : '' }}">
                                <a href="{{ route('admin.page-add-tours') }}">Thêm Tours</a>
                            </li>
                            <li class="{{ request()->routeIs('admin.tours') ? 'current-page' : '' }}">
                                <a href="{{ route('admin.tours') }}">Danh sách Tours</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ request()->routeIs('admin.booking*') ? 'active' : '' }}">
                        <a href="{{ route('admin.booking') }}"><i class="fa fa-book"></i> Quản lý Booking</a>
                    </li>

                    <li class="{{ request()->routeIs('admin.contact*') ? 'active' : '' }}">
                        <a href="{{ route('admin.contact') }}"><i class="fa fa-envelope-o"></i> Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sidebar-footer hidden-small">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" title="Đăng xuất" style="border:none;background:none;">
                    <span class="glyphicon glyphicon-off"></span>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- top navigation --}}
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('admin/assets/images/user-profile/avt_admin.jpg') }}" alt="">{{ $admin->name ?? 'Admin' }}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-link" style="padding:5px 15px;">Đăng xuất</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>