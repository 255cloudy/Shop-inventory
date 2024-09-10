<div>
    <!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route("dashboard") }}" class="brand-link">
            <img src="{{  asset('img/B.svg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">BUDDIES</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="{{ route("dashboard") }}" class="nav-link
                        @active(Route::current()->uri, 'dashboard')
                            active
                         @endactive
                    ">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('all_sales') }}" class="nav-link
                         @active(Route::current()->uri, 'sales')
                            active
                            menu-is-opening
                            menu-open
                         @endactive

                    ">
                            <i class="nav-icon fas fa-credit-card"></i>
                            <p>
                                Sales
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route("all_sales") }}" class="nav-link active">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Sales</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("make_sale") }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Make Sale</p>
                                </a>
                            </li>
                        </ul>

                    </li>
                    <li class="nav-item">
                        <a href="{{ route('all-products') }}" class="nav-link
                        @active(Route::current()->uri, 'product')
                            active
                         @endactive
                    ">
                            <i class="nav-icon fas fa-tint"></i>
                            <p>
                                Products
                            </p>
                        </a>
                    </li>
                    @if(Auth::user().su)
                    <li class="nav-item">
                        <a href="{{ route('all-users') }}" class="nav-link
                         @active(Route::current()->uri, 'user')
                            active
                         @endactive}}
                    ">
                         <i class="nav-icon fas fa-users"></i>
                            <p>
                               Users
                           </p>                 </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('all-distributers') }}" class="nav-link
                        @active(Route::current()->uri, 'distributer')
                            active
                         @endactive
                    ">
                            <i class="nav-icon fas fa-car"></i>
                            <p>
                                Distributers
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('all-orders') }}" class="nav-link
                        @active(Route::current()->uri, 'order')
                            active
                         @endactive
                    ">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Orders
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('all-expenses') }}" class="nav-link
                        @active(Route::current()->uri, 'expense')
                            active
                         @endactive
                    ">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>
                                Expenses
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('all-assets') }}" class="nav-link
                        @active(Route::current()->uri, 'asset')
                            active
                         @endactive
                    ">
                            <i class="nav-icon fas fa-landmark"></i>
                            <p>
                                Assets
                            </p>
                        </a>
                    </li>
                     @if(Auth::user().su) 
                    <li class="nav-item">
                        <a href="{{ route('all-stock') }}" class="nav-link
                        @active(Route::current()->uri, 'stock')
                            active
                         @endactive
                    ">
                            <i class="nav-icon fas fa-industry"></i>
                            <p>
                                Stock
                            </p>
                        </a>

                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('all-prices') }}" class="nav-link
                        @active(Route::current()->uri, 'price')
                            active
                         @endactive
                    ">
                            <i class="nav-icon fas fa-money-check"></i>
                            <p>
                                Prices
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link
                        @active(Route::current()->uri, 'report')
                            active
                            menu-is-opening
                            menu-open
                         @endactive
                    ">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Reports
                            </p>
                        </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route("base-sales") }}" class="nav-link
                                    @if(Route::current()->uri == "report/sales")
                                        active
                                     @endif
                                    "
                                    >
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sale Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route("profit") }}" class="nav-link
                                     @if(Route::current()->uri == "report/profit")
                                        active
                                     @endif">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Profit/Loss Reports</p>
                                    </a>
                                </li>

                            </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</div>
