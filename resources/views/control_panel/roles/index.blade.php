@extends('layouts.crud_views.__index')

@section('title')
Roles
@endsection

@section('option')
@can('roles.create')
<a href="{{ route('roles.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo rol
</a>
@endcan
@endsection

@section('card-title')
Índice de roles
@endsection

@section('table-headers')
<td>Rol</td>
<td class="no-sort">Acciones</td>
@endsection

@section('table-rows')
@foreach ($roles as $role)
<tr>
    <td>{{ $role->name }}</td>
    <td>
        <div class="btn-group mt-0" role="group">
            @if ($role->trashed())
            @can('roles.restore', $role)
            <form action="{{ route('roles.restore', $role) }}" method="POST"> 
                @method('PUT')
                @csrf
                <button type="submit" class="btn" data-toggle="tooltip" data-placement="bottom" title="Activar"><i class="fas fa-trash-restore"></i></button>
            </form>
            @endcan
            @can('roles.forceDelete', $role)
            <form action="{{ route('roles.forceDelete', $role) }}" method="POST"> 
                @method('PUT')
                @csrf
                <button type="submit" class="btn" data-toggle="tooltip" data-placement="bottom" title="Borrar"><i class="fas fa-ban"></i></button>
            </form>
            @endcan
            @else
            @can('roles.view', $role)
            <a href="{{ route('roles.show', $role) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Ver"><i class="fas fa-eye"></i></a>
            @endcan
            @can('roles.update', $role)
            <a href="{{ route('roles.edit', $role) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="fas fa-edit"></i></a>
            @endcan
            @can('roles.delete', $role)
            <form action="{{ route('roles.destroy', $role) }}" method="POST"> 
                @method('DELETE')
                @csrf
                <button type="submit" class="btn" data-toggle="tooltip" data-placement="bottom" title="Desactivar"><i class="fas fa-trash"></i></button>
            </form>
            @endcan
            @endif
        </div>
    </td>
</tr>
@endforeach
@endsection
