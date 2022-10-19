<template>
    <form @submit.prevent="submit">
        <div class="form-group w-48">
            <label for="date">Date</label>
            <FormInput type="date" id="date" v-model="journal.date" :error="errors.date"/>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <FormTextarea rows="3" id="content" v-model="journal.content" :error="errors.content"/>
        </div>
        <div class="flex space-x-2">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button @click="$emit('close')" type="button" class="btn btn-secondary">Cancel</button>
        </div>
    </form>
</template>

<script>
import intus from "intus";
import FormInput from "./FormInput";
import FormTextarea from "./FormTextarea";
import {isDate, isRequired} from "intus/rules";

const emptyForm = {
    date: '',
    content: ''
};

export default {
    components: {
        FormTextarea,
        FormInput
    },
    props: {
        clientId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            isSubmitting: false,
            errors: {},
            journal: {
                ...emptyForm
            }
        }
    },
    methods: {
        submit() {
            if (this.isSubmitting) return;

            const validation = intus.validate({
                ...this.journal,
                date: new Date(this.journal.date)
            }, {
                date: [isRequired(), isDate()],
                content: [isRequired()],
            });

            this.errors = validation.errors();

            if (validation.passes()) {
                this.isSubmitting = true;
                axios.post(`/clients/${this.clientId}/journals`, this.journal)
                    .then(({data}) => {
                        this.$emit('created', data);
                        this.$emit('close');
                        this.journal = {...emptyForm};
                    })
                    .catch((error) => this.errors = this.processServerError(error))
                    .finally(() => this.isSubmitting = false)
            }
        }
    }
}
</script>
