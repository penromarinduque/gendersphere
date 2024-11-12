import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useGadActivities(){
    const gadactivity = ref([])
    const gadactivities = ref([])
    const planbudget_id = ref()

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getGadActivities = async () => {
        let response = await axios.get('/api/gadactivities')
        // console.log(response)
        gadactivities.value = response.data.data
    }
 
    const getGadActivity = async (id) => {
        let response = await axios.get(`/api/gadactivities/${id}`)
        gadactivity.value = response.data.data
        // console.log(response.data);
    }

    const storeGadActivity = async (data) => {
        // console.log(data);
        errors.value = ''
        try {
            await axios.post('/api/gadactivities', data)
            // await router.push({ name: 'planbudgets.index', replace:true })
            await router.go(0)
            toaster.success(`Successfully Saved!`);
            closeModal()
        } catch (e) {
            openModal()
            console.log(e);
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
    }
 
    const updateGadActivity = async (id, ga_id) => {
        // console.log(personinfo);
        errors.value = ''
        try {
            await axios.patch(`/api/gadactivities/${id}`, gadactivity.value)
            await router.push({ name: 'activitydetails.index', params: { ga_id: ga_id} })
            toaster.success(`Successfully updated!`);
        } catch (e) {
            console.log(e);
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
    }

    const destroyGadActivity = async (id) => {
        try {
            await axios.delete(`/api/gadactivities/${id}`)
            await router.push({ name: 'planbudgets.index' })
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
        }
    }

    const putPlanBudgetId = async (id) => {
        planbudget_id.value = id
    }

    const isModalOpened = ref(false);

    const openModal = () => {
        isModalOpened.value = true;
    }
    const closeModal = () => {
        isModalOpened.value = false;
    }

    return {
        gadactivity,
        gadactivities,
        errors,
        planbudget_id,
        isModalOpened,
        getGadActivity,
        getGadActivities,
        storeGadActivity,
        updateGadActivity,
        destroyGadActivity,
        putPlanBudgetId,
        openModal,
        closeModal
    }
}