@extends('layouts.crud_views.__form')

@section('title')
Usuarios
@endsection

@section('option')
<a href="{{ route('usuarios.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-left fa-sm text-white-50"></i> Regresar
</a>
@endsection

@section('card-title')
Nuevo usuario
@endsection

@section('form')
<form action="{{ route('usuarios.store') }}" method="POST">
    @csrf
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="first_name"><span>*</span> Nombre(s)</label>
            <input type="text" class="form-control capitalize-input {{ !$errors->has('first_name') ?: 'is-invalid' }}" name="first_name" value="{{ old('first_name') }}" autofocus>
            @if ($errors->has('first_name'))
            @foreach ($errors->get('first_name') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
        <div class="form-group col-lg-6">
            <label for="last_name"><span>*</span> Apellido paterno</label>
            <input type="text" class="form-control capitalize-input {{ !$errors->has('last_name') ?: 'is-invalid' }}" name="last_name" value="{{ old('last_name') }}">
            @if ($errors->has('last_name'))
            @foreach ($errors->get('last_name') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-4">
            <label for="email"><span>*</span> Correo electrónico</label>
            <input type="email" class="form-control {{ !$errors->has('email') ?: 'is-invalid' }}" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
            @foreach ($errors->get('email') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
        <div class="form-group col-lg-4">
            <label for="phone"><span>*</span> Teléfono</label>
            <input type="text" class="form-control {{ !$errors->has('phone') ?: 'is-invalid' }}" name="phone" value="{{ old('phone') }}">
            @if ($errors->has('phone'))
            @foreach ($errors->get('phone') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
        <div class="form-group col-lg-4">
            <label for="role"><span>*</span> Rol</label>
            <select class="form-control {{ !$errors->has('role') ?: 'is-invalid' }} {{ !$errors->has('company_name') ?: 'is-invalid' }}" name="role" id="role" onchange="clientComp()" onchange="clientPsw()">
                <option disabled selected value>Selecciona un rol</option>
                @foreach ($roles as $role)
                @if ($role->id != 3)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endif
                @endforeach
            </select>
            @if ($errors->has('role'))
            @foreach ($errors->get('role') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
            @if ($errors->has('company_name'))
            @foreach ($errors->get('company_name') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-lg-4" id="password_field" style="display: block">
            <label for="password"><span>*</span> Contraseña</label>
            <input type="password" class="form-control {{ !$errors->has('password') ?: 'is-invalid' }}" name="password" id="password" placeholder="Debe de contener mínimo 8 caracteres">
            @if ($errors->has('password'))
            @foreach ($errors->get('password') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
        <div class="form-group col-lg-4" id="password_conf_field" style="display: block">
            <label for="password_confirmation">Confirma la contraseña</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="********">
        </div>
        <div class="form-group col-lg-4" name="company_name_field" id="company_name_field"  style="display:none">
            <label for="company_name"><span>*</span> Nombre de la compañia</label>
            <input type="text" class="form-control"  name="company_name" id="company_name">
        </div>
        <div class="form-group col-lg-4" id="paquete_field" style="display: none">
            <label for="paquete"><span>*</span> Paquete</label>
            <select class="form-control {{ !$errors->has('paquete') ?: 'is-invalid' }}" name="paquete" id="paquete">
                <option disabled selected value>Selecciona un Paquete</option>
                <option value="">Sin Paquete</option>
                @foreach ($paquetes as $paquete)
                <option value="{{ $paquete->id }}" {{ old('paquete') != $paquete->id ?: 'selected' }}>{{ $paquete->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('paquete'))
            @foreach ($errors->get('paquete') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection

<script src="{{ asset('js/formCreateUser.js') }}"></script>

