@extends('layouts.crud_views.__form')

@section('title')
Roles
@endsection

@section('option')
<a href="{{ route('roles.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-chevron-left fa-sm text-white-50"></i> Regresar
</a>
@endsection

@section('card-title')
Editar rol
@endsection

@section('form')
<form action="{{ route('roles.update', $role) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-group row">
        <label for="name" class="col-lg-2 col-form-label capitalize-input"><span>*</span> Nombre</label>
        <div class="col-lg-4">
            <input type="text" class="form-control capitalize-input {{ !$errors->has('name') ?: 'is-invalid' }}" name="name" value="{{ $role->name }}" autofocus>
            @if ($errors->has('name'))
            @foreach ($errors->get('name') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
    </div>
    @foreach ($modules as $module)
    @php
    $actions = explode(',', $module->actions);
    $permission = $module->permissions()->where('role_id', $role->id)->first();
    @endphp
    <div class="form-group row">
        <div class="col-lg-2"><strong>{{ ucwords(__('modules.' . strtolower($module->name))) }}</strong></div>
        <div class="col-lg-8">
            <select class="js-example-basic-multiple form-control {{ !$errors->has($module->name) ?: 'is-invalid' }}" name="{{ $module->name }}[]" multiple="multiple">
                @if ($actions[0] == 1)<option class="value-select-option" value="view" @if ($permission && $permission->module == $module) {{ $permission->view != 1 ?: 'selected' }} @endif>{{ ucwords(__('permissions.view')) }}</option>@endif
                @if ($actions[1] == 1)<option class="value-select-option" value="create" @if ($permission && $permission->module == $module) {{ $permission->create != 1 ?: 'selected' }} @endif>{{ ucwords(__('permissions.create')) }}</option>@endif
                @if ($actions[2] == 1)<option class="value-select-option" value="update" @if ($permission && $permission->module == $module) {{ $permission->update != 1 ?: 'selected' }} @endif>{{ ucwords(__('permissions.update')) }}</option>@endif
                @if ($actions[3] == 1)<option class="value-select-option" value="delete" @if ($permission && $permission->module == $module) {{ $permission->delete != 1 ?: 'selected' }} @endif>{{ ucwords(__('permissions.delete')) }}</option>@endif
                @if ($actions[4] == 1)<option class="value-select-option" value="restore" @if ($permission && $permission->module == $module) {{ $permission->restore != 1 ?: 'selected' }} @endif>{{ ucwords(__('permissions.restore')) }}</option>@endif
                @if ($actions[5] == 1)<option class="value-select-option" value="force_delete" @if ($permission && $permission->module == $module) {{ $permission->force_delete != 1 ?: 'selected' }} @endif>{{ ucwords(__('permissions.force_delete')) }}</option>@endif
                @if ($actions[6] == 1)<option class="value-select-option" value="log" @if ($permission && $permission->module == $module) {{ $permission->log != 1 ?: 'selected' }} @endif>{{ ucwords(__('permissions.log')) }}</option>@endif
            </select>
        </div>
    </div>
    @endforeach
    <div class="form-group row">
        <div class="col-lg-10">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>
@endsection
@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" />
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({
            placeholder: 'Selecciona los permisos',
            width: '100%',
            theme: "bootstrap"
        });
    });
</script>
@endpush