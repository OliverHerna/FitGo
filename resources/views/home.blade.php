@extends('layouts.crud_views.__show')

@section('title')
¡Bienvenido!
@endsection

@section('content')
@include('layouts.__message_info')
<div class="container">

    <div class="row">
        @can('paquetes.create')
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <a href="{{route('paquetes.create')}}" style="cursor:pointer;" >
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Crear paquetes</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
        @endcan
        @can('orders.create')
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <a style="cursor:pointer;" data-toggle="modal" data-target="#createOrder">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Crear orden</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-paperclip fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan
        <!-- Pending Requests Card Example -->
        @can('paquetes.create')
        <div  class="col-xl-4 col-md-6 mb-4">
            <a style="cursor:pointer;" data-toggle="modal" data-target="#assignPackage">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div   class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Asignar paquete</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                            <i class="fas fa-shopping-bag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
        @endcan
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Clientes</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Compañia</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Horas Totales</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Compañia</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Horas Totales</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                    @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->company_name }}</td>
                                <td>{{ $client->first_name}} {{$client->last_name}}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->email }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning" data-toggle="tooltip" data-html="true" data-placement="top"
                                    title="
                                        @if ($client->ActivePackage->first() != NULL)
                                        @foreach ($client->ActivePackage as $info)
                                            @if ($client->ActivePackage->first()->id == $info->id)
                                            <strong>Paquete Activo:</strong> {{$info->paquete->name}} ({{$client->ActivePackage->first()->HoursLeftValue}} horas)<br>
                                            @else
                                            Paquete: {{$info->paquete->name}}({{$info->paquete->total_hours}} horas)<br>
                                            @endif
                                        @endforeach
                                        @else
                                        No tiene paquetes activos
                                        @endif
                                    ">
                                        {{ isset($client->ActivePackage->first()->HoursSpentValue) ?  $client->getTotalPackagesHoursAttribute($client) - $client->ActivePackage->first()->HoursSpentValue : $client->getTotalPackagesHoursAttribute($client)}}</td>
                                    </button>
                                <td class="text-center">
                                    <a href="{{ route('paquete_users.profile', $client) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Perfil"><i class="light-font fas fa-user-circle"></i></a>
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('modals')
<div id="assignPackage" class="modal fade bd-example-modal-lg
@php
    if ($errors->has('client') || $errors->has('package'))
        echo('errorBack');
@endphp
" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Asignar paquete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form action="{{ route('packageClient') }}" method="POST">
               @csrf
               <div class="form-row">
                  <div class="form-group col-lg-6">
                     <label for="paquete_user"><span>*</span>Cliente</label>
                     <select class="form-control {{ !$errors->has('client') ?: 'is-invalid' }}" name="client">
                        <option disabled selected value>Selecciona cliente</option>
                        @foreach ($clients as $client)
                        <option value="{{$client->id}}" {{ old('client') != $client->id ?: 'selected' }}>{{ $client->company_name}}</option>
                        @endforeach
                     </select>
                     @if ($errors->has('client'))
                     @foreach ($errors->get('client') as $message)
                     <div class="invalid-feedback">{{ $message }}</div>
                     @endforeach
                     @endif
                  </div>
                  <div class="form-group col-lg-6">
                     <label for="paquete_user"><span>*</span>Paquete</label>
                     <select class="form-control {{ !$errors->has('package') ?: 'is-invalid' }}" name="package">
                        <option disabled selected value>Selecciona cliente</option>
                        @foreach ($packages as $package)
                        <option value="{{$package->id}}" {{ old('package') != $package->id ?: 'selected' }}>{{ $package->name}}</option>
                        @endforeach
                     </select>
                     @if ($errors->has('package'))
                     @foreach ($errors->get('package') as $message)
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

<!--Any Other View Id = 0-->
<div id="createOrder" class="modal fade bd-example-modal-lg
    @php
    if ($errors->has('folio') || $errors->has('hours') || $errors->has('user') || $errors->has('description'))
        echo('errorBack');
    @endphp
" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear Orden</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">

            <form action="{{ route('orders.store') }}" method="POST">
               @csrf
               <div class="form-row">
                  @if($viewId != 1)
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
                  <div class="form-group col-lg-4" id="clientLabel" style="display: block">
                     <label for="user"><span>*</span>Cliente</label>
                     <select class="form-control {{ !$errors->has('user') ?: 'is-invalid' }}" name="user">
                        <option disabled selected value>Selecciona el Cliente</option>
                        @foreach ($clients as $client)
                        @if ($client->ActivePackage->first() != NULL)
                        <option value="{{$client->id}}" {{ old('user') != $client->id ?: 'selected' }}>{{ $client->company_name}}</option>
                        @endif
                        @endforeach
                     </select>
                     @if ($errors->has('user'))
                     @foreach ($errors->get('user') as $message)
                     <div class="invalid-feedback">{{ $message }}</div>
                     @endforeach
                     @endif
                  </div>
                  @else
                  <div class="form-group col-lg-6">
                     <label for=""><span>*</span>Folio</label>
                     <input type="text" class="form-control {{ !$errors->has('folio') ?: 'is-invalid' }}" name="folio" value="{{ old('folio') }}">
                     @if ($errors->has('folio'))
                     @foreach ($errors->get('folio') as $message)
                     <div class="invalid-feedback">{{ $message }}</div>
                     @endforeach
                     @endif
                  </div>
                  <div class="form-group col-lg-6">
                     <label for="hours"><span>*</span>Horas</label>
                     <input type="number" step=".25" min=".25" class="form-control {{ !$errors->has('hours') ?: 'is-invalid' }}" name="hours" value="{{ old('hours') }}">
                     @if ($errors->has('hours'))
                     @foreach ($errors->get('hours') as $message)
                     <div class="invalid-feedback">{{ $message }}</div>
                     @endforeach
                     @endif
                  </div>
                  @endif
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
@endpush

@push('styles')
@include('layouts.styles.__datatable')
@endpush
@push('scripts')
@include('layouts.scripts.__datatable')
@if ($errors->any())
<script>
    $( document ).ready(function() {
        $('.errorBack').modal('show');
    });
</script>
@endif
@endpush
