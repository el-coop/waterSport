@extends('layouts.dashboard')

@section('title',__('admin/settings.files'))

@section('content')
    <div class="box">
        <dynamic-table :columns="[{
	name: 'name',
	label: '@lang('global.name')'
},{
    name: 'file',
    label: '@lang('admin/settings.chooseFile')',
    type: 'file',
    invisible: true,
    edit: false
}]" :init-fields="{{$pdfs}}" action="{{action('Admin\PdfController@store')}}"
                       :headers="{'Content-Type': 'multipart/form-data'}">
        </dynamic-table>
    </div>
@endsection
