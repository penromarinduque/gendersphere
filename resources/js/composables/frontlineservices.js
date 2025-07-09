import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

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

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getYearlist = async () => {
        let response = await axios.get('/api/yearlist');
        yearlist.value = response.data
    }
    

    const getFrontlineServices = async (page=1) => {
        let response = await axios.get(`/api/frontlineservices`, {
            params: {
                year: selectedYear.value,
                permit_type: selectedPermitType.value,
                page : page
            }
        })
        frontlineservices.value = response.data
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
            toaster.success(`Successfully Saved!`);
            loading.value = false;
        } catch (e) {
            console.log(e);
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
            toaster.success(`Successfully Updated!`);
            loading.value = false;
        } catch (e) {
            console.log(e);
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
            toaster.info(`Deleted!`);
            loading.value = false;
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
            loading.value = false;
        }
    }

    const getFrontlineServiceSummary = async () => {
        console.log("test");
        const response = await axios.get(`/api/frontlineservices/summary` , { params: { year: selectedYear.value} });
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