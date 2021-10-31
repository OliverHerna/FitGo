@extends('layouts.crud_views.__form')

@section('title')
Ordenes
@endsection

@section('option')
<a href="{{route('paquete_users.profile', $order->paquete_users->users)}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-left fa-sm text-white-50"></i> Perfil del Usuario
</a>
@endsection

@section('card-title')
Editar Orden
@endsection

@section('form')
    <form action="{{ route('orders.update', $order) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-row">
            <div class="form-group col-lg-6">
                <label for=""><span>*</span>Folio</label>
                <input type="text" class="form-control {{ !$errors->has('folio') ?: 'is-invalid' }}" name="folio" value="{{ $order->folio }}">
                @if ($errors->has('folio'))
                @foreach ($errors->get('folio') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
            <div class="form-group col-lg-6">
                <label for="hours"><span>*</span>Horas</label>
                <input type="number" step=".25" min=".25" class="form-control {{ !$errors->has('hours') ?: 'is-invalid' }}" name="hours" value="{{ $order->hours }}">
                @if ($errors->has('hours'))
                @foreach ($errors->get('hours') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
            <!--Save the previous hours from the package-->
            <input type="hidden" name="previousHours" value="{{$order->hours}}">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection
