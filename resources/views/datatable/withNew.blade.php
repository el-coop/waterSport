@component('elcoop:datatable::component')
	@slot('buttons')
		<button class="button is-light" @click="actions.newObjectForm">@lang('datatable.add')</button>
	@endslot
	@slot('delete')
		<datatable-delete-form :action="`{{ Request::url() }}/${props.rowData.id}`"
							   label="@lang('vue.datatable.delete')" @success="refresh"/>
	@endslot
	<div class="title is-7 has-text-centered">
		@if($withEditLink ?? true)
			<component :is="object.id ? 'a' : 'div'"
					   :href="object.id ? `{{Request::url() }}/${object.id}` : '#'">
				<span class="is-size-3" v-text="object.name || '{{ $createTitle ?? 'Create'}}'"></span>
				<font-awesome-icon icon="link" v-if="object.id"></font-awesome-icon>
			</component>
		@else
			<div>
							<span class="is-size-3"
								  v-text="object.name || object.name_{{\App::getLocale()}} ||'{{ $createTitle ?? 'Create'}}'"></span>
			</div>
		@endif
	</div>
	<dynamic-form :url="'{{Request::url()}}/edit' + (object.id ? `/${object.id}` : '')"
				  :on-data-update="onUpdate"
				  :method="object.id ? 'patch' : 'post'"
	></dynamic-form>
	@isset($extraSlotView)
		@include($extraSlotView)
	@endisset
@endcomponent
