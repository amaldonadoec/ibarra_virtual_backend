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
<!-- end::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
{{--<div class="m-grid m-grid--hor m-grid--root m-page">--}}
    {{--<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--singin m-login--2 m-login-2--skin-3"--}}
         {{--id="m_login" style="background-image: url({!! asset('metronic/app/media/img/bg/bg-2.jpg') !!});">--}}
        {{--<div class="m-grid__item m-grid__item--fluid m-login__wrapper">--}}
            {{--<div class="m-login__container">--}}
                {{--@yield('content')--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}


<!-- end:: Page -->

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--singin" id="m_login">
        <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
            <div class="m-stack m-stack--hor m-stack--desktop">
                <div class="m-stack__item m-stack__item--fluid">
                    <div class="m-login__wrapper">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <div class=" login-background m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content" style="background-image: url({{asset('metronic/app/media/img//bg/bg-4.jpg')}})">
            <div class="m-grid__item m-grid__item--middle">
                <h3 class="m-login__welcome">
                    {{ config('app.name', 'Laravel') }}
                </h3>
                <p class="m-login__msg">
                    Lorem ipsum dolor sit amet, coectetuer adipiscing
                    <br>
                    elit sed diam nonummy et nibh euismod
                </p>
            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->

<!--begin::Scripts -->
@include('layouts.partials.scripts_login')
<!--end::Snippets -->
</body>
<!-- end::Body -->
</html>
