import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useAttendees() {
    const personinfos = ref([])
    const personinfo = ref([])
    const attendees = ref([])
    const provinces = ref([])
    const municipalities = ref([])
    const barangays = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getPersonInfos = async () => {
        let response = await axios.get('/api/personinfos/all/persons')
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
        console.log(data)
        errors.value = ''
        try {
            await axios.post('/api/attendees', data)
            await router.push({ name: 'activitydetails.attendees', params: { id: data.activity_id, ga_id: data.ga_id} })
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

    const updatePersonInfo = async (id, activity_id, ga_id) => {
        // console.log(personinfo);
        errors.value = ''
        try {
            await axios.patch(`/api/personinfos/${id}`, personinfo.value)
            await router.push({ name: 'activitydetails.attendees', params: { id: activity_id, ga_id: ga_id } })
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

    const destroyAttendee = async (id) => {
        console.log(id);
        try {
            await axios.delete(`/api/attendees/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
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
        personinfos,
        personinfo,
        attendees,
        provinces,
        municipalities,
        barangays,
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