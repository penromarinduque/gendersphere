import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'
import { useToast } from 'primevue/usetoast'

export default function useCauseGenderIssues(){
    const objective = ref([])
    const objectives = ref([])
    // const yearlist = ref([])

    const errors = ref('')
    const router = useRouter()
    const toast = useToast();
    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getObjectives = async (query = {}) => {
        let response = await axios.get('/api/objectives', {
            params: query
        });
        objectives.value = response.data.data
    }
 
    const getObjective = async (id) => {
        let response = await axios.get(`/api/objectives/${id}`)
        objective.value = response.data.data
        // console.log(response.data);
    }

    const storeObjective = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/objectives', data)
            await router.push({ name: 'objectives.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Objective successfully saved',
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
 
    const updateObjective = async (id) => {
        // console.log(objective);
        errors.value = ''
        try {
            await axios.patch(`/api/objectives/${id}`, objective.value)
            await router.push({ name: 'objectives.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Objective successfully updated',
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

    const destroyObjective = async (id) => {
        try {
            await axios.delete(`/api/objectives/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Objective successfully deleted',
                life: 3000
            })
        } catch (e) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            });
            // toaster.info(`Oops! Something went wrong please try again.`);
        }
    }

    // const getYearlist = async () => {
    //     let response = await axios.get('/api/yearlist')
    //     // console.log(response)
    //     yearlist.value = response.data
    // }

    return {
        errors,
        objective,
        objectives,
        // yearlist,
        getObjective,
        getObjectives,
        storeObjective,
        updateObjective,
        destroyObjective,
        // getYearlist
    }
}