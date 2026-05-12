<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light ml-2">
            Admin Panel
        </span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>User Management</p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User List</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.accounts.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>Account Management</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href=" }}"
                    class="nav-link {{ request()->is('') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-box"></i>

                        <p>Product Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=""
                    class="nav-link {{ request()->is('') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-warehouse"></i>

                        <p>Inventory Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=""
                    class="nav-link {{ request()->is('') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-users"></i>

                        <p>Customer Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=""
                    class="nav-link {{ request()->is('') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-shopping-cart"></i>

                        <p>Order Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=""
                    class="nav-link {{ request()->is('') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-wallet"></i>

                        <p>Accounts Management</p>
                    </a>
                </li>
            </ul>

        </nav>

    </div>

</aside>