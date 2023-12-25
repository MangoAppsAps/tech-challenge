<template>
    <div>

        <div class="toast show border" :class="[type === 'success' ? 'border-success' : 'border-danger']">
            <div class="toast-header">
                <strong class="mr-auto text-primary">Notification</strong>
                <button @click="closeToast" type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
            </div>
            <div class="toast-body">
                {{ message }}
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'ToastComponent',

    props: {
        message: {
            type: String,
            required: true
        },
        type: {
            type: String,
            default: 'success' // Default to success type
        }
    },

    mounted() {
        setTimeout(() => {
            this.closeToast();
        }, 7000);
    },

    methods: {
        closeToast() {
            this.$emit('closeToast');
        }
    }
};
</script>

<style>
.toast {
    position: fixed;
    bottom: 30px;
    right: 10px;
    z-index: 1000;
    width: 300px;
    max-width: 100%;
}
</style>
