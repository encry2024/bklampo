<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ access()->user()->picture }}" class="img-circle" alt="User Image" />
            </div><!--pull-left-->
            <div class="pull-left info">
                <p>{{ access()->user()->full_name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('strings.backend.general.status.online') }}</a>
            </div><!--pull-left-->
        </div><!--user-panel-->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('menus.backend.sidebar.general') }}</li>

            <li class="{{ active_class(Active::checkUriPattern('admin/dashboard')) }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{ trans('menus.backend.sidebar.dashboard') }}</span>
                </a>
            </li>

            @roles([1])
            <li class="{{ active_class(Active::checkUriPattern('admin/category')) }}">
                <a href="{{ route('admin.category.index') }}">
                    <i class="fa fa-bars"></i>
                    <span>Category</span>
                </a>
            </li>
            @endauth

            @roles([1])
            <li class="{{ active_class(Active::checkUriPattern('admin/branch')) }}">
                <a href="{{ route('admin.branch.index') }}">
                    <i class="fa fa-building"></i>
                    <span>Branch</span>
                </a>
            </li>
            @endauth

            @roles([1,2])
            <li class="{{ active_class(Active::checkUriPattern('admin/pos/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-industry"></i>
                    <span>POS</span>
                </a>

                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/pos/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/pos/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/pos/inventory')) }}">
                        <a href="{{ route('admin.inventory.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Inventory Management</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/pos/product')) }}">
                        <a href="{{ route('admin.product.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Product Management</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/pos/stock')) }}">
                        <a href="{{ route('admin.stock.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Stock In</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endauth


            @roles([1,3])
            <li class="{{ active_class(Active::checkUriPattern('admin/pos/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-building"></i>
                    <span>Commissary</span>
                </a>

                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/commissary/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/commissary/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/commisary/inventory')) }}">
                        <a href="{{ route('admin.commissary.inventory.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Inventory</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/commisary/product')) }}">
                        <a href="{{ route('admin.commissary.product.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Product</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/commissary/produce')) }}">
                        <a href="{{ route('admin.commissary.produce.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Produce Product</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/commissary/stock')) }}">
                        <a href="{{ route('admin.commissary.stock.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Stock In</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/commissary/delivery')) }}">
                        <a href="{{ route('admin.commissary.delivery.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Deliver item</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/commissary/dispose')) }}">
                        <a href="{{ route('admin.commissary.dispose.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Dispose Item</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/commissary/goods_return')) }}">
                        <a href="{{ route('admin.commissary.goods_return.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Goods Return</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/commissary/invoice')) }}">
                        <a href="{{ route('admin.commissary.invoice.index') }}">
                            <i class="fa fa-money"></i>
                            <span>Sales Invoice</span>
                        </a>
                    </li>
                    <li class="{{ active_class(Active::checkUriPattern('admin/commissary/order_form')) }}">
                        <a href="{{ route('admin.commissary.order_form.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Order Form</span>
                        </a>
                    </li>

                </ul>
            </li>
            @endauth
            

            @roles([1, 2])
            <li class="{{ active_class(Active::checkUriPattern('/admin/report/pos/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-bar-chart"></i>
                    <span>Report POS</span>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/report/pos/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/report/pos/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/report/pos/sale*')) }}">
                        <a href="{{ route('admin.report.pos.sale.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Sales</span>
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/report/pos/daily')) }}">
                        <a href="{{ route('admin.report.pos.daily.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Daily</span>
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/report/pos/monthly')) }}">
                        <a href="{{ route('admin.report.pos.monthly.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Monthly</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endauth


            @roles([1,3])
            <li class="{{ active_class(Active::checkUriPattern('/admin/report/commissary/*', 'menu-open')) }} treeview">
                <a href="#">
                    <i class="fa fa-bar-chart"></i>
                    <span>Report Commissary</span>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/report/commissary/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/report/commissary/*'), 'display: block;') }}">

                    <li class="{{ active_class(Active::checkUriPattern('admin/report/commissary/daily/inventory')) }}">
                        <a href="{{ route('admin.report.commissary.daily.inventory.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Daily Inventory Report</span>
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/report/commissary/daily/delivery')) }}">
                        <a href="{{ route('admin.report.commissary.daily.delivery.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Daily Delivery Report</span>
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/report/commissary/daily/sale')) }}">
                        <a href="{{ route('admin.report.commissary.daily.sale.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Daily Sales Report</span>
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/report/commissary/disposal')) }}">
                        <a href="{{ route('admin.report.commissary.disposal.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Disposal Report</span>
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/report/commissary/goods_return')) }}">
                        <a href="{{ route('admin.report.commissary.goods_return.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Goods Return Report</span>
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/report/commissary/summary')) }}">
                        <a href="{{ route('admin.report.commissary.summary.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>Summary Report</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endauth


            @role(1)
            <li class="header">{{ trans('menus.backend.sidebar.system') }}</li>
            
            <li class="{{ active_class(Active::checkUriPattern('admin/access/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>{{ trans('menus.backend.access.title') }}</span>

                    @if ($pending_approval > 0)
                        <span class="label label-danger pull-right">{{ $pending_approval }}</span>
                    @else
                        <i class="fa fa-angle-left pull-right"></i>
                    @endif
                </a>

                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/access/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/access/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/user*')) }}">
                        <a href="{{ route('admin.access.user.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('labels.backend.access.users.management') }}</span>

                            @if ($pending_approval > 0)
                                <span class="label label-danger pull-right">{{ $pending_approval }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/access/role*')) }}">
                        <a href="{{ route('admin.access.role.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('labels.backend.access.roles.management') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endauth

            @role(1)
            <li class="{{ active_class(Active::checkUriPattern('admin/audit_trail/*')) }}">
                <a href="{{ route('admin.audit_trail.index') }}">
                    <i class="fa fa-circle-o"></i>
                    <span>User Logs</span>
                </a>
            </li>
            @endauth

            @role(1)
            <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer*')) }} treeview">
                <a href="#">
                    <i class="fa fa-list"></i>
                    <span>{{ trans('menus.backend.log-viewer.main') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer')) }}">
                        <a href="{{ route('log-viewer::dashboard') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('menus.backend.log-viewer.dashboard') }}</span>
                        </a>
                    </li>

                    

                    <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer/logs')) }}">
                        <a href="{{ route('log-viewer::logs.list') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('menus.backend.log-viewer.logs') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endauth
        </ul><!-- /.sidebar-menu -->
    </section><!-- /.sidebar -->
</aside>