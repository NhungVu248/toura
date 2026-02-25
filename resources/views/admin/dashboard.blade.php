@include('admin.blocks.header')

<div class="container body">
    <div class="main_container">

        @include('admin.blocks.sidebar')

        <div class="right_col" role="main">

            <!-- TOP STATS -->
            <div class="row" style="margin-bottom: 20px;">

                <div class="col-md-3 col-sm-3">
                    <div class="tile_stats_count">
                        <span class="count_top">Tổng số người dùng</span>
                        <div class="count green">{{ $summary['totalUsers'] }}</div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-3">
                    <div class="tile_stats_count">
                        <span class="count_top">Số Admin</span>
                        <div class="count blue">{{ $summary['totalAdmin'] }}</div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-3">
                    <div class="tile_stats_count">
                        <span class="count_top">User thường</span>
                        <div class="count">{{ $summary['totalClient'] }}</div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-3">
                    <div class="tile_stats_count">
                        <span class="count_top">User mới tháng này</span>
                        <div class="count red">{{ $summary['newUsersThisMonth'] }}</div>
                    </div>
                </div>

            </div>

            <!-- DANH SÁCH USER GẦN ĐÂY -->
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Người dùng đăng ký gần đây</h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Ngày đăng ký</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestUsers as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->role === 'admin')
                                                    <span class="badge badge-danger">Admin</span>
                                                @else
                                                    <span class="badge badge-secondary">User</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
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

@include('admin.blocks.footer')