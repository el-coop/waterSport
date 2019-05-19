@component('elcoop:datatable::component')
	@slot('buttons')
		<button class="button is-light" @click="actions.newObjectForm">@lang('datatable.add')</button>
	@endslot
	<div class="title is-7 has-text-centered">
		<div>
					<span class="is-size-3"
						  v-text="object.name || object.name_{{\App::getLocale()}} ||'{{ $createTitle ?? 'Create' }}'"></span>
		</div>
	</div>
	<dynamic-form :url="'{{Request::url()}}/edit' + (object.id ? `/${object.id}` : '')"
				  :on-data-update="onUpdate"
				  :method="object.id ? 'patch' : 'post'"
	></dynamic-form>
@endcomponent
