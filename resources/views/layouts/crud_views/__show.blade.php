@extends('layouts.app')

@section('title')
@yield('title')
@endsection

@section('option')
@yield('option')
@endsection

@section('content')
@include('layouts.__message_info')
<div class="row justify-content-center">
    <div class="@yield('card-size')">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 id="tittle" class="m-0 font-weight-bold text-primary">@yield('card-title')</h6>
            </div>

            @hasSection('conciliation')
            <div class="card-body">
                @yield('conciliation')
            </div>
            @else
            <ul class="list-group list-group-flush">
                @yield('card-list')
            </ul>
            @hasSection('card-action')
            <div class="card-body">
                <a href="@yield('card-action')" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Editar</a>
            </div>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection
