<template>
	<div class="tile is-ancestor is-vertical box">
		<div class="tile is-12">
			<div class="tile is-parent">
				<div class="tile is-child">
					<SportSelector :sports="sports" :init-selected-sports="selectedSports"
								   v-model="sportsData"/>
				</div>
			</div>
			<div class="tile is-parent is-6">
				<div class="tile is-child">
					<form method="post" ref="form">
						<input type="hidden" name="_token" :value="csrf">
						<input v-if="method" type="hidden" name="_method" :value="method">
						<PersonalDetails>
							<slot name="personal"/>
						</PersonalDetails>
						<template v-for="(data, sport) in sportsData">
							<input :key="`sport_${sport}`" type="hidden" :name="`sports[${sport}][0]`"
								   :value="sport">
							<template v-for="(info,key) in data">
								<input v-if="key !== 'practiceDays' && key !== 'competitionDays'"
									   :key="`sport_${sport}_${key}`" type="hidden"
									   :name="`sports[${sport}][${key}]`"
									   :value="info">
								<template v-if="key === 'practiceDays'">
									<input v-for="(practiceDay,practiceKey) in info"
										   :key="`sport_practice_${sport}_${key}_${practiceKey}`" type="hidden"
										   :name="`sports[${sport}][${key}][${practiceKey}]`"
										   :value="practiceDay">
								</template>
								<template v-if="key === 'competitionDays'">
									<input v-for="(competitionDay,competitionKey) in info"
										   :key="`sport_competition_${sport}_${key}_${competitionKey}`" type="hidden"
										   :name="`sports[${sport}][${key}][${competitionKey}]`"
										   :value="competitionDay">
								</template>
							</template>
						</template>
					</form>
				</div>
			</div>
		</div>
		<div class="tile is-parent">
			<div class="tile is-child">
				<div class="buttons has-content-justified-center">
					<button class="button is-success" @click="$refs.form.submit()"
							v-text="$translations.submit" :disabled="! selectedSports.length"></button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import PersonalDetails from "./ParticipanForm/PersonalDetails";
	import SportSelector from "./ParticipanForm/SportSelector";

	export default {
		name: "ParticipantForm",
		components: {SportSelector, PersonalDetails},
		props: {
			sports: {
				required: true,
				type: Array
			},
			initSelectedSports: {
				type: Array,
				default() {
					return [];
				}
			},

			initSportsData: {
				type: Object,
				default() {
					return {};
				}
			},

			submitted: {
				type: Boolean,
				default: false
			},

			method: {
				type: String
			}
		},

		data() {
			return {
				sportsData: this.initSportsData,
				csrf: window.token.content,
				selectedSports: this.initSelectedSports,
			}
		},
	}
</script>

