<dynamic-table :columns="[{
    name: 'sport',
    label: '@lang('sports.sport')',
    type: 'text'
    }, {
        name: 'date',
        label: '@lang('global.date')',
        type: 'text',
    }, {
        name: 'type',
        label: '@lang('global.type')',
        type: 'text',
    }
    ]" :init-fields="{{$user->user->schedule}}">

</dynamic-table>