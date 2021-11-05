@extends('layouts.crud_views.__show')

@section('title')
¡Buen dia!
@endsection

@section('content')
@endsection

@push('styles')
@include('layouts.styles.__datatable')
@endpush
@push('scripts')
@include('layouts.scripts.__datatable')
@if ($errors->any())
<script>
    $( document ).ready(function() {
        $('.errorBack').modal('show');
    });
</script>
@endif
@endpush
