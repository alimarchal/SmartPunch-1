<!-- Vendor js -->
<script src="{{url('Horizontal/dist/assets/js/vendor.min.js')}}"></script>

<script src="{{url('Horizontal/dist/assets/libs/toastr/toastr.min.js')}}"></script>

<script src="{{url('Horizontal/dist/assets/js/pages/toastr.init.js')}}"></script>

<!-- knob plugin -->
<script src="{{url('Horizontal/dist/assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>

<!--Morris Chart-->
<script src="{{url('Horizontal/dist/assets/libs/morris-js/morris.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/raphael/raphael.min.js')}}"></script>

<!-- Dashboard init js-->
<script src="{{url('Horizontal/dist/assets/js/pages/dashboard.init.js')}}"></script>

<script src="{{url('Horizontal/dist/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<!-- third party js -->
<script src="{{url('Horizontal/dist/assets/libs/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/datatables/dataTables.bootstrap4.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/datatables/responsive.bootstrap4.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/datatables/buttons.html5.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/datatables/buttons.flash.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/datatables/buttons.print.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/datatables/dataTables.keyTable.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/datatables/dataTables.select.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{url('Horizontal/dist/assets/libs/pdfmake/vfs_fonts.js')}}"></script>
<!-- third party js ends -->

{{-- Select2 --}}
<script src="{{url('Horizontal/dist/assets/libs/select2/select2.min.js')}}"></script>

{{-- Commented below inorder to set dynamic language for datatables --}}
<!-- Datatables init -->
{{--<script src="{{url('Horizontal/dist/assets/js/pages/datatables.init.js')}}"></script>--}}

<!-- App js -->
<script src="{{url('Horizontal/dist/assets/js/app.min.js')}}"></script>

@if(Session::has('success'))
    <script>
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-full-width",
            "onclick": null,
            "showDuration": "500",
            "hideDuration": "1000",
            "timeOut": "6000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if(Session::has('error'))
    <script>
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-full-width",
            "onclick": null,
            "showDuration": "500",
            "hideDuration": "1000",
            "timeOut": "6000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr.error("{{ session('error') }}");
    </script>
@endif

@yield('scripts')
