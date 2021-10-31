@extends('layouts.crud_views.__show')

@section('title')
Reportes
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        Clientes
    </div>
    <div class="card-body">
        <h5 class="card-title">Reporte de horas de Clientes</h5>
        <a href="{{ route('clients.reports') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fa fa-table fa-sm text-white-50"></i> Generar Reporte
        </a>
    </div>
</div>
@endsection