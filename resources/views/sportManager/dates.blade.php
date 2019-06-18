<select-chooser>
    @foreach($dates as $date)
        <select-view label="{{$date->start_time->format('d/m/Y H:i')}}">
            @component('datatable.nonConfigDatatable', [
            'attribute' => 'competitorsForManager',
            'fields' => $date->competitorsForManager['fields'],
            'url' => "sportManager/$type/$date->id/datatable"])
            @endcomponent
        </select-view>
    @endforeach
</select-chooser>