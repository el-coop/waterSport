@extends('layouts.dashboard')

@section('title',$title)

@section('content')
    <div class="box">
        <a href="{{$downloadAction}}"  class="button is-info">{{$btn}}</a>
    </div>
    <dynamic-table :columns="[{
            name: 'column',
            label: '@lang('admin/fields.field')',
            type: 'select',
            options: {{$options}},
            callback: 'numerateOptions'
        }, {
            name: 'name',
            label: '@lang('global.name')',
        }]" :init-fields="{{collect($alreadySelected)}}" :sortable="true" action="{{$addAction}}">
    </dynamic-table>
@endsection