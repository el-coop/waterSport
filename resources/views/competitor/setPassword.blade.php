@extends('layouts.site')

@section('title',__('competitors.setPassword'))

@section('content')
	<div class="section">
		<div class="columns">
			<div class="column">
				@component('components.card',[
					'class' => 'h-100'
				])
					@slot('title')
						<p class="title is-4">
							@lang('competitors.setPassword')
						</p>
					@endslot

					<form method="post" action="{{ action('Auth\ResetPasswordController@reset') }}">
						@csrf
						<input type="hidden" name="token" value="{{ $token }}">
						<text-field
								:field="{label: '@lang('global.email') (@lang('auth.emailWarning'))',name: 'email', subType: 'email', value: '{{ old('email') }}'}"
								:error="{{ $errors->has('email') ? collect($errors->get('email')): 'null'}}"></text-field>
						<text-field
								:field="{label: '@lang('global.password')',name: 'password', subType: 'password'}"
								:error="{{ $errors->has('password') ? collect($errors->get('password')): 'null'}}"></text-field>
						<text-field
								:field="{label: '@lang('global.password_confirm')',name: 'password_confirmation', subType: 'password'}"></text-field>
						<div class="buttons">
							<button class="button is-primary">
								@lang('competitors.setPassword')
							</button>
						</div>
					</form>
				@endcomponent
			</div>
		</div>
	</div>
@endsection
