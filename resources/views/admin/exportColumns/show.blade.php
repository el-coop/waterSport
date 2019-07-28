@extends('layouts.dashboard')

@section('title',$title)

@section('content')
    <div class="box">
        <a href="{{$downloadAction}}"  class="button is-info">{{$btn}}</a>
        <button class="button is-success" @click="$modal.show('exportSport')">@lang('sports.export')</button>
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
    <export-sport-from :sports="{{$sportsField}}" :sport-dates="{{$sportDates}}" :date-types="{{$dateTypes}}" url="{{action('Admin\CompetitorExportColumnController@exportSportDate')}}"></export-sport-from>
@endsection