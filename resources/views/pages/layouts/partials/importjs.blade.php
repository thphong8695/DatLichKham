<!-- Jquery js-->
<script src="assets/js/vendors/jquery-3.4.0.min.js"></script>

<!-- Bootstrap4 js-->
<script src="assets/plugins/bootstrap/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!--Othercharts js-->
<script src="assets/plugins/othercharts/jquery.sparkline.min.js"></script>
<!--bootstrap-toggle js-->
<script src="assets/global/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js" type="text/javascript"></script>
<!-- Circle-progress js-->
<script src="assets/js/vendors/circle-progress.min.js"></script>

<!-- Jquery-rating js-->
<script src="assets/plugins/rating/jquery.rating-stars.js"></script>

<!--Horizontal js-->
<script src="assets/plugins/horizontal-menu/horizontal.js"></script>

<!-- P-scroll js-->
<script src="assets/plugins/p-scrollbar/p-scrollbar.js"></script>
<script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>

<!-- Data tables js-->
<script src="assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/datatables.js"></script>

<!-- Select2 js -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<!--Sidemenu js-->
<script src="assets/plugins/sidemenu/sidemenu.js"></script>

<!-- Custom js-->
<script src="assets/js/custom.js"></script>

<!-- Toast js -->
<script src="assets/plugins/toastr/toastr.min.js"></script>
<!-- DatePicker flatpickr -->
<script src="assets/date-picker/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

<!-- File uploads js -->
<script src="assets/plugins/fileupload/js/dropify.js"></script>
<script src="assets/js/filupload.js"></script>
<!-- tinymce -->
<script src="assets/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script src="assets/tinymce/js/tinymce/tinymce.min.js"></script>

<script type="text/javascript">
  window.setTimeout(function() {

    $(".alert").fadeTo(500, 0).slideUp(500, function(){

        $(this).remove(); 
    });
}, 15000);
</script>
<!-- Delete confirm -->
<script type="text/javascript">
    $('.show_confirm').click(function(e) {
        if(!confirm('Bạn có chắc muốn hủy đăng ký?')) {
            e.preventDefault();
        }
    });
</script>
<script>
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "5000",
      "timeOut": "15000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif
    @if ($message = Session::get('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif
    @if ($message = Session::get('message'))
        toastr.error("{{ Session::get('message') }}");
    @endif
    @if(session('flash_err'))
        toastr.error("{{ Session::get('flash_err') }}");
    @endif
    
    //tag select2
    $(".tagging").select2({
        tags: true
    });
</script>
<script type="text/javascript">
    $(function() {
        $('[data-toggle="datepicker"]').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            //daysOfWeekDisabled: "0,6",
            language: "vi",
            todayHighlight : true,
            //autoHide: true,
            autoclose: true,
            zIndex: 2048,
        });
    });
    
    $(function() {
        $('[data-toggle="datepickerNgayHienTai"]').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
                changeYear: true,
                // showButtonPanel: true,
                clickInput: true,
        });
    });
</script>

<!-- Scripts -->
{{-- <script src="{{ asset('js/app.js') }}"></script>
 --}}
@yield('script')

