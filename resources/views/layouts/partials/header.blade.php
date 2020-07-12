<!-- BEGIN: Header -->
<header class="m-grid__item    m-header " data-minimize-offset="200" data-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="#" class="m-brand__logo-wrapper ">
                            <span class="h4  m--font-light">{{ config('app.name', 'Laravel') }} </span>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block ">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                data-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													<img src="{{ asset('metronic/app/media/img/users/logoutn.png') }}"
                                                         class="m--img-rounded m--marginless m--img-centered" alt=""/>
												</span>
                                    <span class="m-topbar__username m--hide">
													Nick
												</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center"
                                             style="background: url({!!  asset('metronic/app/media/img/misc/user_profile_bg.jpg') !!} ); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic">
                                                    <img src="{{ asset('metronic/app/media/img/users/logoutn.png') }}"
                                                         class="m--img-rounded m--marginless" alt=""/>
                                                </div>
                                                <div class="m-card-user__details">
																<span class="m-card-user__name m--font-weight-500">
																	{!! $log_in_name !!}
																</span>
                                                    {{--<a href="" class="m-card-user__email m--font-weight-300 m-link">--}}
                                                    {{--mark.andre@gmail.com--}}
                                                    {{--</a>--}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__item">
                                                        <a href="{{ route('logout') }}"
                                                           class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder"
                                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                            Cerrar sesión
                                                        </a>
                                                        <form id="logout-form" action="{{ route('logout') }}"
                                                              method="POST" style="display: none;">
                                                            {{ csrf_field() }}
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>
<!-- END: Header -->
