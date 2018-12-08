<template>
    <div>
        <form-boolean-field :field="field" v-if="is('BOOLEAN')" ref="component" :errors="errors"></form-boolean-field>
        <form-date :field="field" v-if="is('DATE')" ref="component" :errors="errors"></form-date>
        <form-text-field :field="field" v-if="is('TEXT')" ref="component" :errors="errors"></form-text-field>
        <form-textarea-field :field="field" v-if="is('TEXTAREA')" ref="component" :errors="errors"></form-textarea-field>
        <form-trix-field :field="field" v-if="is('TRIX')" ref="component" :errors="errors"></form-trix-field>
        <form-code-field :field="field" v-if="is('CODE')" ref="component" :errors="errors"></form-code-field>
    </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],
    
    data() {
        return {
            types: {
                TEXT: "text",
                DATE: "date",
                BOOLEAN: "boolean",
                TEXTAREA: "textarea",
                TRIX: "trix",
                CODE: "code"
            },
            parsedField: {}
        }
    },
    
    methods: {
        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            const component = this.$refs['component'];
            formData.append(this.field.attribute, this.parseValue(component.value));
        },

        parseValue(value) {
            if(this.field.type === this.types.BOOLEAN) {
                return value ? 1 : 0;
            }
            return value;
        },

        is(type) {
            return this.types[type] === this.field.type;
        }
    },
}
</script>
