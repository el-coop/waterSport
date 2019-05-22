@extends('layouts.dashboard')

@section('content')
    @component('datatable.withNew')
        @slot('extraSlotView', 'admin.sports.practiceDays')
    @endcomponent
@endsection
