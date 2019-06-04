@extends('layouts.dashboard')

@section('title',__('admin/settings.settings'))

@section('content')
	<div class="box">
		<form method="POST" action="{{action('Admin\SettingsController@update')}}">
			@csrf
			@method('PATCH')
			<div class="columns">
				@foreach($settings as $name => $setting)
					@if($loop->first || ($loop->iteration >= (1+$loop->count/2) && $loop->iteration < (2+$loop->count/2)) )
						<div class="column">
							@endif
							@component('admin.settings.components.setting', ['name' => $name])
								@if(strpos($name,'subject'))
									<input class="input" type="text" name="{{$name}}"
										   value="{{$setting}}">
								@else
									<textarea name="{{$name}}" class="textarea"
											  required>{{$setting}}</textarea>
								@endif
							@endcomponent
							@if(($loop->iteration >= $loop->count/2) && ($loop->iteration < (1+$loop->count/2)) || $loop->last)
						</div>
					@endif
				@endforeach
			</div>
			<div class="field mt-1">
				<div class="control">
					<button class="button is-success">@lang('global.save')</button>
				</div>
			</div>
		</form>
	</div>
@endsection
