@extends('layouts.crud_views.__form')

@section('title')
Paquetes
@endsection

@section('option')
<a href="{{ route('paquetes.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-left fa-sm text-white-50"></i> Ver Paquetes
</a>
@endsection

@section('card-title')
Editar Paquete
@endsection

@section('form')
    <form action="{{ route('paquetes.update', $paquete) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-row">
            <div class="form-group col-lg-4">
                <label for="name"><span>*</span> Nombre</label>
                <input type="text" class="form-control {{ !$errors->has('name') ?: 'is-invalid' }}" name="name" value="{{ $paquete->name }}">
                @if ($errors->has('name'))
                @foreach ($errors->get('name') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
            <div class="form-group col-lg-4">
                <label for="total_hours"><span>*</span> Total de Horas</label>
                <input type="text" class="form-control {{ !$errors->has('total_hours') ?: 'is-invalid' }}" name="total_hours" value="{{ $paquete->total_hours }}">
                @if ($errors->has('total_hours'))
                @foreach ($errors->get('total_hours') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
            <div class="form-group col-lg-4">
                <label for="benefit"><span>*</span> Beneficios</label>
                <select class="form-control {{ !$errors->has('benefit') ?: 'is-invalid' }}" name="benefit">
                    {{-- @isset($paquete->benefit)
                        <option selected value="{{ $paquete->benefit->id }}" {{ old('benefit') != $paquete->benefit->id ?: 'selected' }}>
                            {{ $paquete->benefit->name }}
                        </option>
                    @endisset --}}
                    <option value="no_benefit">Sin Beneficio</option>
                    @foreach ($benefits as $benefit)
                    @if($benefit->validity >= now()->toDateString())
                    <option value="{{ $benefit->id }}"

                        @php
                            if (isset($paquete->benefit)) {
                               if ($paquete->benefit->id == $benefit->id) {
                                  echo('selected');
                               }
                            }
                        @endphp
                        >{{ $benefit->name }}</option>
                        @endif
                    @endforeach
                </select>
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
