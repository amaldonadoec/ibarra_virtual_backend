<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Version: 5.0.5
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
<!-- begin::Head -->
@include('layouts.partials.head')
<!-- end::Head -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <!-- BEGIN: Header -->
    @include('layouts.partials.header')
    <!-- END: Header -->
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->
        @include('layouts.partials.sidebar')
        <!-- END: Left Aside -->
        <!--BEGIN: content page-->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Subheader -->
            @yield('subheader')
            <!-- END: Subheader -->
            <!-- BEGIN: content-->
            <div class="m-content">
                @yield('content')
            </div>
            <!-- END: content-->
        </div>
        <!--END: content page-->
    </div>
    <!-- end:: Body -->
    <!-- begin::Footer -->
    @include('layouts.partials.footer')
    <!-- end::Footer -->
</div>
<!-- end:: Page -->
<!-- begin::Scroll Top -->
<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500"
     data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->

@include('layouts.partials.scripts')
@yield('additional-scripts')

</body>
<!-- end::Body -->
</html>
