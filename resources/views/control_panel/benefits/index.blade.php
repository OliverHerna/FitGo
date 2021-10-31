@extends('layouts.crud_views.__index')

@section('title')
Beneficios
@endsection

@can('benefits.create')
@section('option')
<a href="{{ route('benefits.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Beneficio
</a>
@endsection
@endcan


@section('card-title')
Índice de Beneficios
@endsection

@section('table-headers')
<td>Nombre</td>
<td>Descripción</td>
<td>Fecha de Expiración</td>
<td class="no-sort">Acciones</td>
@endsection

@section('table-rows')
@foreach($benefits as $benefit)
<tr>
    <td>{{ $benefit->name }}</td>
    <td>{{ $benefit->description }}</td>
    <td>{{ \Carbon\Carbon::parse($benefit->validity)->format('d/m/Y')}}</td>
    <td>
        <a href="{{ route('benefits.show', $benefit) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Ver"><i class="light-font fas fa-eye"></i></a>
        @can('benefits.update', $benefit)
        <a href="{{ route('benefits.edit', $benefit) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="light-font fas fa-edit"></i></a>
        @endcan
    </td>
</tr>
@endforeach
@endsection
