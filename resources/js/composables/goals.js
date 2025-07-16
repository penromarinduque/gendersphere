import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'
import { useToast } from 'primevue/usetoast'

export default function useGoals(){
    const goal = ref([])
    const goals = ref([])

    const errors = ref('')
    const router = useRouter()
    const toast = useToast()
    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getGoals = async (query = {}) => {
        let response = await axios.get('/api/goals', {
            params: query
        })
        goals.value = response.data.data
    }
 
    const getGoal = async (id) => {
        let response = await axios.get(`/api/goals/${id}`)
        goal.value = response.data.data
        // console.log(response.data);
    }

    const storeGoal = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/goals', data)
            await router.push({ name: 'goals.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Goal successfully saved',
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
 
    const updateGoal = async (id) => {
        // console.log(goal);
        errors.value = ''
        try {
            await axios.patch(`/api/goals/${id}`, goal.value)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Goal successfully updated',
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

    const destroyGoal = async (id) => {
        try {
            await axios.delete(`/api/goals/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Goal successfully deleted',
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

    return {
        errors,
        goal,
        goals,
        getGoal,
        getGoals,
        storeGoal,
        updateGoal,
        destroyGoal
    }
}