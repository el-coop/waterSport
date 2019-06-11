@extends('layouts.site')

@section('title', $user->name)

@section('content')
	@if($message)
		@include('competitor.message')
	@endif
	<tabs>
		<tab label="@lang('global.profile')">@include('competitor.profile')</tab>
		<tab label="@lang('competitors.schedule')">@include('competitor.schedule')</tab>
	</tabs>
	@if(session()->has('fireworks'))
		<submit-modal
				text="{{ str_replace(PHP_EOL,'<br>',app('settings')->get('application_success_modal_' . App::getLocale())) }}"></submit-modal>
	@endif
@endsection
