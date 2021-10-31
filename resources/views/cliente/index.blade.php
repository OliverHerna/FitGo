@extends('layouts.crud_views.__index')

@section('title')
Clientes
@endsection

@section('option')
@can('clients.create')
<a href="{{ route('clients.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Cliente
</a>
@endcan
@endsection

@section('card-title')
Índice de Clientes
@endsection

@section('table-headers')
    <td>Compañia</td>
    <td>Nombre</td>
    <td>Teléfono</td>
    <td>E-Mail</td>
    <td class="no-sort">Acciones</td>
@endsection

@section('table-rows')
    @foreach ($clients as $client)
    <tr>
        <td>{{$client->company_name}}</td>
        <td>{{$client->first_name}} {{$client->last_name}}</td>
        <td>{{$client->phone }}</td>
        <td>{{$client->email}}</td>
        <td>
            <div class="btn-group mt-0" role="group">
                @if ($client->trashed())
                @can('users.restore', $client)
                <form action="{{ route('usuarios.restore', $client) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <button type="submit" class="btn" data-toggle="tooltip" data-placement="bottom" title="Activar"><i class="light-font fas fa-trash-restore"></i></button>
                </form>
                @endcan
                @can('users.forceDelete', $client)
                <form action="{{ route('usuarios.forceDelete', $client) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <button type="submit" class="btn" data-toggle="tooltip" data-placement="bottom" title="Borrar"><i class="light-font fas fa-ban"></i></button>
                </form>
                @endcan
                @else
                @can('clients.view', $client)
                <a href="{{ route('usuarios.show', $client) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Ver"><i class="light-font fas fa-eye"></i></a>
                @endcan
                @can('paquete_users.profile', $client)    
                <a href="{{ route('paquete_users.profile', $client) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Perfil"><i class="light-font fas fa-user-circle"></i></a>
                @endcan
                @can('clients.update', $client)
                <a href="{{ route('usuarios.edit', $client) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="light-font fas fa-edit"></i></a>
                @endcan
                @can('users.delete', $client)
                <form action="{{ route('usuarios.destroy', $client) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn" data-toggle="tooltip" data-placement="bottom" title="Desactivar"><i class="light-font fas fa-trash"></i></button>
                </form>
                @endcan
                @endif
            </div>
        </td>
    </tr>
    @endforeach
@endsection
