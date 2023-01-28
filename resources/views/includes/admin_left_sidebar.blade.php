<!-- ========== Left Sidebar Start ========== -->

<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li class="has_sub">
                    <a href="/" class="waves-effect"><i class="ti-home"></i>
                        <span> {{ __('message.dashboard') }} </span></a>
                </li>

                {{-- <li class="has_sub">
                                    <a href="/outlet/show" class="waves-effect"><i class="ti-receipt"></i>
                                        <span> Outlets </span></a>
                                </li>--}}
                <li class="has_sub">
                    <a href="/pos" class="waves-effect"><i class="ti-receipt"></i>
                        <span> {{ __('message.pointofsell') }} </span></a>
                </li>


                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-users"></i>
                        <span> {{ __('message.contacts') }} </span>
                        <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="/supplier/show">{{ __('message.suppliers') }}</a></li>
                        <li><a href="/customer/show">{{ __('message.customers') }}</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-paint-roller"></i>
                        <span> {{ __('message.products') }} </span>
                        <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="/products/create">{{ __('message.addproducts') }}</a></li>
                        <li><a href="/products/show">{{ __('message.listproducts') }}</a></li>
                        {{-- <li><a href="/products/import">Import Products</a></li>--}}
                        <li><a href="/product/category/show">{{ __('message.productcategories') }}</a></li>
                        <li><a href="/sell/discount/show">{{ __('message.discount') }}</a></li>
                        {{--<li><a href="#">Print Product labels</a></li>--}}
                    </ul>
                </li>


                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-exchange-vertical"></i>
                        <span> {{ __('message.expenses') }} </span>
                        <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="/expense/create">{{ __('message.addexpenses') }}</a></li>
                        <li><a href="/expense/show">{{ __('message.listexpenses') }}</a></li>
                        <li><a href="/expense/category/show">{{ __('message.expensecategories') }}</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-truck"></i>
                        <span>{{ __('message.purchases') }} </span>
                        <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="/purchase/create">{{ __('message.productpurchase') }}</a></li>
                        <li><a href="/purchase/show">{{ __('message.listproductpurchase') }}</a></li>

                        <li><a href="/ingredient/purchase/show">{{ __('message.newpurchase') }}</a></li>
                        {{-- <li><a href="/ingredient/purchase/show">List Purchase</a></li> --}}

                    </ul>
                </li>
                {{-- <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-shopping-cart"></i>
                        <span>Stock </span>
                        <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="/stock/show">List Stock</a></li>

                    </ul>
                </li> --}}

                <li class="has_sub">
                    <a href="/stock-history/show" class="waves-effect"><i class="fa fa-shopping-basket"></i>
                        <span>{{ __('message.stock') }} </span> </a>
                    {{-- <ul class="list-unstyled">
                        <li><a href="/stock-history/show">List Stock History</a></li>

                    </ul> --}}
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-shopping-cart"></i>
                        <span>{{ __('message.sell') }} </span>
                        <span class="menu-arrow"></span> </a>
                    <ul class="list-unstyled">
                        <li><a href="/sell/list">{{ __('message.listsell') }}</a></li>

                    </ul>
                </li>
                {{-- <li class="has_sub">
                     <a href="javascript:void(0);" class="waves-effect"><i class="ti-exchange-vertical"></i> <span>Sell Return</span>
                         <span class="menu-arrow"></span> </a>
                     <ul class="list-unstyled">
                         <li><a href="#">List Sell</a></li>

                     </ul>
                 </li>
 --}}
                @if (Auth::user()->user_type == 1)

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-receipt"></i>
                            <span> {{ __('message.reports') }} </span>
                            <span class="menu-arrow"></span> </a>
                        <ul class="list-unstyled">
                            <li><a href="/report/profit/show">{{__('message.profitlos') }}</a></li>
                            <li><a href="/report/sell/product">{{ __('message.sellbyproduct') }}</a></li>
                            <li><a href="/report/sell/salesman">{{ __('message.salesmansold') }}</a></li>
                            {{-- <li><a href="#">Stock Report</a></li>
                             <li><a href="#">Product Purchase Report</a></li>
                             <li><a href="#">Product Sell Report</a></li>--}}
                        </ul>
                    </li>



                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i
                                class="fa fa-support"></i><span> {{ __("message.settings") }} </span>
                            <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            {{--   <li><a href="/vat/show">Tax Rates</a></li>--}}
                            <li><a href="/setting/shop">{{ __('message.shopsetting') }}</a></li>
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-user"></i>
                            <span> {{ __('message.usermanagement') }} </span>
                            <span class="menu-arrow"></span> </a>
                        <ul class="list-unstyled">
                            <li><a href="/user/show">{{ __('message.operator') }}</a></li>
                            {{-- <li><a href="/user/role/show">Roles</a></li>--}}
                        </ul>
                    </li>
                @endif
                <li class="has_sub">
                    <a href="/logout" class="waves-effect"><i class="ti-receipt"></i>
                        <span> {{ __('message.logout') }} </span></a>
                </li>

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->
