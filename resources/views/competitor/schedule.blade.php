<dynamic-table :columns="[{
    name: 'sport',
    label: '@lang('sports.sport')',
    type: 'text'
    }, {
        name: 'practiceDay',
        label: '@lang('vue.practiceDay')',
        type: 'text',
			subType: 'date',
    }, {
        name: 'competition',
        label: '@lang('sports.competitionDate')',
        type: 'text',
			subType: 'date',
    }
    ]" :init-fields="{{$user->user->schedule}}">

</dynamic-table>