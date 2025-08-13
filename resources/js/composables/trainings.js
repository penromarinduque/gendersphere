import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useTrainings() {
    const training = ref([])
    const trainings = ref([])
    const loading = ref(false);
    const trainingTypeFilter = ref('all');
    const summary = ref({});

    const errors = ref('');
    const router = useRouter();

    const toaster = createToaster({ 
        position: "top"
        // max:
    });
 
    const getTrainings = async (page = 1, searchkey = "" ) => {
        let response = await axios.get('/api/trainings', { params: { page:page, searchkey:searchkey, training_type:trainingTypeFilter.value } })
        // console.log(response.data)
        trainings.value = response.data
    }

    const getTraining = async (id) => {
        let response = await axios.get(`/api/trainings/${id}`)
        console.log(response.data.data)
        training.value = response.data.data
        // console.log(response.data);
    }

    const storeTraining = async (data) => {
        loading.value = true;
        errors.value = ''
        try {
            await axios.post('/api/trainings', data)
            await router.push({ name: 'trainings.index' })
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

    const updateTraining = async (id) => {
        // console.log(training);
        loading.value = true;
        errors.value = ''
        try {
            await axios.patch(`/api/trainings/${id}`, training.value)
            await router.push({ name: 'trainings.index' })
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
    }
}