
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Web font -->
    <script src="{{asset('js/plugins/webFont.js')}}"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <!--begin::Page Vendors -->
    <!--end::Page Vendors -->
    <link href="{{ asset('metronic/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronic/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('js/plugins/datatables/extensions/Responsive/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('js/plugins/datatables/extensions/Responsive/css/responsive.dataTables.min.css')}}" rel="stylesheet">

    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Base Styles -->

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo/favicon/favicon-16x16.png')}}">
{{--    <link rel="manifest" href="{{ asset('images/logo/favicon/site.webmanifest')}}">--}}
    <link rel="mask-icon" href="{{ asset('images/logo/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    @yield('additional-styles')
</head>
