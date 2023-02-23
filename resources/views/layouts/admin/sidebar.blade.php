
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Cuti</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Ct</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Home</li>
            <li class="@if (request()->routeIs('admin.dashboard.*')) active @endif"><a class="nav-link" href="{{ route('admin.dashboard.index') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
            <li class="menu-header">Users</li>
            <li class="@if (request()->routeIs('admin.employees.*')) active @endif"><a class="nav-link" href="{{ route('admin.employees.index') }}"><i class="fas fa-users"></i> <span>Pegawai</span></a></li>
            <li class="menu-header">Pengajuan Cuti</li>
            <li class="@if (request()->routeIs('admin.leaves.request.pending.*')) active @endif"><a class="nav-link" href="{{ route('admin.leaves.request.pending.index') }}"><i class="fas fa-clock"></i> <span>Pending</span></a></li>
        </ul>
    </aside>
</div>
