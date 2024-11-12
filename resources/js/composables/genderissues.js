import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useGenderIssues(){
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

    const getGenderIssues = async () => {
        let response = await axios.get('/api/genderissues')
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
 
    const updateGenderIssue = async (id) => {
        // console.log(genderissue);
        errors.value = ''
        try {
            await axios.patch(`/api/genderissues/${id}`, genderissue.value)
            await router.push({ name: 'genderissues.index' })
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

    const destroyGenderIssue = async (id) => {
        try {
            await axios.delete(`/api/genderissues/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
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