@extends('layouts.dashboard')

@section('content')
    @component('datatable.withNew')
        @slot('withEdiLink')
            @slot('extraSlotView', 'admin.sports.practiceDays')
            @endcomponent
@endsection
