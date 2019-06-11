@extends('layouts.dashboard')

@section('title',__('sports.sports'))

@section('content')
    @component('datatable.withNew')
        @slot('withEdiLink')
        @slot('extraSlotViews', ['admin.sports.competitionDays','admin.sports.practiceDays'])
    @endcomponent
@endsection
