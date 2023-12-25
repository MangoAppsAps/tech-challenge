<template>
    <div>
        <form class="m-2" @submit.prevent="submitForm">
            <h4>Write a new journal</h4>

            <div class="form-group">
                <textarea class="form-control" id="journal-text" rows="3" v-model="journal.text"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "JournalForm",

    data() {
        return {
            journal: {
                text: '',
            },
        }
    },
    methods: {
        submitForm() {
            this.$emit("submit", { ...this.journal });

            this.journal.text = ""; // Clear the textarea after submission
        },
    },
}
</script>
