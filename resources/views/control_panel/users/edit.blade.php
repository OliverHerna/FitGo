@extends('layouts.crud_views.__form')

@section('title')
Usuarios
@endsection

@section('option')
<a href="{{ route('usuarios.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-left fa-sm text-white-50"></i> Índice
</a>
@endsection

@section('card-title')
Editar usuario
@endsection

@section('form')
<form action="{{ route('usuarios.update', $user) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-row">
        <div class="form-group col-lg-6">
            <label for="first_name"><span>*</span> Nombre(s)</label>
            <input type="text" class="form-control capitalize-input {{ !$errors->has('first_name') ?: 'is-invalid' }}" name="first_name" value="{{ $user->first_name }}" autofocus>
            @if ($errors->has('first_name'))
            @foreach ($errors->get('first_name') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
        <div class="form-group col-lg-6">
            <label for="last_name"><span>*</span> Apellido paterno</label>
            <input type="text" class="form-control capitalize-input {{ !$errors->has('last_name') ?: 'is-invalid' }}" name="last_name" value="{{ $user->last_name }}">
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
            <input type="email" class="form-control {{ !$errors->has('email') ?: 'is-invalid' }}" name="email" id="email" value="{{ $user->email }}">
            @if ($errors->has('email'))
            @foreach ($errors->get('email') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
        <div class="form-group col-lg-4">
            <label for="phone"><span>*</span> Teléfono</label>
            <input type="text" class="form-control {{ !$errors->has('phone') ?: 'is-invalid' }}" name="phone" value="{{ $user->phone }}">
            @if ($errors->has('phone'))
            @foreach ($errors->get('phone') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
        <div class="form-group col-lg-4"  id="role_label_user">
            <label for="role"><span>*</span> Rol</label>
            <select class="form-control {{ !$errors->has('role') ?: 'is-invalid' }}" name="role" id="role" onchange="companyFunction()">
                <option disabled selected value>Selecciona un rol</option>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ $user->role->id != $role->id ?: 'selected' }}>{{ $role->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('role'))
            @foreach ($errors->get('role') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
        <div class="form-group col-lg-4" id="role_label_client" style="display: none">
            <label for="role"><span>*</span> Rol</label>
            <input type="text" class="form-control {{ !$errors->has('phone') ?: 'is-invalid' }}" id="role_client" value="{{ $user->role->name }}">
        </div>
        @if ($user->can('orders.index'))
        <div class="form-group col-lg-6">
            <label for="client_code_group"><span>*</span> Sector de clientes</label>
            <select class="client_code-dropdown form-control {{ !$errors->has('client_code_group') ?: 'is-invalid' }}" name="client_code_group[]" multiple>
                <option value="1000" {{ strpos($user->client_code_group, '1000') === false ?: 'selected' }}>1000</option>
                <option value="2000" {{ strpos($user->client_code_group, '2000') === false ?: 'selected' }}>2000</option>
                <option value="3000" {{ strpos($user->client_code_group, '3000') === false ?: 'selected' }}>3000</option>
                <option value="4000" {{ strpos($user->client_code_group, '4000') === false ?: 'selected' }}>4000</option>
                <option value="5000" {{ strpos($user->client_code_group, '5000') === false ?: 'selected' }}>5000</option>
                <option value="6000" {{ strpos($user->client_code_group, '6000') === false ?: 'selected' }}>6000</option>
                <option value="7000" {{ strpos($user->client_code_group, '7000') === false ?: 'selected' }}>7000</option>
                <option value="8000" {{ strpos($user->client_code_group, '8000') === false ?: 'selected' }}>8000</option>
                <option value="9000" {{ strpos($user->client_code_group, '9000') === false ?: 'selected' }}>9000</option>
            </select>
            @if ($errors->has('client_code_group'))
            @foreach ($errors->get('client_code_group') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
        @else
        <input type="hidden" name="client_code_group[]" value="['0']">
        @endif
    </div>
    <div class="form-row">
        <div class="form-group col-lg-4">
            <label for="password"><span>*</span> Contraseña</label>
            <input type="password" class="form-control {{ !$errors->has('password') ?: 'is-invalid' }}" name="password" id="password" placeholder="Debe de contener mínimo 8 caracteres">
            @if ($errors->has('password'))
            @foreach ($errors->get('password') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
        <div class="form-group col-lg-4">
            <label for="password_confirmation">Confirma la contraseña</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="********">
        </div>

            <div class="form-group col-lg-4 {{ !$errors->has('company_name') ?: 'is-invalid' }}" name="company_name_field" id="company_name_field" style="display:none">
                <label for="company_name"><span>*</span> Nombre de la Compañia</label>
                <input type="text" class="form-control
                    {{ !$errors->has('company_name') ?: 'is-invalid' }}" {{!$user->company_name}}
                    name="company_name"
                    id="company_name"
                    value="{{ $user->company_name }}">
                @if ($errors->has('company_name'))
                @foreach ($errors->get('company_name') as $message)
                <div class="invalid-feedback">{{ $message }}</div>
                @endforeach
                @endif
            </div>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="{{ asset('js/formEditUser.js') }}"></script>
@endpush
