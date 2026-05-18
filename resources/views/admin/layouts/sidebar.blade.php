<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">

        <div class="image">
            <img src="{{ !empty(session('user_image'))
                    ? asset(session('user_image'))
                    : asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt=""
                style="width:35px;height:35px;object-fit:cover;">
        </div>

        <div class="info">
            <a href="#" class="d-block text-white">
                {{ session('user_name') }}
            </a>
        </div>

    </div>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <li
                    class="nav-item has-treeview {{ request()->is('admin/users*') || request()->is('admin/accounts*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/users*') || request()->is('admin/accounts*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p> User Management <i class="right fas fa-angle-left"></i></p>
                    </a>

                    <ul class="nav nav-treeview">
                        {{-- USER MENU --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}"
                                class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Users</p>
                            </a>
                        </li>

                        {{-- ACCOUNTS MENU --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.accounts.index') }}"
                                class="nav-link {{ request()->is('admin/accounts*') ? 'active' : '' }}">
                                <i class="fas fa-wallet nav-icon"></i>
                                <p>Accounts</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href=" }}" class="nav-link {{ request()->is('') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Product Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link {{ request()->is('') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>Inventory Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link {{ request()->is('') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Customer Management</p>
                    </a>
                </li>

                <li
                    class="nav-item has-treeview {{ request()->is('admin/order*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/order*')  ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p> Order Management <i class="right fas fa-angle-right"></i></p>
                    </a>

                    <ul class="nav nav-treeview">
                        {{-- USER MENU --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.order.index') }}"
                                class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Order Lists</p>
                            </a>
                        </li>


                    </ul>
                </li>
{{--
                <li class="nav-item">
                    <a href="" class="nav-link {{ request()->is('') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Order Management</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="" class="nav-link {{ request()->is('') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Accounts Management</p>
                    </a>
                </li>
            </ul>

        </nav>

    </div>

</aside>
<style>
    .nav-treeview .nav-link {

        padding-left: 38px !important;
    }

    .nav-treeview .nav-icon {

        font-size: 12px !important;

        width: 18px !important;
    }
</style>
