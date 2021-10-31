@extends('layouts.crud_views.__show')
<p style="display: none">{{$routeOrigin = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName()}}</p>

@section('title')
@if ($routeOrigin == 'clients.create' || $routeOrigin == 'clients.index')
Clientes
@else
Usuarios
@endif

@endsection

@section('option')
@if ($routeOrigin == 'clients.create' || $routeOrigin == 'clients.index')
<a href="{{ route('clients.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-left fa-sm text-white-50"></i> Índice de Clientes
</a>
@else
<a href="{{ route('usuarios.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-left fa-sm text-white-50"></i> Índice de Usuarios
</a>
@endif
@endsection

@section('card-size')
col-lg-6
@endsection

@section('card-title')
{{ $user->first_name }} {{ $user->last_name }}
@endsection

@section('card-list')
<li class="list-group-item">Nombre: {{ $user->first_name }} {{ $user->last_name }}</li>
<li class="list-group-item">Correo electrónico: {{ $user->email }}</li>
<li class="list-group-item">Teléfono: {{ $user->phone }}</li>
<li class="list-group-item">Rol: {{ $user->role->name }}</li>
@if ($user->can('orders.index'))
<li class="list-group-item">Sector de clientes: {{ $user->client_code_group == 0 ? ucwords(__('modules.user_settings.client_code_group.0')) : $user->client_code_group }}</li>
@endcan
@if ($user->company_name != NULL)
<li class="list-group-item">Nombre de la Compañia: {{ $user->company_name }}</li>
@endif
@if ($user->has('entity')->first() && $user->id != 1 && $user->id != 2 && $user->id != 3)
<li class="list-group-item">Fecha de creación: {{ $user->created_at->format('d-m-Y') }}</li>
<li class="list-group-item">
    Creado por: {{ $user->entity->logs()->oldest()->first()->user->first_name . ' ' . $user->entity->logs()->oldest()->first()->user->last_name }}
</li>
@else
<li class="list-group-item">Generado por el sistema</li>
@endif
@if ($user->updated_at && $user->updated_at != $user->created_at)
<li class="list-group-item">Fecha de actualización: {{ $user->updated_at->format('d-m-Y') }}</li>
<li class="list-group-item">
    Actualizado por: {{ $user->entity->logs()->latest()->first()->user->first_name . ' ' . $user->entity->logs()->latest()->first()->user->last_name }}
</li>
@endif
@endsection

@section('card-action')
{{ route('usuarios.edit', $user) }}
@endsection
