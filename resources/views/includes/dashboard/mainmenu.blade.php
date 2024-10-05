@php
    $permission = Spatie\Permission\Models\Permission::get();
@endphp

<div class="main-menu menu-fixed menu-dark menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content ps-container ps-theme-dark ps-active-y"
        data-ps-id="8b0cb816-c612-9fbc-4ca0-0760388c8785" style="height: 697px;">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}"><a href="{{ route('home') }}"><i
                        class="la la-home"></i><span class="menu-title"
                        data-i18n="nav.changelog.main">{{ __('translation.dashboard') }}</span></a>
            </li>
            @if (auth()->user()->can('orders-management') || auth()->user()->can('orders-importCSV-management'))
                <li class="nav-item has-sub {{ request()->is('orders/*') ? 'open' : '' }}"><a href="#"><i
                            class="la la-list-alt"></i><span class="menu-title"
                            data-i18n="nav.templates.main">{{ __('translation.orders.management') }}</span></a>
                    <ul class="menu-content" style="">
                        @if (auth()->user()->can('orders-management'))
                            <li class="is-shown {{ request()->routeIs('orders') ? 'active' : '' }}">
                                <a class="menu-item" href="{{ route('orders') }}"
                                    data-i18n="nav.dash.ecommerce">{{ __('translation.orders') }}</a>
                            </li>
                            {{-- <li class="is-shown {{ request()->routeIs('add_order') ? 'active' : '' }}">
                                <a class="menu-item" href="{{ route('add_order') }}"
                                    data-i18n="nav.dash.ecommerce">{{ __('translation.add_order') }}</a>
                            </li> --}}
                        @endif
                        @if (auth()->user()->can('orders-importCSV-management'))
                            <li class="is-shown {{ request()->routeIs('orders.importCSV') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('orders.importCSV') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.orders.importCSV') }}</a>
                            </li>
                        @endif

                        @if (auth()->user()->can('orders-management'))
                            <li class="is-shown {{ request()->routeIs('orders.Client-order') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('orders.Client-order') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.client.order') }}</a>
                            </li>
                        @endif
                        @if (auth()->user()->can('orders-management'))
                            <li class="is-shown {{ request()->routeIs('orders.OrdersFollowUp') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('orders.OrdersFollowUp') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.orders.FollowUp') }}</a>
                            </li>
                        @endif
                        @if (auth()->user()->can('orders-management'))
                            <li class="is-shown {{ request()->routeIs('multi.order.mangemnt') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('multi.order.mangemnt') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.multi.order.mangemnt') }}</a>
                            </li>
                        @endif


                        @if (auth()->user()->can('orders-management'))
                            <li class="is-shown {{ request()->routeIs('multi.order.mangemnt') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('analytics') }}"
                                    data-i18n="nav.dash.crypto">تحليل طلبات المنطقة                                </a>
                            </li>
                        @endif



                        <li class="is-shown {{ request()->routeIs('ShipingOrders') ? 'active' : '' }}"><a
                                class="menu-item" href="{{ route('ShipingOrders') }}"
                                data-i18n="nav.dash.crypto">{{ __('translation.shipping_orders') }}</a>
                        </li>

                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('orders-management') || auth()->user()->can('orders-importCSV-management'))
                <li class="nav-item has-sub {{ request()->is('registartion-request/*') ? 'open' : '' }}"><a
                        href="#"><i class="la la-mobile"></i><span class="menu-title"
                            data-i18n="nav.templates.main">{{ __('translation.Registartion_Reqest') }}</span></a>
                    <ul class="menu-content" style="">
                        @if (auth()->user()->can('orders-management'))
                            <li class="is-shown {{ request()->routeIs('getUnAprrovedclient') ? 'active' : '' }}">
                                <a class="menu-item" href="{{ route('getUnAprrovedclient') }}"
                                    data-i18n="nav.dash.ecommerce">{{ __('translation.clients') }}
                                    @if (GetModelItemCount('Client') > 0)
                                        <span
                                            class="badge badge-success pull-left">{{ GetModelItemCount('Client') }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('orders-importCSV-management'))
                            <li
                                class="is-shown {{ request()->routeIs('getUnAprrovedrepresentatives') ? 'active' : '' }}">
                                <a class="menu-item" href="{{ route('getUnAprrovedrepresentatives') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.representatives') }}
                                    @if (GetModelItemCount('represetive') > 0)
                                        <span
                                            class="badge badge-warning pull-left">{{ GetModelItemCount('represetive') }}</span>
                                    @endif
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('orders-management') || auth()->user()->can('orders-importCSV-management'))
                <li class="nav-item has-sub {{ request()->is('notification/*') ? 'open' : '' }}"><a href="#"><i
                            class="la la-bell"></i><span class="menu-title"
                            data-i18n="nav.templates.main">{{ __('translation.notification') }}</span></a>
                    <ul class="menu-content" style="">
                        @if (auth()->user()->can('orders-management'))
                            <li class="is-shown {{ request()->routeIs('notification.create') ? 'active' : '' }}">
                                <a class="menu-item" href="{{ route('notification.create') }}"
                                    data-i18n="nav.dash.ecommerce">{{ __('translation.notification.create') }}

                                </a>
                            </li>
                        @endif

                        @if (auth()->user()->can('orders-importCSV-management'))
                            <li class="is-shown {{ request()->routeIs('notification.index') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('notification.index') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.notification.history') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('representatives-management') ||
                    auth()->user()->can('representatives-orders-management') ||
                    auth()->user()->can('representatives-fees-collection-management'))
                <li class="nav-item has-sub {{ request()->is('representatives-management/*') ? 'open' : '' }}"><a
                        href="#"><i class="la la-users"></i><span class="menu-title"
                            data-i18n="nav.templates.main">{{ __('translation.representatives.management') }}</span></a>
                    <ul class="menu-content" syle="">
                        @if (auth()->user()->can('representatives-management'))
                            <li class="is-shown {{ request()->routeIs('representatives') ? 'active' : '' }}">
                                <a class="menu-item" href="{{ route('representatives') }}"
                                    data-i18n="nav.dash.ecommerce">{{ __('translation.representatives') }}</a>
                            </li>
                            <li class="is-shown {{ request()->routeIs('represtative_order_search') ? 'active' : '' }}">
                                <a class="menu-item" href="{{ route('represtative_order_search') }}"
                                    data-i18n="nav.dash.ecommerce">{{ __('translation.represtative_order_search') }}</a>
                            </li>
                        @endif
                        @if (auth()->user()->can('representatives-orders-management'))
                            <li class="is-shown {{ request()->routeIs('representatives.orders') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('representatives.orders') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.representatives.orders') }}</a>
                            </li>
                        @endif
                        @if (auth()->user()->can('representatives-fees-collection-management'))
                            <li
                                class="is-shown {{ request()->routeIs('representatives.fees.collection') ? 'active' : '' }}">
                                <a class="menu-item" href="{{ route('representatives.fees.collection') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.representatives.fees.collection') }}</a>
                            </li>
                        @endif
                        {{--  @if (auth()->user()->can('representatives-payment-management'))
                            <li class="is-shown {{ request()->routeIs('representatives.payment') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('representatives.payment') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.representatives.payment') }}</a>
                            </li>
                        @endif --}}
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('clients-management'))
                {{-- <li class="nav-item {{  request()->routeIs('clients') ? 'active' : '' }}"><a
                    href="{{route('clients')}}"><i class="la la-street-view"></i><span class="menu-title"
                        data-i18n="nav.changelog.main">{{__('translation.clients.management')}}</span></a>
            </li> --}}
                <li class="nav-item has-sub {{ request()->is('clients-management/*') ? 'open' : '' }}"><a
                        href="#"><i class="la la-street-view"></i><span class="menu-title"
                            data-i18n="nav.templates.main">{{ __('translation.clients.management') }}</span></a>
                    <ul class="menu-content" style="">

                        <li class="is-shown {{ request()->routeIs('clients') ? 'active' : '' }}">
                            <a class="menu-item" href="{{ route('clients') }}"
                                data-i18n="nav.dash.ecommerce">{{ __('translation.clients') }}</a>
                        </li>
                        {{-- <li class="is-shown {{  request()->routeIs('cleint_account_details') ? 'active' : '' }}">
                            <a class="menu-item" href="{{route('cleint_account_details')}}"
                                data-i18n="nav.dash.ecommerce">{{__('translation.cleint_account_details')}}</a>
                        </li>

                    <li class="is-shown {{ request()->routeIs('clients.payment') ? 'active' : '' }}"><a
                            class="menu-item" href="{{route('clients.payment')}}"
                            data-i18n="nav.dash.crypto">{{__('translation.clients.payment')}}</a>
                    </li> --}}
                        <li class="is-shown {{ request()->routeIs('client.account.transactions') ? 'active' : '' }}">
                            <a class="menu-item" href="{{ route('client.account.transactions') }}"
                                data-i18n="nav.dash.ecommerce">{{ __('translation.client.transaction') }}</a>
                        </li>
                        <li class="is-shown {{ request()->routeIs('ClientStatementIsues') ? 'active' : '' }}">
                            <a class="menu-item" href="{{ route('ClientStatementIsues') }}"
                                data-i18n="nav.dash.ecommerce">{{ __('translation.client.transaction.issue') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            {{-- @if (auth()->user()->can('representatives-management'))
            <li class="nav-item {{  request()->routeIs('representatives') ? 'active' : '' }}"><a
                    href="{{route('representatives')}}"><i class="la la-group"></i><span class="menu-title"
                        data-i18n="nav.changelog.main">{{__('translation.representatives.management')}}</span></a>
            </li>
            @endif --}}

            {{-- @if (auth()->user()->can('orders-management'))
            <li class="nav-item {{  request()->routeIs('orders') ? 'active' : '' }}"><a href="{{route('orders')}}"><i
                        class="la la-list-alt"></i><span class="menu-title"
                        data-i18n="nav.changelog.main">{{__('translation.orders.management')}}</span></a>
            </li>
            @endif --}}


            @if (auth()->user()->can('reports-management'))
                <li class="nav-item has-sub {{ request()->is('reports/*') ? 'open' : '' }}"><a href="#"><i
                            class="la la-bar-chart-o"></i><span class="menu-title"
                            data-i18n="nav.templates.main">{{ __('translation.reports') }}</span></a>
                    <ul class="menu-content" style="">
                        <li class="is-shown {{ request()->routeIs('client.account.statement') ? 'active' : '' }}">
                            <a class="menu-item" href="{{ route('client.account.statement') }}"
                                data-i18n="nav.dash.ecommerce">{{ __('translation.client.account.statement') }}</a>
                        </li>

                        <li
                            class="is-shown {{ request()->routeIs('representative.account.statement') ? 'active' : '' }}">
                            <a class="menu-item" href="{{ route('representative.account.statement') }}"
                                data-i18n="nav.dash.ecommerce">{{ __('translation.representative.account.statement') }}</a>
                        </li>
                        <li class="is-shown {{ request()->routeIs('orders.reports') ? 'active' : '' }}">
                            <a class="menu-item" href="{{ route('orders.reports') }}"
                                data-i18n="nav.dash.ecommerce">{{ __('translation.orders.reports') }}</a>
                        </li>
                        <li class="is-shown {{ request()->routeIs('orders.per.month.reports') ? 'active' : '' }}">
                            <a class="menu-item" href="{{ route('orders.per.month.reports') }}"
                                data-i18n="nav.dash.ecommerce">{{ __('translation.orders.per.month.reports') }}</a>
                        </li>
                        <li class="is-shown {{ request()->routeIs('orders.in.out.area.reports') ? 'active' : '' }}">
                            <a class="menu-item" href="{{ route('orders.in.out.area.reports') }}"
                                data-i18n="nav.dash.ecommerce">{{ __('translation.orders.in.out.area.reports') }}</a>
                        </li>
                        {{-- <li
                        class="is-shown {{  request()->routeIs('representatives.orders.and.deserves.reports') ? 'active' : ''}}">
                        <a class="menu-item" href="{{route('representatives.orders.and.deserves.reports')}}"
                            data-i18n="nav.dash.ecommerce">{{__('translation.representatives.orders.and.deserves')}}</a>
                    </li> --}}
                        <li class="is-shown {{ request()->routeIs('transactions') ? 'active' : '' }}"><a
                                class="menu-item" href="{{ route('transactions') }}"
                                data-i18n="nav.changelog.main">{{ __('translation.transactions.management') }}</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('areas-management') ||
                    auth()->user()->can('services-management') ||
                    auth()->user()->can('organization-profile-management') ||
                    auth()->user()->can('general-settings-management'))
                <li class="nav-item has-sub {{ request()->is('settings/*') ? 'open' : '' }}"><a href="#"><i
                            class="la la-cog"></i><span class="menu-title"
                            data-i18n="nav.templates.main">{{ __('translation.settings') }}</span></a>
                    <ul class="menu-content" style="">
                        @if (auth()->user()->can('areas-management'))
                            <li
                                class="is-shown {{ request()->routeIs('areas.*') || request()->routeIs('sub_areas.*') ? 'active' : '' }}">
                                <a class="menu-item" href="{{ route('areas.index') }}"
                                    data-i18n="nav.dash.ecommerce">{{ __('translation.areas') }}</a>
                            </li>
                        @endif
                        @if (auth()->user()->can('services-management'))
                            <li class="is-shown {{ request()->routeIs('services.*') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('services.index') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.services') }}</a>
                            </li>
                        @endif
                        @if (auth()->user()->can('organization-profile-management'))
                            <li class="is-shown {{ request()->routeIs('organization.profile') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('organization.profile') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.organization.profile') }}</a>
                            </li>
                        @endif
                        @if (auth()->user()->can('general-settings-management'))
                            <li class="is-shown {{ request()->routeIs('general.settings') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('general.settings') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.general.settings') }}</a>
                            </li>
                        @endif
                        @if (auth()->user()->can('general-settings-management'))
                            <li class="is-shown {{ request()->routeIs('privacy.police') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('privacy.police') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.privacy.policy') }}</a>
                            </li>
                        @endif
                        @if (auth()->user()->can('general-settings-management'))
                            <li class="is-shown {{ request()->routeIs('Devices') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('Devices') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.wahts_accouts') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('users-management') || auth()->user()->can('roles-management'))
                <li class="nav-item has-sub {{ request()->is('users-management/*') ? 'open' : '' }}"><a
                        href="#"><i class="la la-user"></i><span class="menu-title"
                            data-i18n="nav.templates.main">{{ __('translation.users.management') }}</span></a>
                    <ul class="menu-content" style="">
                        @if (auth()->user()->can('users-management'))
                            <li class="is-shown {{ request()->routeIs('users.*') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('users.index') }}"
                                    data-i18n="nav.dash.ecommerce">{{ __('translation.users') }}</a>
                            </li>
                        @endif
                        @if (auth()->user()->can('roles-management'))
                            <li class="is-shown {{ request()->routeIs('roles.*') ? 'active' : '' }}"><a
                                    class="menu-item" href="{{ route('roles.index') }}"
                                    data-i18n="nav.dash.crypto">{{ __('translation.roles') }}</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            <li class="nav-item {{ request()->routeIs('help') ? 'active' : '' }}"><a href="{{ route('help') }}"><i
                        class="la  la-question-circle"></i><span class="menu-title"
                        data-i18n="nav.changelog.main">{{ __('translation.help') }}</span></a>
            </li>


        </ul>
        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;">
            <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps-scrollbar-y-rail" style="top: 0px; height: 697px; right: 251px;">
            <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 128px;"></div>
        </div>
    </div>
</div>
