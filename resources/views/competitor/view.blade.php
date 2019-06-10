@extends('layouts.site')

@section('title', $user->name)

@section('content')
	@if($user->user->submitted)
		@include('competitor.message')
	@endif
	<tabs>
		<tab label="@lang('global.profile')">@include('competitor.profile')</tab>
		<tab label="@lang('competitors.schedule')">@include('competitor.schedule')</tab>
	</tabs>
@endsection
