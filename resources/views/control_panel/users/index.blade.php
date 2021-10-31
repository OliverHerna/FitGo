@extends('layouts.crud_views.__index')

@section('title')
Usuarios
@endsection

@section('option')
@can('users.create')
<a href="{{ route('usuarios.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo usuario
</a>
@endcan
@endsection

@section('card-title')
Índice de usuarios
@endsection

@section('table-headers')
<td>Nombre</td>
<td>Rol</td>
<td>Creado</td>
<td class="no-sort">Acciones</td>
@endsection

@section('table-rows')
@foreach($users as $user)
@if($user->role->id == 1 || $user->role->id ==2)
<tr>
    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
    <td>{{ $user->role->name }}</td>
    <td>{{ $user->created_at->format('d-m-Y') }}</td>
    <td>
        <div class="btn-group mt-0" role="group">
            @if ($user->trashed())
            @can('users.restore', $user)
            <form action="{{ route('usuarios.restore', $user) }}" method="POST">
                @method('PUT')
                @csrf
                <button type="submit" class="btn" data-toggle="tooltip" data-placement="bottom" title="Activar"><i class="light-font fas fa-trash-restore"></i></button>
            </form>
            @endcan
            @can('users.forceDelete', $user)
            <form action="{{ route('usuarios.forceDelete', $user) }}" method="POST">
                @method('PUT')
                @csrf
                <button type="submit" class="btn" data-toggle="tooltip" data-placement="bottom" title="Borrar"><i class="light-font fas fa-ban"></i></button>
            </form>
            @endcan
            @else
            @can('users.view', $user)
            <a href="{{ route('usuarios.show', $user) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Ver"><i class="light-font fas fa-eye"></i></a>
            @endcan
            @if($user->role->id == 3)
            <a href="{{ route('paquete_users.profile', $user) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Perfil"><i class="light-font fas fa-user-circle"></i></a>
            @endif
            @can('users.update', $user)
            <a href="{{ route('usuarios.edit', $user) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="light-font fas fa-edit"></i></a>
            @endcan
            @can('users.delete', $user)
            <form action="{{ route('usuarios.destroy', $user) }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn" data-toggle="tooltip" data-placement="bottom" title="Desactivar"><i class="light-font fas fa-trash"></i></button>
            </form>
            @endcan
            @endif
        </div>
    </td>
</tr>
@endif
@endforeach
@endsection
