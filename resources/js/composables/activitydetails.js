import { defineComponent, ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useActivityDetails(){
    const activitydetail = ref([])
    const activitydetails = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getActivityDetails = async (ga_id) => {
        let response = await axios.get(`/api/activitydetails?ga_id=${ga_id}`)
        activitydetails.value = response.data.data
    }
 
    const getActivityDetail = async (id) => {
        let response = await axios.get(`/api/activitydetails/${id}`)
        activitydetail.value = response.data.data
        // console.log(response.data);
    }

    const storeActivityDetail = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/activitydetails', data)
            await router.push({ name: 'activitydetails.index' })
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
 
    const updateActivityDetail = async (id) => {
        // console.log(personinfo);
        errors.value = ''
        try {
            await axios.patch(`/api/activitydetails/${id}`, activitydetail.value)
            await router.push({ name: 'activitydetails.index' })
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

    const updateActivityDetailAccom = async (id) => {
        // console.log(activitydetail.value);
        errors.value = ''
        try {
            await axios.post(`/api/updateaccom/${id}`, activitydetail.value)
            await router.push({ name: 'activitydetails.index' })
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

    const destroyActivityDetail = async (id) => {
        try {
            await axios.delete(`/api/activitydetails/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
        }
    }

    return {
        activitydetail,
        activitydetails,
        errors,
        getActivityDetail,
        getActivityDetails,
        storeActivityDetail,
        updateActivityDetail,
        updateActivityDetailAccom,
        destroyActivityDetail
    }
}

