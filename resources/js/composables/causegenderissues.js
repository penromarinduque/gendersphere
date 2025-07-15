import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster';
import { useToast } from "primevue/usetoast";

export default function useCauseGenderIssues(){
    const causegenderissue = ref([])
    const causegenderissues = ref([])
    // const yearlist = ref([])

    const errors = ref('')
    const router = useRouter()
    const toast = useToast();
    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getCauseGenderIssues = async (query = {}) => {
        let response = await axios.get('/api/causegenderissues', {
            params: query
        })
        causegenderissues.value = response.data.data
    }
 
    const getCauseGenderIssue = async (id) => {
        let response = await axios.get(`/api/causegenderissues/${id}`)
        causegenderissue.value = response.data.data
        // console.log(response.data);
    }

    const storeCauseGenderIssue = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/causegenderissues', data)
            await router.push({ name: 'causegenderissues.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Cause Gender Issue successfully saved',
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
 
    const updateCauseGenderIssue = async (id) => {
        // console.log(causegenderissue);
        errors.value = ''
        try {
            await axios.patch(`/api/causegenderissues/${id}`, causegenderissue.value)
            await router.push({ name: 'causegenderissues.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Cause Gender Issue successfully updated',
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

    const destroyCauseGenderIssue = async (id) => {
        try {
            await axios.delete(`/api/causegenderissues/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Cause Gender Issue successfully deleted',
                life: 3000
            })
        } catch (e) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            })
        }
    }

    // const getYearlist = async () => {
    //     let response = await axios.get('/api/yearlist')
    //     // console.log(response)
    //     yearlist.value = response.data
    // }

    return {
        errors,
        causegenderissue,
        causegenderissues,
        // yearlist,
        getCauseGenderIssue,
        getCauseGenderIssues,
        storeCauseGenderIssue,
        updateCauseGenderIssue,
        destroyCauseGenderIssue,
        // getYearlist
    }
}