<ul class="nxl-navbar">

    @if (Auth::user()->role == 'admin')
        <li class="nxl-item nxl-caption">
            <label>Navigation</label>
        </li>
        <li class="nxl-item {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="nxl-link">
                <span class="nxl-micon"><i class="feather-grid"></i></span>
                <span class="nxl-mtext">Dashboard</span>
            </a>
        </li>
        <li class="nxl-item {{ Request::is('admin/customers*') ? 'active' : '' }}">
            <a href="{{ route('admin.customers.index') }}" class="nxl-link">
                <span class="nxl-micon"><i class="feather-users"></i></span>
                <span class="nxl-mtext">Account</span>
            </a>
        </li>
        <li class="nxl-item {{ Request::is('admin/products*') ? 'active' : '' }}">
            <a href="{{ route('admin.products.index') }}" class="nxl-link">
                <span class="nxl-micon"><i class="feather-package"></i></span>
                <span class="nxl-mtext">Product</span>
            </a>
        </li>
        <li class="nxl-item {{ Request::is('admin/stock*') ? 'active' : '' }}">
            <a href="{{ route('admin.stock.index') }}" class="nxl-link">
                <span class="nxl-micon"><i class="feather-database"></i></span>
                <span class="nxl-mtext">Stock Product</span>
            </a>
        </li>
         <li class="nxl-item {{ Request::is('customer/catalog*') || Request::is('customer/cart*') ? 'active' : '' }}">
            <a href="{{ route('customer.catalog') }}" class="nxl-link">
                <span class="nxl-micon"><i class="feather-book-open"></i></span>
                <span class="nxl-mtext">Catalog</span>
            </a>
        </li>
        <li clas
        <li class="nxl-item {{ Request::is('admin/transaksi*') ? 'active' : '' }}">
            <a href="{{ route('admin.transaksi') }}" class="nxl-link">
                <span class="nxl-micon"><i class="feather-shopping-cart"></i></span>
                <span class="nxl-mtext">Transaction</span>
            </a>
        </li>
        <li class="nxl-item {{ Request::is('admin/nota*') ? 'active' : '' }}">
            <a href="{{ route('admin.nota') }}" class="nxl-link">
                <span class="nxl-micon"><i class="feather-file-text"></i></span>
                <span class="nxl-mtext">Nota Penjualan</span>
            </a>
        </li>
    @endif


    @if (Auth::user()->role == 'user')
        <li class="nxl-item nxl-caption">
            <label>Customer</label>
        </li>
        <li class="nxl-item {{ Request::is('customer/catalog*') || Request::is('customer/cart*') ? 'active' : '' }}">
            <a href="{{ route('customer.catalog') }}" class="nxl-link">
                <span class="nxl-micon"><i class="feather-book-open"></i></span>
                <span class="nxl-mtext">Catalog</span>
            </a>
        </li>
        <li class="nxl-item {{ Request::is('customer/history*') ? 'active' : '' }}">
            <a href="{{ route('customer.history') }}" class="nxl-link">
                <span class="nxl-micon"><i class="feather-clock"></i></span>
                <span class="nxl-mtext">History</span>
            </a>
        </li>
    @endif

</ul>
