<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description"
            content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
        <meta name="keywords"
            content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
        <meta name="author" content="PIXINVENT">
        <title>Faster
        </title>

        <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('uploads/' . $OrganizationProfile->logo)}}">
        <link
            href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
            rel="stylesheet">
        <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
        {{-- sweetalert --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
        {{-- End Sweet Alert --}}
        <!--Livewire-->
        @livewireStyles
        <!--END Livewire-->
        {{-- switch --}}
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/toggle/switchery.min.css')}}">
        {{-- switch --}}
        {{-- select2 --}}
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/selects/select2.min.css')}}">
        {{-- end select2 --}}
        @if (app()->getLocale()== 'ar')
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/vendors.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/extensions/colReorder.dataTables.min.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/extensions/fixedHeader.dataTables.min.css')}}">
        <!-- END VENDOR CSS-->
        <!-- BEGIN MODERN CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/app.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/custom-rtl.css')}}">
        <!-- END MODERN CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/css-rtl/core/menu/menu-types/vertical-menu.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/animate/animate.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/core/colors/palette-gradient.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/pages/login-register.css')}}">
        <!-- END Page Level CSS-->
        {{-- Google fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
        {{-- End Google fonts --}}
        <!-- BEGIN Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style-rtl.css')}}">
        <!-- END Custom CSS-->
        @else
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/vendors.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/extensions/colReorder.dataTables.min.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
        <link rel="stylesheet" type="text/css"
            href="{{asset('app-assets/vendors/css/tables/extensions/fixedHeader.dataTables.min.css')}}">
        <!-- END VENDOR CSS-->
        <!-- BEGIN MODERN CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/app.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/custom.css')}}">
        <!-- END MODERN CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/animate/animate.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/colors/palette-gradient.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/login-register.css')}}">
        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
        <!-- END Custom CSS-->
        @endif

        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/general.css')}}">
        @stack('links')
    </head>


  <script src="https://cdn.tiny.cloud/1/twhrixacjh7gu2n28ekp4d2nvz4gr2obc0p6gq8l58lmbwba/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body style="overflow-x: hidden" class="vertical-layout 2-columns fixed-navbar pace-done vertical-menu menu-expanded"
    data-open="click" data-menu="vertical-menu" data-col="2-columns">
    <nav
    class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a
                        class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                            class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item">
                    <a class="navbar-brand" href="#">
                        <img class="brand-logo" alt="modern admin logo"
                            src="{{asset('uploads/' . $OrganizationProfile->logo)}}">
                        <h3 class="brand-text">{{$OrganizationProfile->name}}</h3>
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                            class="la la-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                            href="#"><i class="ft-menu"></i></a></li>

                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link"
                            id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><i class="flag-icon flag-icon-gb"></i><span
                                class="selected-language"></span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                            <a class="dropdown-item" href="{{route('switchLan', 'en')}}"><i
                                    class="flag-icon flag-icon-gb"></i> English</a>
                            <a class="dropdown-item" href="{{route('switchLan', 'ar')}}"><i
                                    class="flag-icon flag-icon-sa"></i> العربيه</a>

                        </div>
                    </li>
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="mr-1">
                                <span class="user-name text-bold-700">{{auth()->user()->name}}</span>
                            </span>
                            <span class="avatar avatar-online">
                                <img src="{{asset('uploads/' . auth()->user()->photo)}}" alt="avatar"><i></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                href="{{route('user.profile')}}"><i class="ft-user"></i>
                                {{__('translation.edit profile')}}</a>
                            {{-- <a class="dropdown-item" href="#"><i class="ft-mail"></i> My Inbox</a>
                            <a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a>
                            <a class="dropdown-item" href="#"><i class="ft-message-square"></i> Chats</a> --}}
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                                    class="ft-power"></i> {{__('translation.logout')}}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
@php
$permission = Spatie\Permission\Models\Permission::get();
@endphp

<div class="main-menu menu-fixed menu-dark menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content ps-container ps-theme-dark ps-active-y"
        data-ps-id="8b0cb816-c612-9fbc-4ca0-0760388c8785" style="height: 697px;">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{  request()->routeIs('home') ? 'active' : '' }}"><a href="{{route('home')}}"><i
                        class="la la-home"></i><span class="menu-title"
                        data-i18n="nav.changelog.main">{{__('translation.dashboard')}}</span></a>
            </li>

            @if(auth()->user()->can('orders-management') ||
            auth()->user()->can('orders-importCSV-management'))
            <li class="nav-item has-sub {{  request()->is('orders/*') ? 'open' : '' }}"><a href="#"><i
                        class="la la-list-alt"></i><span class="menu-title"
                        data-i18n="nav.templates.main">{{__('translation.orders.management')}}</span></a>
                <ul class="menu-content" style="">
                    @if(auth()->user()->can('orders-management'))
                    <li class="is-shown {{  request()->routeIs('orders') ? 'active' : '' }}">
                        <a class="menu-item" href="{{route('orders')}}"
                            data-i18n="nav.dash.ecommerce">{{__('translation.orders')}}</a>
                    </li>
                    @endif
                    @if(auth()->user()->can('orders-importCSV-management'))
                    <li class="is-shown {{  request()->routeIs('orders.importCSV') ? 'active' : '' }}"><a
                            class="menu-item" href="{{route('orders.importCSV')}}"
                            data-i18n="nav.dash.crypto">{{__('translation.orders.importCSV')}}</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if(auth()->user()->can('representatives-management') ||
            auth()->user()->can('representatives-orders-management') ||
            auth()->user()->can('representatives-fees-collection-management'))
            <li class="nav-item has-sub {{  request()->is('representatives-management/*') ? 'open' : '' }}"><a
                    href="#"><i class="la la-users"></i><span class="menu-title"
                        data-i18n="nav.templates.main">{{__('translation.representatives.management')}}</span></a>
                <ul class="menu-content" style="">
                    @if(auth()->user()->can('representatives-management'))
                    <li class="is-shown {{  request()->routeIs('representatives') ? 'active' : '' }}">
                        <a class="menu-item" href="{{route('representatives')}}"
                            data-i18n="nav.dash.ecommerce">{{__('translation.representatives')}}</a>
                    </li>
                    @endif
                    @if(auth()->user()->can('representatives-orders-management'))
                    <li class="is-shown {{  request()->routeIs('representatives.orders') ? 'active' : '' }}"><a
                            class="menu-item" href="{{route('representatives.orders')}}"
                            data-i18n="nav.dash.crypto">{{__('translation.representatives.orders')}}</a>
                    </li>
                    @endif
                    @if(auth()->user()->can('representatives-fees-collection-management'))
                    <li class="is-shown {{  request()->routeIs('representatives.fees.collection') ? 'active' : '' }}"><a
                            class="menu-item" href="{{route('representatives.fees.collection')}}"
                            data-i18n="nav.dash.crypto">{{__('translation.representatives.fees.collection')}}</a>
                    </li>
                    @endif
                    @if(auth()->user()->can('representatives-payment-management'))
                    <li class="is-shown {{  request()->routeIs('representatives.payment') ? 'active' : '' }}"><a
                            class="menu-item" href="{{route('representatives.payment')}}"
                            data-i18n="nav.dash.crypto">{{__('translation.representatives.payment')}}</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if(auth()->user()->can('clients-management'))
            {{-- <li class="nav-item {{  request()->routeIs('clients') ? 'active' : '' }}"><a
                href="{{route('clients')}}"><i class="la la-street-view"></i><span class="menu-title"
                    data-i18n="nav.changelog.main">{{__('translation.clients.management')}}</span></a>
            </li> --}}
            <li class="nav-item has-sub {{  request()->is('clients-management/*') ? 'open' : '' }}"><a href="#"><i
                        class="la la-street-view"></i><span class="menu-title"
                        data-i18n="nav.templates.main">{{__('translation.clients.management')}}</span></a>
                <ul class="menu-content" style="">
                    <li class="is-shown {{  request()->routeIs('clients') ? 'active' : '' }}">
                        <a class="menu-item" href="{{route('clients')}}"
                            data-i18n="nav.dash.ecommerce">{{__('translation.clients')}}</a>
                    </li>
                    <li class="is-shown {{ request()->routeIs('clients.payment') ? 'active' : '' }}"><a
                            class="menu-item" href="{{route('clients.payment')}}"
                            data-i18n="nav.dash.crypto">{{__('translation.clients.payment')}}</a>
                    </li>
                </ul>
            </li>
            @endif
            {{-- @if(auth()->user()->can('representatives-management'))
            <li class="nav-item {{  request()->routeIs('representatives') ? 'active' : '' }}"><a
                href="{{route('representatives')}}"><i class="la la-group"></i><span class="menu-title"
                    data-i18n="nav.changelog.main">{{__('translation.representatives.management')}}</span></a>
            </li>
            @endif --}}

            {{-- @if(auth()->user()->can('orders-management'))
            <li class="nav-item {{  request()->routeIs('orders') ? 'active' : '' }}"><a href="{{route('orders')}}"><i
                    class="la la-list-alt"></i><span class="menu-title"
                    data-i18n="nav.changelog.main">{{__('translation.orders.management')}}</span></a>
            </li>
            @endif --}}


            @if(auth()->user()->can('reports-management'))
            <li class="nav-item has-sub {{  request()->is('reports/*') ? 'open' : '' }}"><a href="#"><i
                        class="la la-bar-chart-o"></i><span class="menu-title"
                        data-i18n="nav.templates.main">{{__('translation.reports')}}</span></a>
                <ul class="menu-content" style="">
                    <li class="is-shown {{  request()->routeIs('client.account.statement') ? 'active' : ''}}">
                        <a class="menu-item" href="{{route('client.account.statement')}}"
                            data-i18n="nav.dash.ecommerce">{{__('translation.client.account.statement')}}</a>
                    </li>
                    <li class="is-shown {{  request()->routeIs('client.account.transactions') ? 'active' : ''}}">
                        <a class="menu-item" href="{{route('client.account.transactions')}}"
                            data-i18n="nav.dash.ecommerce">{{__('translation.client.transaction')}}</a>
                    </li>
                    <li class="is-shown {{  request()->routeIs('representative.account.statement') ? 'active' : ''}}">
                        <a class="menu-item" href="{{route('representative.account.statement')}}"
                            data-i18n="nav.dash.ecommerce">{{__('translation.representative.account.statement')}}</a>
                    </li>
                    <li class="is-shown {{  request()->routeIs('orders.reports') ? 'active' : ''}}">
                        <a class="menu-item" href="{{route('orders.reports')}}"
                            data-i18n="nav.dash.ecommerce">{{__('translation.orders.reports')}}</a>
                    </li>
                    <li class="is-shown {{  request()->routeIs('orders.per.month.reports') ? 'active' : ''}}">
                        <a class="menu-item" href="{{route('orders.per.month.reports')}}"
                            data-i18n="nav.dash.ecommerce">{{__('translation.orders.per.month.reports')}}</a>
                    </li>
                    <li class="is-shown {{  request()->routeIs('orders.in.out.area.reports') ? 'active' : ''}}">
                        <a class="menu-item" href="{{route('orders.in.out.area.reports')}}"
                            data-i18n="nav.dash.ecommerce">{{__('translation.orders.in.out.area.reports')}}</a>
                    </li>
                    {{-- <li
                        class="is-shown {{  request()->routeIs('representatives.orders.and.deserves.reports') ? 'active' : ''}}">
                    <a class="menu-item" href="{{route('representatives.orders.and.deserves.reports')}}"
                        data-i18n="nav.dash.ecommerce">{{__('translation.representatives.orders.and.deserves')}}</a>
            </li> --}}
            <li class="is-shown {{  request()->routeIs('transactions') ? 'active' : '' }}"><a class="menu-item"
                    href="{{route('transactions')}}"
                    data-i18n="nav.changelog.main">{{__('translation.transactions.management')}}</a>
            </li>
        </ul>
        </li>
        @endif
        @if(auth()->user()->can('areas-management') || auth()->user()->can('services-management') ||
        auth()->user()->can('organization-profile-management') ||
        auth()->user()->can('general-settings-management'))
        <li class="nav-item has-sub {{  request()->is('settings/*') ? 'open' : '' }}"><a href="#"><i
                    class="la la-cog"></i><span class="menu-title"
                    data-i18n="nav.templates.main">{{__('translation.settings')}}</span></a>
            <ul class="menu-content" style="">
                @if(auth()->user()->can('areas-management'))
                <li
                    class="is-shown {{  request()->routeIs('areas.*') || request()->routeIs('sub_areas.*') ? 'active' : '' }}">
                    <a class="menu-item" href="{{route('areas.index')}}"
                        data-i18n="nav.dash.ecommerce">{{__('translation.areas')}}</a>
                </li>
                @endif
                @if(auth()->user()->can('services-management'))
                <li class="is-shown {{  request()->routeIs('services.*') ? 'active' : '' }}"><a class="menu-item"
                        href="{{route('services.index')}}"
                        data-i18n="nav.dash.crypto">{{__('translation.services')}}</a>
                </li>
                @endif
                @if(auth()->user()->can('organization-profile-management'))
                <li class="is-shown {{  request()->routeIs('organization.profile') ? 'active' : '' }}"><a
                        class="menu-item" href="{{route('organization.profile')}}"
                        data-i18n="nav.dash.crypto">{{__('translation.organization.profile')}}</a>
                </li>
                @endif
                @if(auth()->user()->can('general-settings-management'))
                <li class="is-shown {{  request()->routeIs('general.settings') ? 'active' : '' }}"><a class="menu-item"
                        href="{{route('general.settings')}}"
                        data-i18n="nav.dash.crypto">{{__('translation.general.settings')}}</a>
                </li>
                @endif
                @if(auth()->user()->can('general-settings-management'))
                <li class="is-shown {{  request()->routeIs('privacy.police') ? 'active' : '' }}"><a class="menu-item"
                        href="{{route('privacy.police')}}"
                        data-i18n="nav.dash.crypto">{{__('translation.privacy.policy')}}</a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(auth()->user()->can('users-management') || auth()->user()->can('roles-management'))
        <li class="nav-item has-sub {{  request()->is('users-management/*') ? 'open' : '' }}"><a href="#"><i
                    class="la la-user"></i><span class="menu-title"
                    data-i18n="nav.templates.main">{{__('translation.users.management')}}</span></a>
            <ul class="menu-content" style="">
                @if(auth()->user()->can('users-management'))
                <li class="is-shown {{  request()->routeIs('users.*') ? 'active' : '' }}"><a class="menu-item"
                        href="{{route('users.index')}}" data-i18n="nav.dash.ecommerce">{{__('translation.users')}}</a>
                </li>
                @endif
                @if(auth()->user()->can('roles-management'))
                <li class="is-shown {{  request()->routeIs('roles.*') ? 'active' : '' }}"><a class="menu-item"
                        href="{{route('roles.index')}}" data-i18n="nav.dash.crypto">{{__('translation.roles')}}</a>
                </li>
                @endif
            </ul>
        </li>
        @endif



        </ul>
        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;">
            <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps-scrollbar-y-rail" style="top: 0px; height: 697px; right: 251px;">
            <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 128px;"></div>
        </div>
    </div>
</div>
<div>
    <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">{{__('translation.clients')}}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        {{ Breadcrumbs::render('client.account.statement') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                       <form action="{{route('store.privacy')}}" method="post">
                        @csrf
                        <div class="card overflow-hidden">
                            <div class="card-content">
                                <div class="card-body cleartfix">
                                    <div class="form-group px-2 py-2">
                                      <label for="">{{__('translation.privacy.policy.ar')}}</label>
                                      <textarea id="textarea" name='pravicy_ar'></textarea>
                                    </div>
                                    <div class="form-group px-2 py-2">
                                        <label for="">{{__('translation.privacy.policy.en')}}</label>
                                        <textarea id="textarea2" placeholder="privacy in english" name='pravicy_en'></textarea>
                                      </div>
                                      <div class="p-3">
                                        <button class="btn btn-primary">save</button>
                                      </div>
                                </div>
                            </div>
                        </div>

                       </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
    </div>
</div>

  <script>
    tinymce.init({
      selector: '#textarea',
    });
    tinymce.init({
      selector: '#textarea2',
    });
  </script>

  <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{asset('app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}" type="text/javascript">
  </script>
  <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript">
  </script>
  <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"
      type="text/javascript">
  </script>
  <script src="{{asset('app-assets/vendors/js/tables/buttons.colVis.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.colReorder.min.js')}}"
      type="text/javascript">
  </script>
  <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js')}}" type="text/javascript">
  </script>
  <script src="{{asset('app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js')}}" type="text/javascript">
  </script>
  <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.fixedHeader.min.js')}}"
      type="text/javascript">
  </script>

  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="{{asset('app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
  <script src="{{asset('app-assets/js/core/app.js')}}" type="text/javascript"></script>
  <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript">
  </script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script> --}}
  {{-- SWEETALERT FOR LIVEWIRE --}}
  @include('sweetalert::alert')
  {{-- END SWEETALERT FOR LIVEWIRE --}}
  <!-- END PAGE LEVEL JS-->
  <!--Livewire-->
  @livewireScripts
  <!--END Livewire-->
  {{-- alpinejs --}}
  {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
  {{-- alpinejs --}}


  <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function () {
                                      Livewire.on('triggerDelete', model_id => {
                                          console.log('tregered!');
                                          Swal.fire({
                                              title: '{{__('translation.delete.confirmation.message')}}',
                                              text: '{{__('translation.delete.confirmation.text')}}',
                                              icon: "warning",
                                              showCancelButton: true,
                                              confirmButtonColor: '#3085d6',
                                              cancelButtonColor: '#aaa',
                                              confirmButtonText: '{{__('translation.delete')}}'
                                          }).then((result) => {
                                       //if user clicks on delete
                                              if (result.value) {
                                           // calling destroy method to delete
                                                  Livewire.emit('delete', model_id)
                                           // success response
                                                  // Swal.fire({title: 'Contact deleted successfully!', icon: 'success'});
                                              } else {
                                                  Swal.fire({
                                                      title: '{{__('translation.operation.canceled')}}',
                                                      icon: 'success'
                                                  });
                                              }
                                          });
                                      });
                                  })

                                  //to close modal when payment to client-representative done
                                  window.livewire.on('DonePayment', (status, id) => {
                                  console.log("dfdf");
                                  $('#payModal'+id).modal('hide');
                                  });
  </script>

</body>
</html>

</body>
</html>
