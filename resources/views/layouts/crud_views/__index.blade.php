@extends('layouts.app')

@section('title')
@yield('title')
@endsection

@section('option')
@yield('option')
@endsection

@section('content')
@include('layouts.__message_info')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@yield('card-title')</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm order-table-font" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            @yield('table-headers')
                        </thead>
                        <tbody>
                            @yield('table-rows')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@include('layouts.styles.__datatable')
@endpush

@push('scripts')
@include('layouts.scripts.__datatable')
@endpush
