@extends('layouts.crud_views.__show')

@section('title')
Paquetes
@endsection

@section('option')
<a href="{{ route('paquetes.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-left fa-sm text-white-50"></i> Ver Paquetes
</a>
@endsection

@section('card-size')
col-lg-6
@endsection

@section('card-title')
{{ $paquete->name }}
@endsection

@section('card-list')
<li class="list-group-item">Nombre: {{ $paquete->name }} </li>
<li class="list-group-item">Horas Totales: {{ $paquete->total_hours }}</li>
<li class="list-group-item">Beneficios: {{ $paquete->benefit_id }}</li>
@if ($paquete->updated_at && $paquete->updated_at != $paquete->created_at)
<li class="list-group-item">Fecha de actualización: {{ $paquete->updated_at->format('d-m-Y') }}</li>
<li class="list-group-item">
    Actualizado por: {{ $paquete->entity->logs()->latest()->first()->user->first_name . ' ' . $paquete->entity->logs()->latest()->first()->user->last_name }}
</li>
@endif
@endsection

@section('card-action')
{{ route('paquetes.edit', $paquete) }}
@endsection
