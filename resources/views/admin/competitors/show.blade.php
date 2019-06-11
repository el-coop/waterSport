@extends('layouts.dashboard')

@section('title',$user->name)

@section('content')
	@if($errors->any())
		<pre>
			{{ print_r($errors->all(),true) }}
		</pre>
	@endif
	<tabs>
		<tab label="@lang('global.profile')">@include('competitor.profile')</tab>
		<tab label="@lang('competitors.schedule')">@include('competitor.schedule')</tab>
	</tabs>
@endsection
