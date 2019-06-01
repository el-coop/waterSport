<template>
	<div class="tile is-ancestor is-vertical box">
		<div class="tile is-12">
			<div class="tile is-parent is-7">
				<div class="tile is-child">
					<PersonalDetails>
						<slot name="personal"/>
					</PersonalDetails>
				</div>
			</div>
			<div class="tile is-parent">
				<div class="tile is-child">
					<SportSelector :sports="sports" :init-selected-sports="initSelectedSports"/>
				</div>
			</div>
		</div>
		<div class="tile is-parent">
			<div class="tile is-child">
				<div class="buttons has-content-justified-center">
					<button class="button is-info">Save</button>
					<button class="button is-success">Submit</button>
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
				required: true
			},
			initSelectedSports: {
				default() {
					return [];
				}
			}
		},

		methods: {
			submit() {

			}
		}

	}
</script>

