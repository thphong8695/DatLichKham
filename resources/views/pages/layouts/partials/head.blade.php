<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ asset('') }}"></base>
    <meta charset="utf-8" />
    <add key="webpages:Enabled" value="true" />
    <title>Đặt Lịch Khám - 106X</title>
    <meta name="description" content="Datatable HTML table" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::clont-->
    {{-- <link rel="stylesheet" href="{{ mix('/css/clont.css') }}" /> --}}
    {{-- <link rel="icon" href="assets/images/brand/favicon.ico" type="image/x-icon"/> --}}

    <!-- Style css -->
    <link href="assets/css/style.css" rel="stylesheet" />

    <!--Horizontal css -->
    <link id="effect" href="assets/plugins/horizontal-menu/dropdown-effects/fade-up.css" rel="stylesheet" />
    <link href="assets/plugins/horizontal-menu/horizontal.css" rel="stylesheet" />

    <!-- P-scroll bar css-->
    <link href="assets/plugins/p-scrollbar/p-scrollbar.css" rel="stylesheet" />
    <!-- bootstrap-toggle css-->
    <link href="assets/global/plugins/bootstrap-toggle/css/bootstrap-toggle.css" rel="stylesheet" />
    <!---Icons css-->
    <link href="assets/plugins/web-fonts/icons.css" rel="stylesheet" />
    <link href="assets/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
    <link href="assets/plugins/web-fonts/plugin.css" rel="stylesheet" />
    

    <!-- Data table css -->
    <link href="assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />

    <!-- Slect2 css -->
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet" />

    <!-- Skin css-->
    <link href="assets/css/skins.css" rel="stylesheet" />
    <!--end::Fonts-->
    <!-- datepicker -->
    <link rel="stylesheet" href="assets/date-picker/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
    <!-- File Uploads css-->
    <link href="assets/plugins/fileupload/css/dropify.css" rel="stylesheet" type="text/css" />
    <!-- Toastr -->
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <style type="text/css">
        a.disabled {
            pointer-events: none;
        }
    </style>
</head>