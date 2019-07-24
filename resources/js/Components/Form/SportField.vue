<template>
    <div class="mb-1" v-if="field.sportFields.length > 0">
        <h4 class="subtitle" v-text="field.name"></h4>
        <component v-for="(sportField, key) in field.sportFields" :key="key" :field="fieldSetup(sportField)"
                   :is="`${sportField.type}-field`"></component>
    </div>
</template>

<script>
    import FieldMixin from './FieldMixin';

    export default {
        name: "SportField",
        mixins: [FieldMixin],
        methods: {
            fieldSetup(sportField) {
                return {
                    label: sportField.title,
                    placeholder: sportField.placeholder,
                    name: `sports[${this.field.id}][${sportField.id}]`,
                    value: this.field.fields[sportField.id]
                }
            }
        }
    }
</script>