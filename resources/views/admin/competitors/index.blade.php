@extends('layouts.dashboard')

@section('title',__('competitors.competitors'))

@section('content')
	@component('datatable.withNew')
		@slot('fieldType', 'Competitor')
	@endcomponent
@endsection
