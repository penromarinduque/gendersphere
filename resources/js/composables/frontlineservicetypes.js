import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useFrontlineServiceTypes() {
    const frontlineservicetype = ref([])
    const frontlineservicetypes = ref([])

    const errors = ref('')
    const router = useRouter()

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
            toaster.success(`Successfully Saved!`);
        } catch (e) {
            console.log(e);
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
            toaster.success(`Successfully Updated!`);
        } catch (e) {
            console.log(e);
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
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
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
        destroyFrontlineServiceType,
    }
}