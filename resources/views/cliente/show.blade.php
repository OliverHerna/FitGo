@extends('layouts.crud_views.__show')

@section('title'){{$user->company_name}}
@endsection

@section('option')
        @if($user->ActivePackage->first() != NULL)
        @can('orders.create')
        <a href="{{ route('usuarios.create') }}" data-target="#createOrder" data-toggle="modal" data-target=".bd-example-modal-lg" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Crear Orden
        </a>
        @endcan
        @endif
        <button data-toggle="modal" data-target="#historyOrder" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-history fa-sm text-white-50"></i> Historial
        </button>
@endsection

@section('card-size')
col-lg-12
@endsection

@section('card-title')
@endsection

@section('conciliation')
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-2">
                    <h6 class="m-0 font-weight-bold">Datos del Cliente</h6>
                </div>
                <div class="card-body">
                    <label>
                        <strong> Cliente: </strong>{{$user->first_name}} {{$user->last_name}}
                        <strong> Correo: </strong>{{$user->email}}
                        <strong> Telefono: </strong>{{$user->phone}}
                    </label>
                    <input type="hidden" name="" value="">
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    {{-- @foreach($user->paquete_user as $info) --}}
    <div>
        <div class="row" id="paquete_div">
            @if($user->ActivePackage->first() != NULL)
            <div class="col-xl-10 col-lg-10">
                <div class="card shadow mb-4 border-left-info">
                    <div class="card-header py-2">
                        <div class="row">
                            <div class="col-10">
                                <h6 class="m-0 font-weight-bold">{{$user->ActivePackage->first()->paquete->name}}</h6>
                            </div>
                            <div class="col-2 float-right">
                                #{{$user->ActivePackage->first()->id}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="id_paquete">
                        <h6><strong>TOTAL DE HORAS:</strong> {{$user->ActivePackage->first()->paquete->total_hours}}</h6>
                        <h6><strong>FECHA DE EXPIRACIÓN DEL PAQUETE:</strong> {{\Carbon\Carbon::parse($user->ActivePackage->first()->created_at->addYear())->format('d/m/Y')}}</h6>
                    </div>
                    @if ($user->ActivePackage->first()->benefit != NULL)
                    <div class="card-body">
                        <h6><strong>BENEFICIO DE LA ORDEN: </strong>{{$user->ActivePackage->first()->benefit->name}} </h6>
                        <h6><strong>DESCRIPCIÓN DEL BENEFICIO: </strong> {{$user->ActivePackage->first()->benefit->description}}</h6>
                        <h6><strong>FECHA DE EXPIRACIÓN DEL BENEFICIO: </strong> {{$user->ActivePackage->first()->benefit->validity}}</h6>
                    </div>
                    @else
                    <div class="card-body">
                        <h6><strong>ESTE PAQUETE NO CUENTA CON BENEFICIO</strong></h6>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-2">
                    <h6 class="m-0 font-weight-bold text-primary">Horas</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Gastadas  <span class="float-right">{{" ".$user->ActivePackage->first()->HoursSpentPercent}}%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger" role="progressbar text-center" style="width: {{$user->ActivePackage->first()->HoursSpentPercent}}%" aria-valuenow="{{$user->ActivePackage->first()->HoursSpentValue}}" aria-valuemin="0" aria-valuemax="{{$user->ActivePackage->first()->paquete->total_hours}}">{{$user->ActivePackage->first()->HoursSpentValue}}</div>
                    </div>
                    <h4 class="small font-weight-bold">Restantes <span class="float-right"></span> {{$user->ActivePackage->first()->HoursLeftPercent}}%</h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{$user->ActivePackage->first()->HoursLeftPercent}}%" aria-valuenow="{{$user->ActivePackage->first()->HoursLeftPercent}}" aria-valuemin="0" aria-valuemax="{{$user->ActivePackage->first()->paquete->total_hours}}">{{$user->ActivePackage->first()->HoursLeftValue}}</div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-lg-12">
                <div class="card shadow mb-4 border-left-info">
                    <div class="card-body">
                        <h6><strong>ESTE USUARIO NO CUENTA CON PAQUETES ACTIVOS </strong></h6>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    {{-- @endforeach --}}
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Órdenes</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Paquete</th>
                        <th>Horas</th>
                        <th>Fecha de Expedición</th>
                        <th>Agente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Folio</th>
                        <th>Paquete</th>
                        <th>Horas</th>
                        <th>Fecha de Expedición</th>
                        <th>Agente</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                @foreach($user->paquete_user as $info)
                    @foreach ($info->order as $order)
                    <tr>
                        <td>{{ $order->folio }}</td>
                        <td>{{ $info->paquete->name}}&nbsp #{{$info->id}}</td>
                        <td>{{ $order->hours }}</td>
                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                        <td>{{ $order->UserName->first_name." ".$order->UserName->last_name }}</td>
                        <td>
                            <a class="btn btnModalDescription"
                               style="cursor:pointer;"
                               data-value="{{$order->description}}"
                               id="btnModalDescription"
                               name="btnModalDescription"
                               ><i class="light-font fas fa-eye"></i>
                            </a>
                             @can('users.update', $user)
                            <a href="{{ route('orders.edit', $order) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="light-font fas fa-edit"></i></a>
                            @endcan
                        </td>

                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="modalDescription" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Descripción</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p id="modalDescriptionLabel"></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Modal Create Order-->
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
                    <div class="form-group col-lg-4" id="clientLabel" style="display: none">
                        <label for="user"><span>*</span>Cliente</label>
                        <input type="text" class="form-control {{ !$errors->has('user') ?: 'is-invalid' }}" name="user" value="{{$user->id}}">
                        @if ($errors->has('user'))
                        @foreach ($errors->get('user') as $message)
                        <div class="invalid-feedback">{{ $message }}</div>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="description"><span>*</span>Descripción</label>
                        <textarea class="form-control {{ !$errors->has('description') ?: 'is-invalid' }}"  name="description">{{old('description')}}</textarea>
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

@endsection
@push('styles')
@include('layouts.styles.__datatable')
@endpush

@push('scripts')
@include('layouts.scripts.__datatable')
<script>
    $('.btnModalDescription').on('click', function (e) {
        description = $(this).data("value");
        //$('#modalDescriptionLabel').empty();
        $('#modalDescriptionLabel').text(description);
        $('#modalDescription').modal('show');
    });
</script>
@if ($errors->any())
<script>
    $( document ).ready(function() {
        $('#createOrder').modal('show');
    });
</script>
@endif
@endpush

@push('modals')
    <!--id from view profile= 1-->
    <x-history-order :user="$user"  />
@endpush

