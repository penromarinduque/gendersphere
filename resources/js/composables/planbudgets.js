import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster';
import { useToast } from 'primevue/usetoast'

export default function usePlanBudgets(){
    const planbudget = ref([])
    const planbudgets = ref([])
    const yearlist = ref([])
    const loading = ref(false)

    const errors = ref('')
    const router = useRouter()
    const toast = useToast();
    const toaster = createToaster({ 
        position: "top"
        // max:
    });


    const getPlanBudgets = async (year, query = {}) => {
        let response = await axios.get(`/api/planbudgets`, {params: {
            year: year,
            ...query
        }})
        // console.log(response)
        planbudgets.value = response.data.data
    }
 
    const getPlanBudget = async (id) => {
        let response = await axios.get(`/api/planbudgets/${id}`)
        planbudget.value = response.data.data
        // console.log(response.data);
    }

    const storePlanBudget = async (data) => {
        loading.value = true;
        errors.value = ''
        try {
            await axios.post('/api/planbudgets', data)
            await router.push({ name: 'planbudgets.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Plan successfully saved',
                life: 3000
            })
            loading.value = false;
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
            loading.value = false;
        }
    }
 
    const updatePlanBudget = async (id) => {
        // console.log(planbudget);
        loading.value = true;
        errors.value = ''
        try {
            await axios.patch(`/api/planbudgets/${id}`, planbudget.value)
            await router.push({ name: 'planbudgets.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Plan successfully updated',
                life: 3000
            })
            loading.value = false;
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
            loading.value = false;
        }
    }

    const destroyPlanBudget = async (id) => {
        loading.value = true;
        try {
            await axios.delete(`/api/planbudgets/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Plan successfully deleted',
                life: 3000
            })
            loading.value = false;
        } catch (e) {
            // console.log(e);
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            })
            loading.value = false;
        }
    }

    const getYearlist = async () => {
        let response = await axios.get('/api/yearlist')
        console.log(response.data)
        yearlist.value = response.data
    }

    return {
        errors,
        planbudget,
        planbudgets,
        yearlist,
        loading,
        getPlanBudget,
        getPlanBudgets,
        storePlanBudget,
        updatePlanBudget,
        destroyPlanBudget,
        getYearlist
    }
}