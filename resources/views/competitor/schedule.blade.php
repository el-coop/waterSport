{{dd($user->user->schedule)}}
<dynamic-table :columns="[
    {
        name: 'sport',
        label: '@lang('sports.sport')'
        type: text
    }, {
        name: 'practice'
        label: '@lang('practiceDays.practiceDay')'
        type: text
    }, {
        name: 'competition',
        label: '@lang('vue.competitionDay')'
        type: text
    }
]" :init-fields="{{$user->user->schedule}}">

</dynamic-table>