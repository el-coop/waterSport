@extends('layouts.site')
@section('title',__('global.register'))

@section('content')
	<div class="section">
		<participant-form method="patch" :sports="{{ $sports }}" :init-selected-sports="{{ $selectedSports }}" :init-sports-data="{{ $sportsData }}">
			<dynamic-fields slot="personal" :fields="{{ $user->user->fulldata->map(function($item) use($errors){
					$fieldName = str_replace(']','',str_replace('[','.',$item['name']));

					$item['value'] = old($fieldName, $item['value']);
					$item['error'] = $errors->has($fieldName) ? $errors->get($fieldName): null;
					return $item;
				}) }}">
			</dynamic-fields>
		</participant-form>
	</div>
@endsection