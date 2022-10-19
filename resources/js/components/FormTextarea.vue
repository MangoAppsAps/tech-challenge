<template>
    <div>
        <textarea v-bind="$attrs"
                  :class="['form-control', error ? 'is-invalid' :'']"
                  @input="$emit('input', $event.target.value)"
                  ref="textarea">{{ value }}</textarea>
        <div class="text-red-500 mt-1 text-sm" v-show="error">{{ error }}</div>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
    props: {
        value: {
            type: String,
        },
        error: {
            type: String
        }
    },
    mounted() {
        if (this.$refs.textarea.hasAttribute('autofocus')) {
            this.$refs.textarea.focus();
        }
    }
}
</script>
