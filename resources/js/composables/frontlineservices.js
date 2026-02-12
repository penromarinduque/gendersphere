import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'
import { useToast } from 'primevue/usetoast'

export default function useFrontlineServices() {
    const frontlineservice = ref([])
    const frontlineservices = ref([])
    const loading = ref(false)

    const errors = ref('')
    const router = useRouter();
    const yearlist = ref([]);
    const selectedYear = ref(new Date().getFullYear());
    const selectedService = ref();
    const selectedPermitType = ref();
    const frontlineServiceSummary = ref();
    const toast = useToast();
    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getYearlist = async () => {
        let response = await axios.get('/api/yearlist');
        yearlist.value = response.data
    }
    

    const getFrontlineServices = async (page=1, query = {}) => {
        try {
            
            let response = await axios.get(`/api/frontlineservices`, {
                params: {
                    year: selectedYear.value,
                    permit_type: selectedPermitType.value,
                    page : page,
                    ...query
                }
            })
            frontlineservices.value = response.data
            console.log(' frontlineservices' , frontlineservices.value);
            return response.data
        } catch (error) {
            consol.log(error);
        }
    }
 
    const getFrontlineService = async (id) => {
        let response = await axios.get(`/api/frontlineservices/${id}`)
        // console.log(response);
        frontlineservice.value = response.data.data
        // console.log(response.data);
    }

    const storeFrontlineService = async (data) => {
        errors.value = ''
        loading.value = true;
        try {
            await axios.post('/api/frontlineservices', data)
            await router.push({ name: 'frontlineservices.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Frontline Service successfully saved',
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
 
    const updateFrontlineService = async (id) => {
        loading.value = true;
        console.log(frontlineservice);
        errors.value = ''
        try {
            await axios.patch(`/api/frontlineservices/${id}`, frontlineservice.value)
            await router.push({ name: 'frontlineservices.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Frontline Service successfully updated',
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

    const destroyFrontlineService = async (id) => {
        loading.value = true;
        try {
            await axios.delete(`/api/frontlineservices/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Frontline Service successfully deleted',
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

    const getFrontlineServiceSummary = async ($query) => {
        console.log("test");
        const response = await axios.get(`/api/frontlineservices/summary` , { params: { year: selectedYear.value, ...$query} });
        frontlineServiceSummary.value = response.data;
        console.log(response.data);
    }

    return {
        errors,
        frontlineservice,
        frontlineservices,
        loading,
        yearlist,
        selectedYear,
        selectedService,
        selectedPermitType,
        frontlineServiceSummary,
        getFrontlineService,
        getFrontlineServices,
        storeFrontlineService,
        updateFrontlineService,
        destroyFrontlineService,
        getYearlist,
        getFrontlineServiceSummary
    }
}