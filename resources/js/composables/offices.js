import axios from "../utils/axios";
import { useRouter } from "vue-router";
import { useToast } from "primevue/usetoast";
import { ref } from "vue";
import { createToaster } from '@meforma/vue-toaster'

export default function useOffices () {

    const offices = ref([]);
    const errors = ref('');
    const router = useRouter();
    const toast = useToast();
    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const saveOffice = async (data) => {
        console.log(data);
        try {
            const response = await axios.post('/api/offices', data);
            toaster.success(`Successfully Saved!`);
            router.push({ name: 'offices.index' });
        } catch (e) {
            toaster.error(`Unexpected error occured while saving the office.`);
            console.log(e);
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
    }

    const getAllOffices = async () => {
        let response = await axios.get('/api/offices')
        offices.value = response.data.data
        return response.data.data
    }

    return {
        errors,
        offices,
        saveOffice,
        getAllOffices
    }
}