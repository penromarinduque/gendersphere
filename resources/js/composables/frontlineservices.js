import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useFrontlineServices() {
    const frontlineservice = ref([])
    const frontlineservices = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getFrontlineServices = async () => {
        let response = await axios.get('/api/frontlineservices')
        // console.log(response)
        frontlineservices.value = response.data.data
    }
 
    const getFrontlineService = async (id) => {
        let response = await axios.get(`/api/frontlineservices/${id}`)
        // console.log(response);
        frontlineservice.value = response.data.data
        // console.log(response.data);
    }

    const storeFrontlineService = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/frontlineservices', data)
            await router.push({ name: 'frontlineservices.index' })
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
 
    const updateFrontlineService = async (id) => {
        console.log(frontlineservice);
        errors.value = ''
        try {
            await axios.patch(`/api/frontlineservices/${id}`, frontlineservice.value)
            await router.push({ name: 'frontlineservices.index' })
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

    const destroyFrontlineService = async (id) => {
        try {
            await axios.delete(`/api/frontlineservices/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
        }
    }

    return {
        errors,
        frontlineservice,
        frontlineservices,
        getFrontlineService,
        getFrontlineServices,
        storeFrontlineService,
        updateFrontlineService,
        destroyFrontlineService,
    }
}