@extends('layouts.site')

@section('title',__('global.login'))

@section('content')
	<div class="section">
		<div class="columns">
			<div class="column is-half">
				@component('components.card',[
					'class' => 'h-100'
				])
					@slot('title')
						<p class="title is-4 is-title-red">
							@lang('global.login')
						</p>
					@endslot
					<form method="post" action="{{ action('Auth\LoginController@login') }}">
						@csrf
						<text-field
								:field="{label: '@lang('global.email')',name: 'email', subType: 'email'}"
								:error="{{ $errors->count() ? collect([__('auth.failed')]): 'null'}}"></text-field>
						<text-field
								:field="{label: '@lang('global.password')',name: 'password', subType: 'password'}"></text-field>
						<div class="field">
							<label class="checkbox">
								<input type="checkbox" name="remember">
								@lang('auth.rememberMe')
							</label>
						</div>
						<div class="buttons">
							<button class="button is-primary">
								@lang('global.login')
							</button>
							<a href="{{ action('Auth\ForgotPasswordController@showLinkRequestForm') }}"
							   class="button is-dark">@lang('auth.forgot')</a>
						</div>
					</form>
				@endcomponent
			</div>
			<div class="column is-half">
				@component('components.card',[
					'class' => 'h-100'
				])
					@if(\Session::has('confirmEmail'))
						<p class="title">
							{{ App::make('settings')->get('registration_success_' . App::getLocale()) }}
						</p>
					@else
						<p class="title">
							{{ App::make('settings')->get('login_text_' . App::getLocale()) }}
						</p>
					@endif
				@endcomponent
			</div>
		</div>
	</div>
@endsection
