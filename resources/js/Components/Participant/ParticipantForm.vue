<template>
	<div class="tile is-ancestor">
		<div class="tile is-parent">
			<div class="tile is-child">
				<PersonalDetails>
					<slot name="personal"/>
				</PersonalDetails>
			</div>
			<div class="tile is-child is-4">
				<SportSelector :sports="sports" :init-selected-sports="initSelectedSports"/>
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
				required: true
			},
			initSelectedSports: {
				default() {
					return [];
				}
			}
		},

	}
</script>

