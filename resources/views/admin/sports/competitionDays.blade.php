<div v-if="object.id" class="mt-1">
	<p class="title is-6">@lang('sports.competitionDates'):</p>
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
                },{
                    name: 'max_participants',
                    subType: 'number',
                    label: '@lang('practiceDays.maxParticipants')'
                }]"
				   :init-fields-from-url="`{{Request::url()}}/competition/${object.id}`"
				   :action="`{{Request::url()}}/competition/${object.id}`">
	</dynamic-table>
</div>
