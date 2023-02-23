
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
            <li class="@if (request()->routeIs('employee.dashboard.*')) active @endif"><a class="nav-link" href="{{ route('employee.dashboard.index') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
            <li class="menu-header">Pengajuan</li>
            <li class="@if (request()->routeIs('employee.leaves.*')) active @endif"><a class="nav-link" href="{{ route('employee.leaves.index') }}"><i class="fas fa-envelope-open"></i> <span>Cuti</span></a></li>
        </ul>
    </aside>
</div>
