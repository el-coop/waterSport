<template>
	<ModalComponent name="sportModal" @opened="opened">
		<form v-if="sport" @submit.prevent="submit" ref="form">
			<div class="field">
				<label class="label" v-text="'Competition Day'"/>
				<button type="button" class="button is-link" v-text="sport.competition"></button>
			</div>
			<div class="field">
				<label class="label" v-text="'Practice Day'"/>
				<div class="buttons">
					<button v-for="day in sport.practice_days" type="button" class="button"
							:class="{'is-link': practiceDay === day.id}"
							v-text="day.formattedDate" @click="practiceDay = day.id"></button>
				</div>
				<input type="hidden" name="practiceDay" v-model="practiceDay"/>
			</div>
			<component v-for="(field, key) in fields" :key="key" :field="fieldSetup(field)"
					   :is="`${field.type}-field`"></component>
			<div class="buttons">
				<button class="button is-success" v-text="$translations.save"></button>
				<button type="button" class="button is-danger" @click="$modal.hide('sportModal')">
					Cancel
				</button>
			</div>
		</form>
	</ModalComponent>
</template>

<script>
	export default {
		name: "SportModal",

		props: {
			sport: {
				required: true,
				type: Object
			},
			form: {
				required: true,
				type: Object
			}
		},

		data() {
			return {
				practiceDay: null
			}
		},

		methods: {
			opened() {
				if (this.form.practiceDay) {
					return this.practiceDay = parseInt(this.form.practiceDay);
				}
				if (this.sport.practice_days) {
					return this.practiceDay = this.sport.practice_days[0].id;
				}

				return null;
			},
			fieldSetup(field) {
				return {
					label: field.type !== 'checkbox' ? field.title : null,
					placeholder: field.placeholder,
					name: field.id,
					required: true,
					value: this.form ? this.form[field.id] : null,
					options: [{
						name: field.title
					}]
				}
			},

			submit() {
				const data = {};
				(new FormData(this.$refs.form)).forEach((value, key) => {
					data[key] = value;
				});
				this.$modal.hide('sportModal');
				this.$emit('filled', {
					sport: this.sport.id,
					data
				});
			}
		},

		computed: {
			fields() {
				return this.sport.fields;
			},
		}
	}
</script>
