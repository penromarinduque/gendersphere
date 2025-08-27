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
        planbudgets.value = response.data.data
    }
 
    const getPlanBudget = async (id) => {
        let response = await axios.get(`/api/planbudgets/${id}`)
        planbudget.value = response.data.data;
        console.log("planbudget :", response);
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
        let response = await axios.get('/api/yearlist');
        yearlist.value = response.data
    }

    const storeAttributedProgram = async (params = {}) => {
        loading.value = true;
        try {
            const response = await axios.post('/api/planbudgets/add-attributed-program', params);
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: "Attributed Program successfully saved",
                life: 3000
            });
            await router.push({ name: 'planbudgets.index' })
        } catch (error) {
            if(error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value = error.response.data.errors
                }
            }
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: error.response.data.message,
                life: 3000
            });
        } finally {
            loading.value = false;
        }
    }

    const updateAttributedProgram = async (params = {}) => {
        loading.value = true;
        errors.value = ''
        try {
            const response = await axios.put(`/api/planbudgets/update-attributed-program/${planbudget.value.id}`, planbudget.value);
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: "Attributed Program successfully updated",
                life: 3000
            });
            console.log("response : ", response);
            await router.push({ name: 'planbudgets.index' });
        } catch (error) {
            if(error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value = error.response.data.errors
                }
            }
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: error.response.data.message,
                life: 3000
            });
        } finally {
            loading.value = false;
        }
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
        getYearlist,
        storeAttributedProgram,
        updateAttributedProgram
    }
}