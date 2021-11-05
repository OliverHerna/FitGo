<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a href="{{ route('home') }}" class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <i class="fas fa-satellite"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Asesorias Premium') }}</div>
    </a>
    <hr class="sidebar-divider my-0">
    @can('control_panel')
    <div class="sidebar-heading">Panel de control</div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            @can('users.index')
                <a class="collapse-item" href="{{ route('usuarios.index') }}">Índice</a>
            @endcan
            @can('roles.index')
                <a class="collapse-item" href="{{ route('roles.index') }}">Roles</a>
            @endcan
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users"></i>
            <span>Pagos</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            @can('users.index')
                <a class="collapse-item" href="{{ route('usuarios.index') }}">Índice</a>
            @endcan
            @can('roles.index')
                <a class="collapse-item" href="{{ route('roles.index') }}">Asignar Pagos</a>
            @endcan
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('scheadule.calendar') }}" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            <i class="fa fa-shopping-bag"></i>
            <span>Actividades</span>
        </a>
    </li>
    @endcan
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
