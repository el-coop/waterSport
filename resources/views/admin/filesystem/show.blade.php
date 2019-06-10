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
},{
    name: 'use',
    label: '@lang('admin/settings.use')',
    type: 'select',
    options: {
        registrationEmailPdf: '@lang('vue.registrationEmailPdf')',
        homepagePdf: '@lang('vue.homepagePdf')'
    },
    callback: 'translate'
}]" :init-fields="{{$pdfs}}" action="{{action('Admin\PdfController@store')}}"
                       :headers="{'Content-Type': 'multipart/form-data'}">
        </dynamic-table>
    </div>
@endsection
