@extends('layouts.crud_views.__form')

@section('title')
Paquetes
@endsection

@section('card-title')
Nuevo Paquete
@endsection

@section('form')
    <form action="{{ route('paquetes.store') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group col-lg-4">
                <label for=""><span>*</span> Nombre</label>
                <input type="name" class="form-control {{ !$errors->has('name') ?: 'is-invalid' }}" name="name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                @foreach ($errors->get('name') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
            <div class="form-group col-lg-4">
                <label for="total_hours"><span>*</span> Total de Horas</label>
                <input type="text" class="form-control {{ !$errors->has('total_hours') ?: 'is-invalid' }}" name="total_hours" value="{{ old('total_hours') }}">
                @if ($errors->has('total_hours'))
                @foreach ($errors->get('total_hours') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
            <div class="form-group col-lg-4">
                <label for="benefit"><span>*</span> Beneficios</label>
                <select class="form-control {{ !$errors->has('benefit') ?: 'is-invalid' }}" name="benefit">
                    <option disabled selected value>Selecciona un Beneficio</option>
                    <option value="no_benefit">Sin Beneficio</option>
                    @foreach ($benefits as $benefit)
                    @if($benefit->validity >= now()->toDateString())
                    <option value="{{ $benefit->id }}" {{ old('benefit') != $benefit->id ?: 'selected' }}>{{ $benefit->name }}</option>
                    @endif
                    @endforeach
                </select>
                @if ($errors->has('benefit'))
                @foreach ($errors->get('benefit') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
            @if ($errors->has('benefit'))
            @foreach ($errors->get('benefit') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection
