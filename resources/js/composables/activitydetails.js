import { defineComponent, ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster';
import { useToast } from 'primevue/usetoast';

export default function useActivityDetails(){
    const activitydetail = ref([])
    const activitydetails = ref([])
    const loading = ref(false)

    const errors = ref('')
    const router = useRouter()
    const toast = useToast();
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
        console.log("test")
        loading.value = true;
        try {
            await axios.post('/api/activitydetails', data)
            await router.push({ name: 'activitydetails.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Activity successfully saved',
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
 
    const updateActivityDetail = async (id) => {
        // console.log(personinfo);
        errors.value = ''
        try {
            await axios.patch(`/api/activitydetails/${id}`, activitydetail.value)
            await router.push({ name: 'activitydetails.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Activity successfully updated',
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

    const updateActivityDetailAccom = async (id) => {
        // console.log(activitydetail.value);
        errors.value = ''
        try {
            await axios.post(`/api/updateaccom/${id}`, activitydetail.value)
            await router.push({ name: 'activitydetails.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Accommodation successfully updated',
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

    const destroyActivityDetail = async (id) => {
        try {
            await axios.delete(`/api/activitydetails/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Activity successfully deleted',
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
        activitydetail,
        activitydetails,
        errors,
        loading,
        getActivityDetail,
        getActivityDetails,
        storeActivityDetail,
        updateActivityDetail,
        updateActivityDetailAccom,
        destroyActivityDetail
    }
}

