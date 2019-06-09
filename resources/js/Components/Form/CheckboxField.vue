<template>
	<div class="field">
		<label class="checkbox">
			<input type="checkbox" :name="field.name" value="1" :checked="field.checked || value"
				   :required="field.required || false"
				   @keypress.enter.prevent>
			<span v-text="field.label"></span>&nbsp;&nbsp;
		</label>
		<p v-if="error" class="help is-danger" v-text="errorText"></p>
	</div>
</template>

<script>
	import FieldMixin from './FieldMixin';

	export default {
		name: "CheckboxField",
		mixins: [FieldMixin]
	}
</script>
<style scoped>
	.checkbox + .checkbox {
		margin-left: .5em;
	}
</style>
