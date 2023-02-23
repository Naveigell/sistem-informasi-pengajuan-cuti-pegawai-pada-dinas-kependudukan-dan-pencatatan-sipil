
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Cuti</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Ct</a>
        </div>
        <ul class="sidebar-menu">
            @if(auth()->user()->role === \App\Models\User::ROLE_ADMIN)
                <li class="menu-header">Home</li>
                <li class="@if (request()->routeIs('admin.dashboard.*')) active @endif"><a class="nav-link" href="{{ route('admin.dashboard.index') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                <li class="menu-header">Users</li>
                <li class="@if (request()->routeIs('admin.employees.*')) active @endif"><a class="nav-link" href="{{ route('admin.employees.index') }}"><i class="fas fa-users"></i> <span>Pegawai</span></a></li>
{{--                <li class="@if (request()->routeIs('*admins*')) active @endif"><a class="nav-link" href="{{ route('admin.admins.index') }}"><i class="fas fa-user"></i> <span>Admin</span></a></li>--}}
{{--                <li class="menu-header">Additional</li>--}}
{{--                <li class="@if (request()->routeIs('*categories*')) active @endif"><a class="nav-link" href="{{ route('admin.categories.index') }}"><i class="fas fa-list"></i> <span>Category</span></a></li>--}}
{{--                <li class="@if (request()->routeIs('*shipping-costs*')) active @endif"><a class="nav-link" href="{{ route('admin.shipping-costs.index') }}"><i class="fas fa-truck"></i> <span>Shipping Cost</span></a></li>--}}
{{--                <li class="menu-header">Product</li>--}}
{{--                <li class="@if (request()->routeIs('*products*')) active @endif"><a class="nav-link" href="{{ route('admin.products.index') }}"><i class="fas fa-shopping-bag"></i> <span>Product</span></a></li>--}}
{{--                <li class="menu-header">Suggestions</li>--}}
{{--                <li class="@if (request()->routeIs('*suggestions*')) active @endif"><a class="nav-link" href="{{ route('admin.suggestions.index') }}"><i class="fas fa-paper-plane"></i> <span>Suggestion</span></a></li>--}}
{{--                <li class="@if (request()->routeIs('*reviews*')) active @endif"><a class="nav-link" href="{{ route('admin.reviews.index') }}"><i class="fas fa-star"></i> <span>Reviews</span></a></li>--}}
{{--                <li class="menu-header">Order & Payment</li>--}}
{{--                <li class="@if (request()->routeIs('*orders*')) active @endif"><a class="nav-link" href="{{ route('admin.orders.index') }}"><i class="fas fa-copy"></i> <span>Order</span></a></li>--}}
{{--                <li class="menu-header">Menu</li>--}}
{{--                <li class="@if (request()->routeIs('*testimonials*')) active @endif"><a class="nav-link" href="{{ route('admin.testimonials.index') }}"><i class="fas fa-hand-paper"></i> <span>Testimonial</span></a></li>--}}
            @else
{{--                <li class="menu-header">Home</li>--}}
{{--                <li class="@if (request()->routeIs('*dashboard*')) active @endif"><a class="nav-link" href="{{ route('admin.dashboard.index') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>--}}
{{--                <li class="menu-header">Users</li>--}}
{{--                <li class="@if (request()->routeIs('*members*')) active @endif"><a class="nav-link" href="{{ route('admin.members.index') }}"><i class="fas fa-users"></i> <span>Member</span></a></li>--}}
{{--                <li class="@if (request()->routeIs('*admins*')) active @endif"><a class="nav-link" href="{{ route('admin.admins.index') }}"><i class="fas fa-user"></i> <span>Admin</span></a></li>--}}
{{--                <li class="menu-header">Reports</li>--}}
{{--                <li class="@if (request()->routeIs('*report*')) active @endif"><a class="nav-link" href="{{ route('admin.report.create') }}"><i class="fas fa-print"></i> <span>Report</span></a></li>--}}
            @endif
        </ul>
    </aside>
</div>
