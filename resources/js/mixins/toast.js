export default {
    methods: {
        showToast(message, type = 'success') {
            this.toast.message = message;
            this.toast.type = type;
            this.toast.show = true;
        },

        closeToast() {
            this.toast.show = false;
        }
    },
    data() {
        return {
            toast: {
                message: '',
                type: 'success',
                show: false
            }
        };
    }
};
