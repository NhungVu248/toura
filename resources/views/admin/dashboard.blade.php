@extends('admin.layouts.master')

@section('content')

<h3 class="mb-4">Bảng điều khiển</h3>

<div class="row">

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Tổng user</h6>
                <h3>{{ $summary['totalUsers'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>User thường</h6>
                <h3>{{ $summary['totalClient'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>User mới (tháng)</h6>
                <h3>{{ $summary['newUsersThisMonth'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

</div>

@endsection