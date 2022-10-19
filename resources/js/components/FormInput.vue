<template>
    <div>
        <input v-bind="$attrs" :class="['form-control', error ? 'is-invalid' :'']"
               :value="value"
               @input="$emit('input', $event.target.value)"
               ref="input">
        <div class="text-red-500 mt-1 text-sm" v-show="error">{{ error }}</div>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
    props: {
        value: {
            type: [String, Number],
        },
        error: {
            type: String
        }
    },
    mounted() {
        if (this.$refs.input.hasAttribute('autofocus')) {
            this.$refs.input.focus();
        }
    }
}
</script>
