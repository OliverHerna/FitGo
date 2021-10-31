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
Nuevo rol
@endsection

@section('form')
<form action="{{ route('roles.store') }}" method="POST">
    @csrf
    <div class="form-group row">
        <label for="name" class="col-lg-2 col-form-label capitalize-input"><span>*</span> Nombre</label>
        <div class="col-lg-4">
            <input type="text" class="form-control capitalize-input {{ !$errors->has('name') ?: 'is-invalid' }}" name="name" value="{{ old('name') }}" autofocus>
            @if ($errors->has('name'))
            @foreach ($errors->get('name') as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
        </div>
    </div>
    @foreach ($modules as $module)
    @php $actions = explode(',', $module->actions) @endphp
    <div class="form-group row">
        <label for="name" class="col-lg-2 col-form-label">{{ ucwords(__('modules.' . strtolower($module->name))) }}</label>
        <div class="col-lg-8 ">
            <select class="js-example-basic-multiple form-control {{ !$errors->has($module->name) ?: 'is-invalid' }}" name="{{ $module->name }}[]" multiple="multiple">
                @if ($actions[0] == 1)<option value="view">{{ ucwords(__('permissions.view')) }}</option>@endif
                @if ($actions[1] == 1)<option value="create">{{ ucwords(__('permissions.create')) }}</option>@endif
                @if ($actions[2] == 1)<option value="update">{{ ucwords(__('permissions.update')) }}</option>@endif
                @if ($actions[3] == 1)<option value="delete">{{ ucwords(__('permissions.delete')) }}</option>@endif
                @if ($actions[4] == 1)<option value="restore">{{ ucwords(__('permissions.restore')) }}</option>@endif
                @if ($actions[5] == 1)<option value="force_delete">{{ ucwords(__('permissions.force_delete')) }}</option>@endif
                @if ($actions[6] == 1)<option value="log">{{ ucwords(__('permissions.log')) }}</option>@endif
            </select>

            @if ($errors->has($module->name))
            @foreach ($errors->get($module->name) as $message)
            <div class="invalid-feedback">{{ $message }}</div>
            @endforeach
            @endif
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
@include('layouts.styles.__select2')
@endpush

@push('scripts')
@include('layouts.scripts.__select2')
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
