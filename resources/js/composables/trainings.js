import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useTrainings() {
    const training = ref([])
    const trainings = ref([])
    const loading = ref(false);
    const trainingTypeFilter = ref('');
    const summary = ref({});

    const errors = ref('');
    const router = useRouter();

    const toaster = createToaster({ 
        position: "top"
        // max:
    });
 
    const getTrainings = async (page = 1, search = null, filters = {}) => {
    try {
        const response = await axios.get('/api/trainings', {
        params: {
            page,
            search,
            ...filters // 👈 This spreads your filters into query params
        }
        });

        trainings.value = response.data;
    } catch (error) {
        console.error('Failed to fetch trainings:', error);
    }
    };

 const getTraining = async (id) => {
    let response = await axios.get(`/api/trainings/${id}`);
    const data = response.data.data;

    // Force is_gad_related to be a real boolean
    data.is_gad_related = Boolean(data.is_gad_related);

    console.log(data);
    training.value = data;
}

  const storeTraining = async (data) => {
    loading.value = true
    errors.value = ''

    try {
        const payload = {
            ...data,
            is_gad_related: data.is_gad_related ? 1 : 0  //Ensure it's 1 or 0
        }

        await axios.post('/api/trainings', payload)
        await router.push({ name: 'trainings.index' })
        toaster.success(`Successfully Saved!`)
    } catch (e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors
        }
        throw e; 
    } finally {
        loading.value = false
    }
}

const updateTraining = async (id) => {
    loading.value = true
    errors.value = ''

    try {
        const payload = {
            ...training.value,
            is_gad_related: training.value.is_gad_related ? 1 : 0 // Ensure it's 1 or 0
        }

        await axios.patch(`/api/trainings/${id}`, payload)
        await router.push({ name: 'trainings.index' })
        toaster.success(`Successfully Updated!`)
    } catch (e) {
        console.log(e)
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors
        }
    } finally {
        loading.value = false
    }
}

    const destroyTraining = async (id) => {
        loading.value = true;
        try {
            await axios.delete(`/api/trainings/${id}`)
            toaster.info(`Deleted!`);
            loading.value = false;
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
            loading.value = false;
        }
        
    }

    const getTrainingSummary = async () => {
        let response = await axios.get('/api/trainings/summary');
        summary.value = response.data
    }
    
/*     const getEmployees  = async (employmentType = null) => {
        let response = await axios.get('/api/personinfos/get-employees', {
            params: {
                employment_type: employmentType
            }
        });
        employees.value = response.data
    }
 */
    function msToHours(ms) {
        return ms / (1000 * 60 * 60);
    }

    function calculateHours(hours) {
        hours = hours === 0 ? 8 : hours;
        if(hours >= 24){
            hours = ((hours/24)+1)*8
        }
        return hours
    }

    function formatDateToYYYYMMDD(date) {
        const d = new Date(date)
        const formatted = d.toISOString().split('T')[0];
        console.log('Formatted:', formatted);       // "2025-08-18"
        console.log('Type:', typeof d);       // "object"
        console.log('Still a Date?', d instanceof Date); 
        return formatted
    }

    return {
        errors,
        training,
        trainings,
        trainingTypeFilter,
        loading,
        summary,
//      employees,
        getTrainings,
        getTraining,
        storeTraining,
        updateTraining,
        destroyTraining,
        getTrainingSummary,
        calculateHours,
        msToHours,
        formatDateToYYYYMMDD,
    }
}