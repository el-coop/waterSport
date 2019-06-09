@extends('layouts.site')

@section('title', $user->name)

@section('content')
	@if($errors->any())
		<pre>
			<?php print_r($errors->all()) ?>
		</pre>
	@endif
	<tabs>
		<tab label="@lang('global.profile')">@include('competitor.profile')</tab>
		<tab label="@lang('competitors.schedule')">@include('competitor.schedule')</tab>
	</tabs>
@endsection
