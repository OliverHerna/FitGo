@extends('layouts.crud_views.__index')

@section('title')
Usuarios
@endsection

@section('title')
Usuarios
@endsection

@section('card-title')
Bitácora
@endsection

@section('table-headers')
<td>Fecha</td>
<td>Usuario</td>
<td>Rol</td>
<td>Descripción</td>
<td class="no-sort">Acciones</td>
@endsection

@section('table-rows')
@foreach($logs as $log)
<tr>
    <td class="align-middle">{{ $log->created_at->format('d/m/Y g:i A') }}</td>
    <td class="align-middle">
        @if ($log->user)
        {{ $log->user->first_name }} {{ $log->user->last_name }}
        @else
        Usuario eliminado
        @endif
    </td>
    <td class="align-middle">
        @if ($log->user)
        {{ $log->user->role->name }}
        @else
        Usuario eliminado
        @endif
    </td>
    <td class="align-middle">{{ $log->message }}</td>
    <td class="align-middle">
        @if($log->message == 'Carga de ordenes en el sistema')
                    Creado por el sistema
        @else
            @if ($log->entity->entitiabble)
            <div class="btn-group mt-0" role="group">
                @if($log->entity->entitiabble_type == 'App\Order' ||$log->entity->entitiabble_type =='App\OrderDetail' )
                @else
                    <a href="{{ route($log->entity->resource_name . '.show', $log->entity->entitiabble->id) }}" class="btn" data-toggle="tooltip" data-placement="bottom" title="Ver"><i class="light-font fas fa-eye"></i></a>

                @endif
            </div>
            @else
            Registro eliminado
            @endif
        @endif
    </td>
    </td>
</tr>
@endforeach
@endsection

@push('scripts')
<script>
    $('#dataTable').on('init.dt', function() {
        $('#dataTable').DataTable().order([0, "desc"]).draw();
    });
</script>
@endpush
