@extends('layouts.crud_views.__show')

@section('title')
Roles
@endsection

@section('option')
<a href="{{ route('roles.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-left fa-sm text-white-50"></i> Índice
</a>
@endsection

@section('card-size')
col-lg-10
@endsection

@section('card-title')
{{ $role->name }}
@endsection

@section('card-list')
@foreach ($modules as $module)
<li class="list-group-item">
    <div class="row">
        <div class="col-lg-2">
            <strong>{{ ucwords(__('modules.' . strtolower($module->name))) }}</strong>
        </div>
        <div class="col-lg-10">
            |
            @php
            $permission = $module->permissions()->where('role_id', $role->id)->first(); 
            $actions = explode(",", $module->actions);
            @endphp
            @if ($actions[0] == 1)
            <span class="role-show-permission">{{ ucwords(__('permissions.view')) }} <i class="fa fa-{{ isset($permission) && $permission->view == 1 ? 'check' : 'times' }}"></i> | </span>
            @endif
            @if ($actions[1] == 1)
            <span class="role-show-permission">{{ ucwords(__('permissions.create')) }} <i class="fa fa-{{ isset($permission) && $permission->create == 1 ? 'check' : 'times' }}"></i> | </span>
            @endif
            @if ($actions[2] == 1)
            <span class="role-show-permission">{{ ucwords(__('permissions.update')) }} <i class="fa fa-{{ isset($permission) && $permission->update == 1 ? 'check' : 'times' }}"></i> | </span>
            @endif
            @if ($actions[3] == 1)
            <span class="role-show-permission">{{ ucwords(__('permissions.delete')) }} <i class="fa fa-{{ isset($permission) && $permission->delete == 1 ? 'check' : 'times' }}"></i> | </span>
            @endif
            @if ($actions[4] == 1)
            <span class="role-show-permission">{{ ucwords(__('permissions.restore')) }} <i class="fa fa-{{ isset($permission) && $permission->restore == 1 ? 'check' : 'times' }}"></i> | </span>
            @endif
            @if ($actions[5] == 1)
            <span class="role-show-permission">{{ ucwords(__('permissions.force_delete')) }} <i class="fa fa-{{ isset($permission) && $permission->force_delete == 1 ? 'check' : 'times' }}"></i> | </span>
            @endif
            @if ($actions[6] == 1)
            <span class="role-show-permission">{{ ucwords(__('permissions.log')) }} <i class="fa fa-{{ isset($permission) && $permission->log == 1 ? 'check' : 'times' }}"></i> | </span>
            @endif
        </div>
    </div>
</li>
@endforeach
<li class="list-group-item">Fecha de creación: {{ $role->created_at->format('d-m-Y') }}</li>
<li class="list-group-item">Fecha de actualización: {{ $role->updated_at->format('d-m-Y') }}</li>
@endsection

@section('card-action')
{{ route('roles.edit', $role) }}
@endsection
