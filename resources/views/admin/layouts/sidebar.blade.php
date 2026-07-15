<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <div class="mt-3 pb-3 mb-3 d-flex align-items-center">

        <a href="{{ session('user_role') === 'cashier' ? route('admin.orders.new.page') : (session('user_role') === 'vendor' ? route('inventory.list') : route('admin.dashboard.index')) }}" class="brand-link">
            <i class="fas fa-user-secret" style="margin-left: .8rem;   margin-right: .5rem;"></i>
            <span class="brand-text font-weight-light">Admin Panel</span>
        </a>

    </div>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                @unless(in_array(session('user_role'), ['cashier', 'vendor']))

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard.index') }}"
                        class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}"
                                class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview
                    {{ request()->is('admin/products*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link
                    {{ request()->is('admin/products*') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-box-open"></i>

                        <p>
                            Product Management

                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        {{-- ALL PRODUCTS --}}
                        <li class="nav-item">

                            <a href="{{ route('admin.products.index') }}" class="nav-link
                            {{ request()->is('admin/products') ? 'active' : '' }}">

                                <i class="fas fa-boxes nav-icon"></i>

                                <p>All Products</p>

                            </a>

                        </li>

                        {{-- ADD PRODUCT --}}
                        <li class="nav-item">

                            <a href="{{ route('admin.products.create') }}" class="nav-link
                            {{ request()->is('admin/products/create') ? 'active' : '' }}">

                                <i class="fas fa-plus-square nav-icon"></i>

                                <p>Add Product</p>

                            </a>

                        </li>

                    </ul>

                </li>

                @endunless

                {{-- Inventory Management — visible to admin and vendor (not cashier) --}}
                @unless(session('user_role') === 'cashier')

                <li class="nav-item has-treeview
                {{ request()->is('admin/inventory*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link
                    {{ request()->is('admin/inventory*') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-boxes"></i>

                        <p>
                            Inventory Management

                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        {{-- INVENTORY LIST --}}
                        <li class="nav-item">

                            <a href="{{ route('inventory.list') }}" class="nav-link
                            {{ request()->is('admin/inventory/list') ? 'active' : '' }}">

                                <i class="fas fa-list nav-icon"></i>

                                <p>Inventory List</p>

                            </a>

                        </li>

                        {{-- ACCOUNTS TRACKING --}}
                        <li class="nav-item">

                            <a href="{{ route('inventory.accounts') }}" class="nav-link
                            {{ request()->is('admin/inventory/accounts') ? 'active' : '' }}">

                                <i class="fas fa-wallet nav-icon"></i>

                                <p>Accounts Tracking</p>

                            </a>

                        </li>

                    </ul>

                </li>

                @endunless

                @unless(in_array(session('user_role'), ['cashier', 'vendor']))

                {{-- ===================================== --}}
                {{-- CUSTOMER MANAGEMENT --}}
                {{-- ===================================== --}}

                <li class="nav-item has-treeview {{ request()->is('admin/customers*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ request()->is('admin/customers*') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-users"></i>

                        <p>
                            Customer Management
                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        {{-- ALL CUSTOMERS --}}
                        <li class="nav-item">

                            <a href="{{ route('admin.customers.index') }}"
                                class="nav-link {{ request()->is('admin/customers') ? 'active' : '' }}">

                                <i class="fas fa-user-friends nav-icon"></i>

                                <p>All Customers</p>

                            </a>

                        </li>

                        {{-- TOP CUSTOMERS --}}
                        <li class="nav-item">

                            <a href="{{ route('admin.customers.top') }}"
                                class="nav-link {{ request()->is('admin/customers/top') ? 'active' : '' }}">

                                <i class="far fa-star nav-icon"></i>

                                <p>Top Customers</p>

                            </a>

                        </li>

                    </ul>

                </li>

                @endunless

                @unless(session('user_role') === 'vendor')

                <li class="nav-item has-treeview {{ request()->is('admin/orders*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Order Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.new.page') }}"
                                class="nav-link {{ request()->is('admin/orders/new') ? 'active' : '' }}">
                                <i class="fas fa-bell nav-icon"></i>
                                <p>New Orders
                                    <span id="sidebarNewOrderBadge"
                                        class="badge badge-danger badge-sm float-right"
                                        style="display:none;"></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index') }}"
                                class="nav-link {{ request()->is('admin/orders') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Orders</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/accounts*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/accounts*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Accounts Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.accounts.order.history') }}"
                                class="nav-link {{ request()->is('admin/accounts/order-history') ? 'active' : '' }}">
                                <i class="fas fa-history nav-icon"></i>
                                <p>Order History</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @endunless

                @unless(in_array(session('user_role'), ['cashier', 'vendor']))

                <li class="nav-item">
                    <a href="{{ route('admin.ads.index') }}"
                        class="nav-link {{ request()->is('admin/ads*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-images"></i>
                        <p>Ads Management</p>
                    </a>
                </li>

                <li class="nav-item">

                    <a href="{{ route('admin.activity.logs') }}"
                        class="nav-link {{ request()->is('admin/activity-logs*') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-history"></i>

                        <p>History Logs</p>

                    </a>

                </li>

                @endunless

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
    /* Defensive: without this, a submenu mid-toggle (opening/closing on
       hover/click) can visually spill over the next sidebar item instead
       of being clipped to its own collapsed/expanded height. */
    .nav-sidebar > .nav-item {
        position: relative;
    }
    .nav-treeview {
        overflow: hidden;
    }
</style>

