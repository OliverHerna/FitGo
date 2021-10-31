@extends('layouts.crud_views.__show')

@section('title')
Beneficios
@endsection

@section('option')
<a href="{{ route('benefits.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-left fa-sm text-white-50"></i> Ver Beneficios
</a>
@endsection

@section('card-size')
col-lg-6
@endsection

@section('card-title')
{{ $benefit->name }}
@endsection

@section('card-list')
<li class="list-group-item">Nombre: {{ $benefit->name }} </li>
<li class="list-group-item">Descripción: {{ $benefit->description }}</li>
<li class="list-group-item">Fecha de expiración: {!! \Carbon\Carbon::parse($benefit->validity)->format('d/m/Y') !!}</li>
@if ($benefit->updated_at && $benefit->updated_at != $benefit->created_at)
<li class="list-group-item">Fecha de actualización: {{ $benefit->updated_at->format('d/m/Y') }}</li>
<li class="list-group-item">
    Actualizado por: {{ $benefit->entity->logs()->latest()->first()->user->first_name . ' ' . $benefit->entity->logs()->latest()->first()->user->last_name }}
</li>
@endif
@endsection

@section('card-action')
{{ route('benefits.edit', $benefit) }}
@endsection
