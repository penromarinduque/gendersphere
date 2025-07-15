import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'
import { useToast } from 'primevue/usetoast'

export default function useFrontlineServiceTypes() {
    const frontlineservicetype = ref([])
    const frontlineservicetypes = ref([])

    const errors = ref('')
    const router = useRouter()
    const toast = useToast();
    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getFrontlineServiceTypes = async () => {
        let response = await axios.get('/api/frontlineservicetypes')
        frontlineservicetypes.value = response.data.data
    }
 
    const getFrontlineServiceType = async (id) => {
        let response = await axios.get(`/api/frontlineservicetypes/${id}`)
        frontlineservicetype.value = response.data.data
        // console.log(response.data);
    }

    const storeFrontlineServiceType = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/frontlineservicetypes', data)
            await router.push({ name: 'frontlineservicetypes.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Frontline Service Type successfully saved',
                life: 3000
            })
        } catch (e) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            })
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
    }
 
    const updateFrontlineServiceType = async (id) => {
        console.log(frontlineservicetype);
        errors.value = ''
        try {
            await axios.patch(`/api/frontlineservicetypes/${id}`, frontlineservicetype.value)
            await router.push({ name: 'frontlineservicetypes.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Frontline Service Type successfully updated',
                life: 3000
            })
        } catch (e) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            })
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
    }

    const destroyFrontlineServiceType = async (id) => {
        try {
            await axios.delete(`/api/frontlineservicetypes/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Frontline Service Type successfully deleted',
                life: 3000
            })
        } catch (e) {
            // console.log(e);
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            })
        }
    }

    return {
        errors,
        frontlineservicetype,
        frontlineservicetypes,
        getFrontlineServiceType,
        getFrontlineServiceTypes,
        storeFrontlineServiceType,
        updateFrontlineServiceType,
        destroyFrontlineServiceType
    }
}