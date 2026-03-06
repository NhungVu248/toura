@extends('admin.layouts.master')

@section('content')

<h3 class="mb-4">Bảng điều khiển</h3>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h6>Tổng user</h6>
                <h3>{{ $summary['totalUsers'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h6>User thường</h6>
                <h3>{{ $summary['totalClient'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h6>User mới (tháng)</h6>
                <h3>{{ $summary['newUsersThisMonth'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Biểu đồ doanh thu năm nay</h6>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 400px; width: 100%;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const labels = @json($chartData['labels'] ?? []);
        const dataValues = @json($chartData['values'] ?? []);

        // 1. Tìm thẻ canvas
        const canvas = document.getElementById('revenueChart');
        
        // 2. Kiểm tra xem canvas có tồn tại không để tránh lỗi null
        if (!canvas) {
            console.error("Lỗi: Không tìm thấy thẻ canvas 'revenueChart'");
            return;
        }

        const ctx = canvas.getContext('2d');
        
        // 3. Khởi tạo Chart
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu',
                    data: dataValues,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;
                                return value.toLocaleString('vi-VN') + ' đ';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + ' đ';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush