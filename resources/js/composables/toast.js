import { ref } from 'vue';

export default function useToast() {
    const toast = ref({
        show: false,
        message: '',
        type: 'success',
    });

    function showToast(message, type = 'success') {
        toast.value.message = message;
        toast.value.type = type;
        toast.value.show = true;

        setTimeout(() => {
            closeToast();
        }, 5000);
    }

    function closeToast() {
        toast.value.show = false;
        toast.value.message = '';
        toast.value.type = 'success'; // Reset type to default
    }

    return {
        toast,
        showToast,
        closeToast,
    };
}
