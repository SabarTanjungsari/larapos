<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="LaraPOS" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">LaraPOS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                @if (auth()->user()->can('show products') || auth()->user()->can('delete products') ||
                auth()->user()->can('create products'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">2</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=" {{ route('categories.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @role('admin')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users Manajement
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">2</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=" {{ route('roles.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('users.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.roles_permission') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Role Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole

                @role('cashier')
                <li class="nav-header">TRANSACTION</li>
                <li class="nav-item">
                    <a href=" {{ route('order.transaction') }}" class="nav-link">
                        <i class="fa fa-shopping-cart nav-icon"></i>
                        <p>Sales</p>
                    </a>
                </li>
                </li>
                @endrole

                <li class="nav-header">SETTINGS</li>
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
