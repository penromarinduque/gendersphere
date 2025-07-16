import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'
import { useToast } from 'primevue/usetoast'

export default function useActivities() {
    const activity = ref([])
    const activities = ref([])
    const personinfos = ref([])
    const personinfo = ref([])
    const attendees = ref([])
    const provinces = ref([])
    const municipalities = ref([])
    const barangays = ref([])

    const errors = ref('')
    const router = useRouter()
    const toast = useToast();
    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getActivities = async () => {
        let response = await axios.get('/api/activities')
        activities.value = response.data.data
    }
 
    const getActivity = async (id) => {
        let response = await axios.get(`/api/activities/${id}`)
        activity.value = response.data.data
        // console.log(response.data);
    }

    const storeActivity = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/activities', data)
            await router.push({ name: 'activities.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Activity successfully saved',
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
 
    const updateActivity = async (id) => {
        // console.log(personinfo);
        errors.value = ''
        try {
            await axios.patch(`/api/activities/${id}`, activity.value)
            await router.push({ name: 'activities.index' })
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

    const destroyActivity = async (id) => {
        try {
            await axios.delete(`/api/activities/${id}`)
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

    const getPersonInfos = async () => {
        let response = await axios.get('/api/personinfos')
        personinfos.value = response.data.data
    }

    const getPersonInfo = async (id) => {
        let response = await axios.get(`/api/personinfos/${id}`)
        personinfo.value = response.data.data
        // console.log(response.data);
    }

    const getAttendees = async (id) => {
        let response = await axios.get(`/api/attendees/${id}`)
        attendees.value = response.data.data
        // console.log(response);
    }

    const storeAttendee = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/attendees', data)
            await router.push({ name: 'activities.attendees' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Attendee successfully saved',
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

    const updatePersonInfo = async (id, activity_id) => {
        // console.log(personinfo);
        errors.value = ''
        try {
            await axios.patch(`/api/personinfos/${id}`, personinfo.value)
            await router.push({ name: 'activities.attendees', params: { id: activity_id } })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Person successfully updated',
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

    const destroyAttendee = async (id) => {
        console.log(id);
        try {
            await axios.delete(`/api/attendees/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Attendee successfully deleted',
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
        }
        
    }

    const getProvinces = async () => {
        let response = await axios.get('/api/provinces')
        provinces.value = response.data.data
    }

    const getMunicipalities = async (id) => {
        let response = await axios.get(`/api/municipalities/${id}`)
        municipalities.value = response.data.data
        // console.log(response.data);
    }

    const getBarangays = async (id) => {
        let response = await axios.get(`/api/barangays/${id}`)
        barangays.value = response.data.data
        // console.log(response.data);
    }

    return {
        errors,
        activity,
        activities,
        personinfos,
        personinfo,
        attendees,
        provinces,
        municipalities,
        barangays,
        getActivity,
        getActivities,
        storeActivity,
        updateActivity,
        destroyActivity,
        getPersonInfos,
        getPersonInfo,
        getAttendees,
        getProvinces,
        getMunicipalities,
        getBarangays,
        storeAttendee,
        updatePersonInfo,
        destroyAttendee
    }
}