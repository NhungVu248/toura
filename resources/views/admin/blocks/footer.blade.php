        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Toura Admin Panel © {{ date('Y') }}
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('admin/vendors/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<!-- NProgress -->
<script src="{{ asset('admin/vendors/nprogress/nprogress.js') }}"></script>

<!-- Chart.js -->
<script src="{{ asset('admin/vendors/Chart.js/dist/Chart.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('admin/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Custom Theme -->
<script src="{{ asset('admin/build/js/custom.js') }}"></script>

<!-- Custom Dev Script -->
<script src="{{ asset('admin/assets/js/custom-js.js') }}"></script>

{{-- Hiển thị thông báo --}}
<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>

{{-- Cho phép từng page inject script riêng --}}
@stack('scripts')

</body>
</html>