@extends('layouts.crud_views.__index')

@section('title')
Ordenes
@endsection

@section('option')
@can('orders.create')
<a href="{{ route('usuarios.create') }}" data-toggle="modal" data-target=".bd-example-modal-lg" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50"></i> Crear Orden
</a>
@endcan
@endsection

@section('card-title')
Índice de Ordenes
@endsection

@section('table-headers')
<td>Folio</td>
<td>Compañia</td>
<td>Paquete</td>
<td>Horas</td>
<td>Fecha de Expedición</td>
<td>Agente</td>
<td>Acciones</td>
@endsection

@section('table-rows')
@foreach($orders as $order)
<tr>
    <td>{{ $order->folio }}</td>
    <td>{{ $order->paquete_users->users->company_name }}</td>
    <td>{{ $order->paquete_users->paquete->name }}</td>
    <td>{{ $order->hours }}</td>
    <td>{{ $order->UserName->first_name." ".$order->UserName->last_name }}</td>
    <td>{{ $order->created_at->format('d-m-Y') }}</td>
    <td>
        <div class="btn-group mt-0" role="group">
            <a href="{{ route('paquete_users.profile', $order->paquete_users->users) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Perfil"><i class="light-font fas fa-user-circle"></i></a>
            @can('users.update', Auth::user())
            <a href="{{ route('orders.edit', $order) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="light-font fas fa-edit"></i></a>
            @endcan
            @can('orders.delete', $order)
            <form action="{{ route('orders.destroy', $order) }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn" data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i class="light-font fas fa-trash"></i></button>
            </form>
            @endcan
        </div>
    </td>
</tr>
@endforeach
@endsection

<div id="createOrder" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear Orden </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-lg-4">
                        <label for=""><span>*</span>Folio</label>
                        <input type="text" class="form-control {{ !$errors->has('folio') ?: 'is-invalid' }}" name="folio" value="{{ old('folio') }}">
                        @if ($errors->has('folio'))
                        @foreach ($errors->get('folio') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="hours"><span>*</span>Horas</label>
                        <input type="number" step=".25" min=".25" class="form-control {{ !$errors->has('hours') ?: 'is-invalid' }}" name="hours" value="{{ old('hours') }}">
                        @if ($errors->has('hours'))
                        @foreach ($errors->get('hours') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group col-lg-4" id="clientLabel">
                        <label for="user"><span>*</span>Cliente</label>
                        <select class="form-control {{ !$errors->has('user') ?: 'is-invalid' }}" name="user">
                            <option disabled selected value>Selecciona el Cliente</option>
                            @foreach ($users as $user)
                            @if ($user->ActivePackage->first() != NULL)
                            <option value="{{$user->id}}" {{ old('user') != $user->id ?: 'selected' }}>{{ $user->company_name}}</option>
                            @endif
                            @endforeach
                        </select>
                        @if ($errors->has('user'))
                        @foreach ($errors->get('user') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="description"><span>*</span>Descripción</label>
                        <textarea class="form-control {{ !$errors->has('description') ?: 'is-invalid' }}"  name="description">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                        @foreach ($errors->get('description') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
      </div>
    </div>
</div>

@push('scripts')
@if ($errors->any())
<script>
    $( document ).ready(function() {
        $('#createOrder').modal('show');
    });
</script>
@endif
@endpush

