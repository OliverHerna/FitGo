@extends('layouts.crud_views.__show')

@section('title')
Calendario
@endsection

@section('content')
    <div id='calendar'></div>

@endsection

@push('styles')
@include('layouts.styles.__datatable')

@endpush
@push('scripts')
@include('layouts.scripts.__datatable')


<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            defaultDate: '2021-11-05',
            editable: true,
            eventLimit: true, // allow "more" link when too many events
        });
    });
</script>

@endpush



