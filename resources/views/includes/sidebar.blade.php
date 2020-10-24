    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('images/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name', 'POS') }}</span>
    </a>
  
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ Auth::user()->getAvatar() ?? '' }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->getName() ?? '' }}</a>
          </div>
        </div>
  
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview">
              <a href="/admin" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="{{ route('employees.index') }}" class="nav-link {{ activeSegment('employees') }}">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                  Employees
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="{{ route('products.index') }}" class="nav-link {{ activeSegment('products') }}">
                <i class="nav-icon fas fa-th-large text-dark"></i>
                <p>
                  Products
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="{{ route('cart.index') }}" class="nav-link {{ activeSegment('cart') }}">
                <i class="nav-icon fas fa-cart-plus text-dark"></i>
                <p>
                  P.O.S
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="{{ route('orders.index') }}" class="nav-link {{ activeSegment('orders') }}">
                <i class="nav-icon fas fa-cart-plus text-dark"></i>
                <p>
                  Orders
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="{{ route('customers.index') }}" class="nav-link {{ activeSegment('customers') }}">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Customer
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="{{ route('settings.index') }}" class="nav-link {{ activeSegment('settings') }}">
                <i class="nav-icon fas fa-cogs text-dark"></i>
                <p>
                  Settings
                </p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link" onclick="document.getElementById('logout__form').submit()">
                <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                <p>
                  Logout
                </p>
                <form action="{{ route('logout') }}" method="POST" id="logout__form">
                  @csrf
                </form>
              </a>
            </li>            
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->