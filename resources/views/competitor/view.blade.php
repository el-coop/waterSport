@extends('layouts.site')

@section('title', $user->name)

@section('content')
	<tabs>
		<tab label="@lang('competitors.profile')">@include('competitor.profile')</tab>
		{{--<tab label="@lang('competitors.schedule')">@include('competitor.schedule')</tab>--}}
	</tabs>
@endsection
