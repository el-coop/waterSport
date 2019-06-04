@extends('layouts.dashboard')

@section('title',__('sports.sports'))

@section('content')
    @component('datatable.withNew')
        @slot('withEdiLink')
        @slot('extraSlotView', 'admin.sports.practiceDays')
    @endcomponent
@endsection
