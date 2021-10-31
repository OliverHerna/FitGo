@extends('layouts.crud_views.__form')

@section('title')
Beneficios
@endsection

@section('card-title')
Nuevo Beneficios
@endsection

@section('form')
    <form action="{{ route('benefits.store') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group col-lg-6">
                <label for="name"><span>*</span> Nombre del Beneficio</label>
                <input type="text" class="form-control capitalize-input {{ !$errors->has('name') ?: 'is-invalid' }}" name="name" value="{{ old('name') }}" autofocus>
                @if ($errors->has('name'))
                @foreach ($errors->get('name') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
            <div class="form-group col-lg-6">
                <label for="description"><span>*</span> Descripción</label>
                <textarea rows="3" class="form-control {{ !$errors->has('description') ?: 'is-invalid' }}" name="description" >{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                @foreach ($errors->get('description') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-4">
                <label for="validity"><span>*</span> Fecha de Expiración</label>
                <div class="input-group date" data-provide="datepicker">
                    <input type="text" class="form-control {{ !$errors->has('validity') ?: 'is-invalid' }}" name="validity" value="{{ old('validity') }}">
                    @if ($errors->has('validity'))
                    @foreach ($errors->get('validity') as $message)
                    <div class="invalid-feedback">{{ $message }}</div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <input type="text" name="today_date" value="{!! \Carbon\Carbon::now()->format('d/m/Y') !!}" hidden>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection
