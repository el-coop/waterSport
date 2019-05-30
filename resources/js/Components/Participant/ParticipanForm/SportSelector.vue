<template>
	<div class="card h-100">
		<header class="card-header">
			<div class="card-header-title" v-text="'Sports'"></div>
		</header>

		<div class="card-content">
			<div class="panel" v-if="selectedSports.length">
				<p class="panel-block" v-for="(sport, index) in selectedSports">
					<span class="panel-icon" @click="editSport(sport)">
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
			<button @click="addSport" class="button is-success is-fullwidth" :disabled="! newSport">
				Add
			</button>
		</div>
		<SportModal :sport="selectedSport || {}" @filled="saveSportsForm" :form="formData"/>
	</div>
</template>

<script>
	import SportModal from "./SportModal";

	export default {
		name: "SportSelector",
		components: {SportModal},
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

		data() {
			return {
				selectedSports: this.initSelectedSports,
				newSport: null,
				selectedSport: null,
				sportsData: {}
			};
		},


		methods: {
			addSport() {
				this.selectedSports.push(parseInt(this.newSport));
				this.editSport(this.newSport);
				this.newSport = null;
			},
			editSport(sport) {
				this.selectedSport = this.sports[sport];
				this.$modal.show('sportModal')
			},
			removeSport(sportIndex) {
				this.selectedSports.splice(sportIndex, 1)
			},
			saveSportsForm(data) {
				this.sportsData[parseInt(data.sport)] = data.data;
				this.selectedSport = null;
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
			},
			formData() {
				if (this.selectedSport) {
					return this.sportsData[parseInt(this.selectedSport.id)] || {};
				}

				return {};
			}
		}
	}
</script>

<style scoped lang="scss">
	.panel-icon, .tag {
		cursor: pointer;
	}
</style>
