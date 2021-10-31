@extends('layouts.crud_views.__form')

@section('title')
Beneficios
@endsection

@section('option')
<a href="{{ route('benefits.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-left fa-sm text-white-50"></i> Ver Beneficios
</a>
@endsection

@section('card-title')
Editar Beneficio
@endsection

@section('form')
    <form action="{{ route('benefits.update', $benefit) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-row">
            <div class="form-group col-lg-6">
                <label for="name"><span>*</span> Nombre del Beneficio</label>
                <input type="text" class="form-control capitalize-input {{ !$errors->has('name') ?: 'is-invalid' }}" name="name" value="{{ $benefit->name }}" autofocus>
                @if ($errors->has('name'))
                @foreach ($errors->get('fname') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
            <div class="form-group col-lg-6">
                <label for="description"><span>*</span> Descripción</label>
                <textarea rows="3" class="form-control {{ !$errors->has('description') ?: 'is-invalid' }}" name="description" value="{{ old('description') }}">{{$benefit->description}}</textarea>
                @if ($errors->has('description'))
                @foreach ($errors->get('description') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-lg-4">
                <label for="validity"><span>*</span>Fecha de Expiración</label>
                <div class="input-group date" data-provide="datepicker">
                    <input type="text" class="form-control {{ !$errors->has('validity') ?: 'is-invalid' }}" name="validity" value="{!! \Carbon\Carbon::parse($benefit->validity)->format('m/d/Y') !!}">
                    @if ($errors->has('validity'))
                    @foreach ($errors->get('validity') as $message)
                    <div class="invalid-feedback">{{ $message }}</div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <input type="text" name="today_date" value="{!!\Carbon\Carbon::now()->format('d/m/Y')!!}" hidden>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@endsection
