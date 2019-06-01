@extends('layouts.dashboard')

@section('content')
    @component('datatable.withNew')
        @slot('fieldType', 'Competitor')
    @endcomponent
@endsection
