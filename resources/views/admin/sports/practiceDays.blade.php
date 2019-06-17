<div v-if="object.id" class="mt-1">
	<p class="title is-6">@lang('practiceDays.practiceDays'):</p>
	<dynamic-table :columns="[{
                    name: 'date',
                    subType: 'date',
                    callback: 'date',
                    label: '@lang('global.date')'
                },{
                    name: 'startHour',
                    subType: 'time',
                    label: '@lang('global.startTime')'
                },{
                    name: 'endHour',
                    subType: 'time',
                    label: '@lang('global.endTime')'
                }]"
				   :init-fields-from-url="`{{Request::url()}}/practice/${object.id}`"
				   :action="`{{Request::url()}}/practice/${object.id}`">
	</dynamic-table>
</div>
