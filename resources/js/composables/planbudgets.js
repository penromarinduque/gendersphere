import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function usePlanBudgets(){
    const planbudget = ref([])
    const planbudgets = ref([])
    const yearlist = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getPlanBudgets = async () => {
        let response = await axios.get('/api/planbudgets')
        // console.log(response)
        planbudgets.value = response.data.data
    }
 
    const getPlanBudget = async (id) => {
        let response = await axios.get(`/api/planbudgets/${id}`)
        planbudget.value = response.data.data
        // console.log(response.data);
    }

    const storePlanBudget = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/planbudgets', data)
            await router.push({ name: 'planbudgets.index' })
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
 
    const updatePlanBudget = async (id) => {
        // console.log(planbudget);
        errors.value = ''
        try {
            await axios.patch(`/api/planbudgets/${id}`, planbudget.value)
            await router.push({ name: 'planbudgets.index' })
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

    const destroyPlanBudget = async (id) => {
        try {
            await axios.delete(`/api/planbudgets/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
        }
    }

    const getYearlist = async () => {
        let response = await axios.get('/api/yearlist')
        // console.log(response)
        yearlist.value = response.data
    }

    return {
        errors,
        planbudget,
        planbudgets,
        yearlist,
        getPlanBudget,
        getPlanBudgets,
        storePlanBudget,
        updatePlanBudget,
        destroyPlanBudget,
        getYearlist
    }
}