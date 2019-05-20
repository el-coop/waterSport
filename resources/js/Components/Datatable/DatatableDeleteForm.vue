<template>
	<ajax-form method='delete' :action="action" @submitting="buttonClass = 'is-danger is-loading'"
			   @submitted="submitted">
		<confirmation-submit :button-class="buttonClass"
							 :title="$translations.deleteConfirmTitle"
							 subtitle=" "
							 :yes-text="$translations.yes" :no-text="$translations.no"
							 :label="label"></confirmation-submit>
	</ajax-form>
</template>
<script>
	import ConfirmationSubmit from './ConfirmationSubmit';
	import AjaxForm from '../Form/AjaxForm';

	export default {
		name: "DatatableDeleteForm",
		components: {
			AjaxForm,
			ConfirmationSubmit
		},
		props: {
			action: {
				type: String,
				required: true
			},
			label: {
				type: String,
				required: true
			}

		},
		data() {
			return {
				buttonClass: 'is-danger'
			}
		},
		methods: {
			submitted(response) {
				this.buttonClass = 'is-danger';
				if (response.status === 200 || response.status === 204) {
					this.$emit('success');
				}
			}
		}
	}
</script>
