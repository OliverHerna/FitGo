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
            @can('users.log')
                <a class="collapse-item" href="{{ route('usuarios.log') }}">Bitácora</a>
            @endcan
        </div>
    </li>
    @endcan
    @can('client_panel')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('clients.index') }}" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            <i class="fa fa-user-plus"></i>
            <span>Clientes</span>
        </a>
    </li>
    @endcan
    @can('paquete_panel')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('paquetes.index') }}" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            <i class="fa fa-shopping-bag"></i>
            <span>Paquetes</span>
        </a>
    </li>
    @endcan
    @can('benefit_panel')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('benefits.index') }}" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
            <i class="fa fa-plus    "></i>
            <span>Beneficios</span>
        </a>
    </li>
    @endcan
    @can('order_panel')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('orders.index') }}" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
            <i class="fa fa-paperclip"></i>
            <span>Ordenes</span>
        </a>
    </li>
    @endcan
    @can('report_panel')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('reports.index') }}" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
            <i class="fa fa-table"></i>
            <span>Reportes</span>
        </a>
    </li>
    @endcan
    @if(Auth::user()->role->id === 3)
    <li class="nav-item">
        <a class="nav-link" target="blank" href="https://global-systems.mx/finalizar-compra/" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-store-alt"></i>
            <span>Comprar paquete</span>
            <i class="fas fa-external-link-alt"></i>

        </a>
        
    </li>
    @endif
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
