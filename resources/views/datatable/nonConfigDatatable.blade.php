<datatable :field-settings="{{ collect($fields) }}"
		   :extra-params="{
		   		attribute: '{{$attribute}}'
		   }"
		   @isset($editWidth)
		   :edit-width="{{$editWidth}}"
		   @endisset
		   :edit="false"
		   url="{{$url}}"
		   :labels="{
		   		pagination: '@lang('datatable.pagination')',
		   		noPagination: '@lang('datatable.noPagination')',
		   		next: '@lang('datatable.next')',
		   		prev: '@lang('datatable.prev')',
		   		filters: '@lang('datatable.filters')',
		   		filter: '@lang('datatable.filter')',
		   		clear: '@lang('datatable.clear')',
		   }"
		   :init-filters="{{ $filters ?? '{}' }}"
		   :export-button="false"
		   @isset($deleteButton)
		   :delete-slot="true"
		   @endif
		   @isset($formattersData)
		   :formatters-data="{{$formattersData}}"
		   @endif
		   @isset($deleteButtonTxt)
		   delete-btn="{{$deleteButtonTxt}}"
		@endisset
>
	@isset($buttons)
		<template #buttons="{actions}">{{$buttons}}</template>
	@endisset
</datatable>
