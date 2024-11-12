import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useCauseGenderIssues(){
    const causegenderissue = ref([])
    const causegenderissues = ref([])
    // const yearlist = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getCauseGenderIssues = async () => {
        let response = await axios.get('/api/causegenderissues')
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
 
    const updateCauseGenderIssue = async (id) => {
        // console.log(causegenderissue);
        errors.value = ''
        try {
            await axios.patch(`/api/causegenderissues/${id}`, causegenderissue.value)
            await router.push({ name: 'causegenderissues.index' })
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

    const destroyCauseGenderIssue = async (id) => {
        try {
            await axios.delete(`/api/causegenderissues/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
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