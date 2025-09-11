import { ref } from 'vue'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useTrainings() {
    const training = ref([])
    const trainings = ref([])
    const loading = ref(false);
    const trainingTypeFilter = ref('');
    const summary = ref({});
    const trainingTypes = ref([]);
    const errors = ref('');
    const router = useRouter();
    const yearOptions = ref([]);
    const trainingTitleOptions = ref([]);
    const employeeOptions = ref([]);
    const suggestions = ref([]);
    const trainingNatureOptions = ref([
    { label: 'Attended', value: 'attended' },
    { label: 'Conducted', value: 'conducted' }
    ]);
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
        try {
            const response = await axios.get(`/api/trainings/instance/${id}`);


            const data = response.data.data || response.data.training || response.data;

            if (!data) {
                console.warn('[getTraining] No usable data found in response');
                return null;
            }

            // Merge `training_instance` if present
            const merged = {
                ...data,
                ...(data.training_instance || {})
            };

            training.value = merged;
            return merged;

        } catch (error) {
            console.error('[getTraining] Error:', error);
            training.value = null;
            return null;
        }
    };

    const storeTraining = async (data) => {
    loading.value = true
    errors.value = ''

    try {
        await axios.post('/api/trainings', data, {
            headers: {
                'Content-Type': 'application/json'
    }
        })
        await router.push({ name: 'trainings.index' })
        toaster.success(`Saved!`)
    } catch (e) {
        if (e.response?.status === 422) {
        errors.value = e.response.data.errors
        }
        throw e
    } finally {
        loading.value = false
    }
    }

    const updateTraining = async (id, payload) => {
        loading.value = true
        errors.value = {}

        try {
            await axios.post(`/api/trainings/${id}/update`, payload)
            await router.push({ name: 'trainings.index' })
            toaster.success(`Updated!`)
            // or POST if using POST route
        } catch (error) {
            if (error.response?.status === 422) {
                errors.value = error.response.data.errors
            }
        } finally {
            loading.value = false
        }
    }


    const destroyTraining = async (id) => {
        loading.value = true;
        try {
            await axios.delete(`/api/traininginstances/${id}`)
            toaster.info(`Deleted!`);
            loading.value = false;
      } catch (error) {
            if (error.response?.status === 422) {
                errors.value = error.response.data.errors
            }
        } finally {
            loading.value = false
        }   
    }

    const getTrainingSummary = async () => {
        let response = await axios.get('/api/trainings/summary');
        summary.value = response.data
    }
    
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
        return formatted
    }

    const loadTrainingTypeOptions = async () => {
        try {
            const res = await axios.get('/api/trainings/trainingtypes');
            trainingTypes.value = res.data;
        } catch (err) {
            console.error("Failed to load training types", err);
        }
    };

    return {
        errors,
        training,
        trainings,
        trainingTypes,
        trainingTypeFilter,
        loading,
        summary,
        trainingNatureOptions,
        trainingTypes,
        trainingTitleOptions,
        yearOptions,
        employeeOptions,
        toaster,
        suggestions,
        getTrainings,
        getTraining,
        storeTraining,
        updateTraining,
        destroyTraining,
        getTrainingSummary,
        calculateHours,
        msToHours,
        formatDateToYYYYMMDD,
        loadTrainingTypeOptions,
    }
}