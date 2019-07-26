<template>
    <modal-component name="exportSport">
        <form :action="url" method="post">
            <input type="hidden" name="_token" :value="csrf">
            <div class="field">
                <label class="label" v-text="sports.label"></label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select v-model="sport" :name="sports.name">
                            <option v-for="(option, val) in sports.options" :value="val" v-text="option"></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Date Type</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select v-model="dateType" name="dateTypes">
                            <option v-for="(option,val) in dateTypes" :value="val" v-text="option"></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Date:</label>
                <div class="control">
                    <div class="select is-fullwidth">
                        <select v-model="date" name="date">
                            <option v-for="(option, val) in dates" :value="val" v-text="option"></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button class="button is-fullwidth is-info"
                        type="submit" v-text="this.$translations.export">
                </button>
            </div>
        </form>
    </modal-component>
</template>

<script>
    import ModalComponent from '../Global/ModalComponent';
    import SelectField from './SelectField';

    export default {
        name: "ExportSportForm",
        components: {
            ModalComponent,
            SelectField,
        },
        props: {
            sports: {
                required: true,
                type: Object
            },
            sportDates: {
                required: true,
                type: Object
            },
            dateTypes: {
                required: true,
                type: Array
            },
            url: {
                required: true,
                type: String
            },
        },
        data() {
            return {
                sport: this.sports.value,
                dateType: 0,
                date: null,
                csrf: window.token.content
            }
        },
        computed: {
            dates() {
                return this.sportDates[this.sport][this.dateType];
            },
        }
    }
</script>

<style scoped>

</style>