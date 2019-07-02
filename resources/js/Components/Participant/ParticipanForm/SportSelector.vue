<template>
	<div class="mr-half">
		<h4 class="title is-4" v-text="$translations.sports"></h4>

		<div class="panel" v-if="selectedSports.length">
			<p class="panel-block" v-for="(sport, index) in selectedSports">
					<span class="panel-icon" @click="editSport(sport)">
						<font-awesome-icon icon="edit"></font-awesome-icon>
					</span>
				<span v-text="findSport(sport).name"></span>
				<span class="mr-1 ml-auto has-text-success">
					<font-awesome-icon icon="check"></font-awesome-icon>
				</span>
				<span class="tag is-danger" @click="removeSport(sport)">
					<font-awesome-icon icon="trash"></font-awesome-icon>
				</span>
			</p>
		</div>
		<div class="field">
			<label class="label" v-text="$translations.addSport"></label>
			<div class="select is-fullwidth">
				<select v-model="newSport">
					<option v-for="(option, val) in options" :key="val" :value="val"
							v-text="option"></option>
				</select>
			</div>
		</div>
		<button @click="addSport" class="button is-success is-fullwidth" :disabled="! newSport" v-text="$translations.add">
		</button>
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
				type: Array,
				default() {
					return [];
				}
			},
			value: {
				type: Object,
				default() {
					return {}
				}
			}
		},

		data() {
			return {
				selectedSports: this.initSelectedSports,
				newSport: null,
				selectedSport: null
			};
		},


		methods: {
			addSport() {
				this.editSport(this.newSport);
				this.newSport = null;
			},
			editSport(sport) {
				this.selectedSport = this.findSport(sport);
				this.$modal.show('sportModal')
			},
			removeSport(sportIndex) {
				this.selectedSports.splice(sportIndex, 1)
			},
			saveSportsForm(data) {
				if (!this.selectedSports.includes(data.sport)) {
					this.selectedSports.push(data.sport);
				}
				const val = Object.assign({}, this.value);
				val[parseInt(data.sport)] = data.data;
				this.selectedSport = null;
				this.$emit('input', val);
			},
			findSport(id) {
				return this.sports.find((sport) => {
					return sport.id === parseInt(id);
				});
			}
		},

		computed: {
			options() {
				const options = {};
				this.sports.forEach((sport, index) => {
					if (!this.selectedSports.includes(sport.id 	)) {
						options[sport.id] = sport.name;
					}
				});
				return options;
			},
			formData() {
				if (this.selectedSport) {
					return this.value[parseInt(this.selectedSport.id)] || {};
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

	.border-left {
		border-left: hsl(0, 0%, 86%) 1px dashed;
	}
</style>
