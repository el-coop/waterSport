@extends('layouts.site')
@section('title',__('global.register'))

@section('content')
	<div class="section">
		<participant-form :sports="{{ $sports }}">

			<dynamic-fields slot="personal" :fields="{{ $competitor->fulldata->map(function($item) use($errors){
					$fieldName = str_replace(']','',str_replace('[','.',$item['name']));

					$item['value'] = old($fieldName, $item['value']);
					$item['error'] = $errors->has($fieldName) ? $errors->get($fieldName): null;
					return $item;
				}) }}">
			</dynamic-fields>
		</participant-form>
		@isset($file)
			<div class="has-text-centered">
				Watersportverbond <a href="{{ action('ResourceController@view', $file) }}">@lang('auth.termsConditions')</a>
			</div>
		@endisset
	</div>
@endsection
