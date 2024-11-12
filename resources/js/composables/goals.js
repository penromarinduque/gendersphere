import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useGoals(){
    const goal = ref([])
    const goals = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getGoals = async () => {
        let response = await axios.get('/api/goals')
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
 
    const updateGoal = async (id) => {
        // console.log(goal);
        errors.value = ''
        try {
            await axios.patch(`/api/goals/${id}`, goal.value)
            await router.push({ name: 'goals.index' })
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

    const destroyGoal = async (id) => {
        try {
            await axios.delete(`/api/goals/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
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