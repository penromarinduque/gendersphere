import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'
import { useToast } from 'primevue/usetoast';  

export default function useGenderIssues(){
    const toast = useToast();
    const genderissue = ref([])
    const genderissues = ref([])
    const yearlist = ref([])
    const genderissuesbyyear = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getGenderIssues = async (query = {}) => {
        let response = await axios.get('/api/genderissues', {
            params: query
        })
        genderissues.value = response.data.data
    }
 
    const getGenderIssue = async (id) => {
        let response = await axios.get(`/api/genderissues/${id}`)
        genderissue.value = response.data.data
        // console.log(response.data);
    }

    const storeGenderIssue = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/genderissues', data)
            await router.push({ name: 'genderissues.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Gender Issue successfully saved',
                life: 3000
            })
        } catch (e) {
            console.log(e);
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
    }
 
    const updateGenderIssue = async (id) => {
        // console.log(genderissue);
        errors.value = ''
        try {
            await axios.patch(`/api/genderissues/${id}`, genderissue.value)
            await router.push({ name: 'genderissues.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Gender Issue successfully updated',
                life: 3000
            })
        } catch (e) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            });
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
    }

    const destroyGenderIssue = async (id) => {
        try {
            await axios.delete(`/api/genderissues/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            });
        }
    }

    const getGenderIssuesByYear = async (year) => {
        let response = await axios.get(`/api/genderissuebyyear/${year}`)
        genderissuesbyyear.value = response.data.data
        // console.log(response.data.data)
    }

    const getYearlist = async () => {
        let response = await axios.get('/api/yearlist')
        // console.log(response)
        yearlist.value = response.data
    }

    return {
        errors,
        genderissue,
        genderissues,
        genderissuesbyyear,
        yearlist,
        getGenderIssue,
        getGenderIssues,
        storeGenderIssue,
        updateGenderIssue,
        destroyGenderIssue,
        getGenderIssuesByYear,
        getYearlist
    }
}