@extends('layouts.site')
@section('title', $user->name)
@section('content')
    <tabs>
        <tab label="@lang('global.profile')">
            @include('sportManager.profile')
        </tab>
        <tab label="@lang('practiceDays.practiceDays')">
            @component('sportManager.dates', [
	        'type' => 'practices',
	        'dates' => $user->user->sport->practiceDays
        ])
            @endcomponent
        </tab>
        <tab label="@lang('vue.competitionDates')">
            @component('sportManager.dates', [
	        'type' => 'competitions',
	        'dates' => $user->user->sport->competitionDays
        ])
            @endcomponent
        </tab>
    </tabs>
@endsection
