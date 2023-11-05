<template>
    <div class="select-container">
        <label v-if="label">{{ label }}: </label>
        <select :id="id" v-model="selectedOption" :name="name" class="border p-1" @change="onChange">
            <option v-for="(option, index) in options" :key="index" :value="option.value">
                {{ option.text }}
            </option>
        </select>
    </div>
</template>

<script>
    export default {
        name: 'DropdownComponent',
        props: {
            id: {
                type: String,
                required: true,
            },
            name: {
                type: String,
                required: true,
            },
            options: {
                type: Array,
                required: true,
            },
            label: {
                type: String,
                required: false,
                default: null,
            },
        },
        data() {
            return {
                selectedOption: null,
            };
        },
        mounted() {
            // Select the first value in the options
            // TODO: We would probably want a way for the parent
            //       to determine the default selected option.
            this.selectedOption = this.options[0].value;
        },
        methods: {
            onChange() {
                this.$emit('selected', this.selectedOption);
            },
        },
    }
</script>
