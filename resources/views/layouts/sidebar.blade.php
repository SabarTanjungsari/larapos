<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ !empty(session('identity')[0]['photo']) ? asset('dist/img/'.session('identity')[0]['photo']) : asset('dist/img/AdminLTELogo.png') }}"
            alt="LaraPOS" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ session('identity')[0]['name'] }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="{{ route('home') }}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>

                @can('product-list', 'category-list')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Database
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right"></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('category-list')
                        <li class="nav-item">
                            <a href=" {{ route('categories.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon text-purple"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        @endcan
                        @can('product-list')
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon text-secondary"></i>
                                <p>Product</p>
                            </a>
                        </li>
                        @endcan
                        @can('partner-list')
                        <li class="nav-item">
                            <a href="{{ route('partners.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon text-success"></i>
                                <p>Business Partner</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('role-list', 'user-list')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users Manajement
                            <i class="fas fa-angle-left right text-cyan"></i>
                            <span class="badge badge-info right"></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('role-list')
                        <li class="nav-item">
                            <a href=" {{ route('roles.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon text-fuchsia"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        @endcan
                        @can('user-list')
                        <li class="nav-item">
                            <a href=" {{ route('users.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon text-blue"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('cart-list')
                <li class="nav-header">SALES</li>
                <li class="nav-item">
                    <a href=" {{ route('cashiers.index') }}" class="nav-link">
                        <i class="fa fa-shopping-bag nav-icon"></i>
                        <p>Cashier</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=" {{ route('order.transaction') }}" class="nav-link">
                        <i class="fa fa-shopping-cart nav-icon"></i>
                        <p>Transaction</p>
                    </a>
                </li>
                @endcan
                @can('sales-list')
                <li class="nav-item">
                    <a href=" {{ route('order.index') }}" class="nav-link">
                        <i class="fa fa-shopping-basket nav-icon"></i>
                        <p>Order</p>
                    </a>
                </li>
                @endcan

                <li class="nav-header">SETTINGS</li>
                @can('system-list')
                <li class="nav-item">
                    <a href=" {{ route('system.index') }}" class="nav-link">
                        <i class="fa fa-cog nav-icon text-indigo"></i>
                        <p>Setting</p>
                    </a>
                </li>
                @endcan
                <li class="nav-item has-treeview">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="nav-icon far fa-circle text-warning"></i>
                        <p>
                            {{ __('Logout') }}
                        </p>
                    </a>
                    ​
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
