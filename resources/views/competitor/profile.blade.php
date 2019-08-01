@if($errors->has('fullDays'))
    <div class="notification is-danger">
        @lang('practiceDays.full')
    </div>
@endif
<participant-form method="patch" :sports="{{ $sports }}" :init-selected-sports="{{ $selectedSports }}"
                  :init-sports-data="{{ $sportsData }}">
    <dynamic-fields slot="personal" :fields="{{ $user->user->fulldata->filter(function ($item){
	                return $item['type'] !== 'sport';
	})->map(function($item) use($errors){
					$fieldName = str_replace(']','',str_replace('[','.',$item['name']));

					$item['value'] = old($fieldName, $item['value']);
					$item['error'] = $errors->has($fieldName) ? $errors->get($fieldName): null;
					return $item;
				}) }}">
    </dynamic-fields>
</participant-form>
