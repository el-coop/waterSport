<form method="POST" action="{{action('SportManagerController@update', $user->user)}}">
    @csrf
    @method('PATCH')
    <dynamic-fields slot="personal" :fields="{{ $user->user->fulldata->reject(function ($item){
        return $item['name'] == 'sport';
    })->map(function($item) use($errors){
					$fieldName = str_replace(']','',str_replace('[','.',$item['name']));

					$item['value'] = old($fieldName, $item['value']);
					$item['error'] = $errors->has($fieldName) ? $errors->get($fieldName): null;
					return $item;
				}) }}">
    </dynamic-fields>
    <div class="field mt-1">
        <div class="control">
            <button class="button is-success">@lang('vue.save')</button>
        </div>
    </div>
</form>