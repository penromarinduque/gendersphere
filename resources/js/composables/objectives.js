import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useCauseGenderIssues(){
    const objective = ref([])
    const objectives = ref([])
    // const yearlist = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getObjectives = async () => {
        let response = await axios.get('/api/objectives')
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
 
    const updateObjective = async (id) => {
        // console.log(objective);
        errors.value = ''
        try {
            await axios.patch(`/api/objectives/${id}`, objective.value)
            await router.push({ name: 'objectives.index' })
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

    const destroyObjective = async (id) => {
        try {
            await axios.delete(`/api/objectives/${id}`)
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