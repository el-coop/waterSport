@extends('layouts.dashboard')
@section('title', $sport->name)
@section('content')
	<div class="card">
		<div class="card-header">
			<p class="card-header-title">
				{{ $sport->name}} / @lang('sports.fields')
			</p>
		</div>
		<div class="card-content">
			<dynamic-table :columns="[{
                name: 'name_nl',
                label: '@lang('global.name_nl')',
                type: 'text'
            },{
                name: 'name_en',
                label: '@lang('global.name_en')',
                type: 'text'
            },{
                name: 'type',
                label: '@lang('global.type')',
                type: 'select',
                options: {
                    text: '@lang('global.text')',
                    textarea: '@lang('global.textarea')',
                    checkbox: '@lang('global.checkbox')'
                },
                translate: true
            }, {
                name: 'placeholder_nl',
                label: '@lang('global.placeholder_nl')',
                type: 'text'
            }, {
                name: 'placeholder_en',
                label: '@lang('global.placeholder_en')',
                type: 'text'
            }]" :init-fields="{{$sport->fields}}" action="{{action('Admin\SportFieldsController@store', $sport)}}">
			</dynamic-table>
		</div>
	</div>
@endsection
