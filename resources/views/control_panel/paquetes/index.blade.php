@extends('layouts.crud_views.__index')

@section('title')
Paquetes
@endsection

@section('option')
@can('paquetes.create')
<a href="{{ route('paquetes.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Paquete
</a>
@endcan
@endsection

@section('card-title')
Índice de paquetes
@endsection

@section('table-headers')
<td>Nombre</td>
<td>Total de Horas</td>
<td>Beneficio</td>
<td class="no-sort">Acciones</td>
@endsection

@section('table-rows')
@foreach($paquetes as $paquete)
<tr>
    <td>{{ $paquete->name }}</td>
    <td>{{ $paquete->total_hours }}</td>
    <td>
    @isset($paquete->benefit->name)
        {{ $paquete->benefit->name}}
    @endisset
    </td>
    <td>
        <a href="{{ route('paquetes.show', $paquete) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Ver"><i class="light-font fas fa-eye"></i></a>
        @can('paquetes.update', $paquete)
        <a href="{{ route('paquetes.edit', $paquete) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="light-font fas fa-edit"></i></a>
        @endcan
    </td>
</tr>
@endforeach
@endsection
