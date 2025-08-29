import { useToast } from "primevue";
import axios from "../utils/axios";
import { ref } from "vue";

export default function useSignatories() {
    const signatories = ref([]);
    const errors = ref([]);
    const toast = useToast();

    const storeSignatories = async (params = {}) => {
        errors.value = [];
        try {
            const response = await axios.post('/api/signatories/store-gpb-signatory', params);
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: "Signatories successfully saved",
                life: 3000
            });
            return true;
        } catch (error) {
            if(error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value = error.response.data.errors
                }
            }
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: error.response.data.message,
                life: 3000
            });
            return false;
        }
    }

    const getSignatories = async () => {
        try {
            const response = await axios.get('/api/signatories');
            signatories.value = response.data;
        } catch (error) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: error.response.data.message,
                life: 3000
            });
        }
    }

    return {
        signatories,
        errors,
        storeSignatories,
        getSignatories
    }
}