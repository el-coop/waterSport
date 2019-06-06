<template>
	<div class="field">
		<label class="checkbox">
			<input type="checkbox" :name="field.name" :value="field.checked || value" :checked="field.checked || value"
				   @keypress.enter.prevent>
			<span v-text="field.label"></span>&nbsp;&nbsp;
		</label>
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
