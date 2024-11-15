import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useCommittees() {
    const committee = ref([])
    const committees = ref([])
    const personinfos = ref([])
    const committeepositions = ref([])
    const yearlist = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getCommittees = async (page = 1, year = null) => {
        let response = await axios.get('/api/committees', {params: { page:page, year:year }})
        console.log(response.data)
        committees.value = response.data
    }
 
    const getCommittee = async (id) => {
        let response = await axios.get(`/api/committees/${id}`)
        committee.value = response.data.data
        // console.log(response.data);
    }

    const storeCommittee = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/committees', data)
            await router.push({ name: 'committees.index' })
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
 
    const updateCommittee = async (id) => {
        // console.log(committee);
        errors.value = ''
        try {
            await axios.patch(`/api/committees/${id}`, committee.value)
            await router.push({ name: 'committees.index' })
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

    const destroyCommittee = async (id) => {
        try {
            await axios.delete(`/api/committees/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
        }
    }

    const getPersonInfos = async () => {
        let response = await axios.get('/api/personinfos')
        personinfos.value = response.data.data
    }

    const getCommitteePositions = async () => {
        let response = await axios.get('/api/committeepositions')
        // console.log(response)
        committeepositions.value = response.data.data
    }

    const getYearlist = async () => {
        let response = await axios.get('/api/yearlist')
        // console.log(response)
        yearlist.value = response.data
    }

    return {
        errors,
        committee,
        committees,
        personinfos,
        committeepositions,
        yearlist,
        getCommittee,
        getCommittees,
        storeCommittee,
        updateCommittee,
        destroyCommittee,
        getPersonInfos,
        getCommitteePositions,
        getYearlist
    }
}