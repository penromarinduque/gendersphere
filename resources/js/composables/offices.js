import axios from "../utils/axios";
import { useRouter } from "vue-router";
import { useToast } from "primevue/usetoast";
import { ref } from "vue";
import { createToaster } from '@meforma/vue-toaster'

export default function useOffices () {

    const offices = ref([]);
    const office = ref({});
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
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Office successfully saved',
                life: 3000
            });
            router.push({ name: 'offices.index' });
        } catch (e) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            })
            console.log(e);
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
    }

    const updateOffice = async (data) => {
        console.log(data);
        try {
            const response = await axios.put('/api/offices/update', data);
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Office successfully updated',
                life: 3000
            });
            router.push({ name: 'offices.index' });
        } catch (e) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            })
            console.log(e);
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
    }

    const findOfficeById =async (id) => {
        const response = await axios.get(`/api/offices/${id}`);
        office.value = response.data.data
        return response.data.data
    }

    const getAllOffices = async () => {
        let response = await axios.get('/api/offices')
        offices.value = response.data.data
        return response.data.data
    }

    const deleteOffice = async (id) => {
        try {
            await axios.delete(`/api/offices/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Office successfully deleted',
                life: 3000
            });
            await getAllOffices();
        } catch (e) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            });
        }
    }

    return {
        errors,
        offices,
        office,
        findOfficeById,
        saveOffice,
        getAllOffices,
        updateOffice,
        deleteOffice
    }
}