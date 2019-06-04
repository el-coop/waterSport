@extends('layouts.dashboard')

@section('title',__('sportManagers.sportManagers'))

@section('content')
    @component('datatable.withNew')
    @endcomponent
@endsection
