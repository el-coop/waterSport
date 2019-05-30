<template>
	<div class="tile is-ancestor">
		<div class="tile is-parent">
			<div class="tile is-child">
				<div class="card mr-half">
					<header class="card-header">
						<p class="card-header-title" v-text="'Personal details'">
						</p>
					</header>
					<div class="card-content">
						<slot name="personal"/>
					</div>
				</div>
			</div>
			<div class="tile is-child is-4">
				<div class="card h-100">
					<header class="card-header">
						<div class="card-header-title" v-text="'Sports'"></div>
					</header>

					<div class="card-content">
						<div class="panel" v-if="selectedSports.length">
							<p class="panel-block" v-for="(sport, index) in selectedSports">
								<span class="panel-icon">
									<font-awesome-icon icon="edit"></font-awesome-icon>
								</span>
								<span v-text="sports[sport].name"></span>
								<span class="tag is-danger ml-auto" @click="removeSport(index)">
									<font-awesome-icon icon="times-circle"></font-awesome-icon>
								</span>
							</p>
						</div>
						<div class="field">
							<label class="label" v-text="'Add sport'"></label>
							<div class="select is-fullwidth">
								<select v-model="newSport">
									<option v-for="(option, val) in options" :key="val" :value="val"
											v-text="option"></option>
								</select>
							</div>
						</div>
						<button @click="addSport" class="button is-success is-fullwidth">
							Add
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: "ParticipantForm",

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

		created() {

		},

		data() {
			return {
				selectedSports: this.initSelectedSports,
				newSport: 0,
			};
		},

		methods: {
			addSport() {
				this.selectedSports.push(parseInt(this.newSport));
			},
			removeSport(sportIndex) {
				this.selectedSports.splice(sportIndex, 1)
			}
		},

		computed: {
			options() {
				const options = {};
				this.sports.forEach((sport, index) => {
					if (!this.selectedSports.includes(index)) {
						options[index] = sport.name;
					}
				});
				return options;
			}
		}
	}
</script>

<style scoped lang="scss">
	.panel-icon, .tag {
		cursor: pointer;
	}
</style>
