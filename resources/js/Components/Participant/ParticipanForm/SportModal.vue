<template>
	<ModalComponent name="sportModal" @opened="opened">
		<h5 class="title is-5" v-text="sport.name"></h5>
		<p class="content" v-html="sport.formattedDescription"></p>
		<form v-if="sport" @submit.prevent="submit" ref="form">
			<div class="field">
				<label class="label" v-text="$translations.competitionDates"/>
				<div class="buttons">
					<button v-for="day in sport.competition_days" type="button" class="button"
							:key="`competition_day_${day.id}`"
							:class="{'is-link': competitionDays.includes(day.id)}"
							v-text="day.formattedDate" @click="toggleCompetitionDay(day.id)"></button>
				</div>
			</div>
			<div class="field">
				<label class="label" v-text="sport[`practice_day_title_${lang}`]"/>
				<div class="buttons">
					<button v-for="day in sport.practice_days" type="button" class="button"
							:key="`pracrtice_day_${day.id}`"
							:class="{'is-link': practiceDays.includes(day.id)}"
							v-text="day.formattedDate" @click="togglePracticeDay(day.id)"></button>
				</div>
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
				practiceDays: [],
				competitionDays: [],
				lang: document.documentElement.lang
			}
		},

		methods: {
			opened() {
				if (this.form.practiceDays) {
					this.practiceDays = this.form.practiceDays;
				} else {
					this.practiceDays.push(this.sport.practice_days[0].id);
				}
				if (this.sport.practice_days) {
				}

				if (this.form.competitionDays) {
					this.competitionDays = this.form.competitionDays;
				} else {
					this.competitionDays.push(this.sport.competition_days[0].id);
				}

			},

			togglePracticeDay(day) {
				const index = this.practiceDays.indexOf(day);
				if (index > -1) {
					this.practiceDays.splice(index, 1);
				} else {
					this.practiceDays.push(day);
				}
			},
			toggleCompetitionDay(day) {
				const index = this.competitionDays.indexOf(day);
				if (index > -1) {
					this.competitionDays.splice(index, 1);
					if (this.competitionDays.length === 0) {
						this.competitionDays.push(this.sport.competition_days[0].id);
					}
				} else {
					this.competitionDays.push(day);
				}
			},

			fieldSetup(field) {
				return {
					label: field.title,
					placeholder: field.placeholder,
					name: field.id,
					required: true,
					value: this.form ? this.form[field.id] : null,
				}
			},

			submit() {
				const data = {};
				const formData = new FormData(this.$refs.form);

				for(const pair of formData.entries()){
					data[pair[0]] = pair[1];
				}

				data['practiceDays'] = this.practiceDays;
				data['competitionDays'] = this.competitionDays;
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
