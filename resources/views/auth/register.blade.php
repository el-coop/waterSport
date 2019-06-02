@extends('layouts.site')
@section('title',__('global.register'))

@section('content')
	<div class="section">
		@if($errors->any())
			<pre>
			<?php
				print_r($errors->all());
				?>
			</pre>
		@endif
		<participant-form :sports="{{ $sports }}">
			<template slot="personal">
				<text-field
						:field="{label: '@lang('global.name')',name: 'name', value: '{{ old('name') }}'}"
						:error="{{ $errors->has('name') ? collect($errors->get('name')): 'null'}}"></text-field>
				<text-field
						:field="{label: '@lang('global.email')',name: 'email', subType: 'email', value: '{{ old('email') }}'}"
						:error="{{ $errors->has('email') ? collect($errors->get('email')): 'null'}}"></text-field>
				<select-field :field="{label: '@lang('global.language')',name: 'language', options: {
									@foreach(config('app.locales') as $local)
				{{$local}}: '@lang("global.$local")',
								@endforeach
						}, value: '{{  old('language',App::getLocale()) }}'}"
							  :error="{{ $errors->has('language') ? collect($errors->get('language')): 'null'}}"></select-field>
			</template>
		</participant-form>
	</div>
@endsection
