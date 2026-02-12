import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'
import { useToast } from 'primevue/usetoast'

export default function useCommitteePositions() {
    const committeeposition = ref([])
    const committeepositions = ref([])
    const personinfos = ref([])

    const errors = ref('')
    const router = useRouter()
    const toast = useToast()
    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getCommitteePositions = async (query) => {
        let response = await axios.get('/api/committeepositions', {
            params: query
        })
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
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Committee Position successfully saved',
                life: 3000
            })
        } catch (e) {
            console.log(e);
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
 
    const updateCommitteePosition = async (id) => {
        console.log(committeeposition);
        errors.value = ''
        try {
            await axios.patch(`/api/committeepositions/${id}`, committeeposition.value)
            await router.push({ name: 'committeepositions.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Committee Position successfully updated',
                life: 3000
            })
        } catch (e) {
            console.log(e);
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

    const destroyCommitteePosition = async (id) => {
        try {
            await axios.delete(`/api/committeepositions/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Committee Position successfully deleted',
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