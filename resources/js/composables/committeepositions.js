import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useCommitteePositions() {
    const committeeposition = ref([])
    const committeepositions = ref([])
    const personinfos = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getCommitteePositions = async () => {
        let response = await axios.get('/api/committeepositions')
        committeepositions.value = response.data.data
    }
 
    const getCommitteePosition = async (id) => {
        let response = await axios.get(`/api/committeepositions/${id}`)
        committeeposition.value = response.data.data
        // console.log(response.data);
    }

    const storeCommitteePosition = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/committeepositions', data)
            await router.push({ name: 'committeepositions.index' })
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
 
    const updateCommitteePosition = async (id) => {
        console.log(committeeposition);
        errors.value = ''
        try {
            await axios.patch(`/api/committeepositions/${id}`, committeeposition.value)
            await router.push({ name: 'committeepositions.index' })
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

    const destroyCommitteePosition = async (id) => {
        try {
            await axios.delete(`/api/committeepositions/${id}`)
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

    return {
        errors,
        committeeposition,
        committeepositions,
        personinfos,
        getCommitteePosition,
        getCommitteePositions,
        storeCommitteePosition,
        updateCommitteePosition,
        destroyCommitteePosition,
        getPersonInfos
    }
}