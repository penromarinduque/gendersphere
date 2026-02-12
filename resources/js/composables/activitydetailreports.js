import { useToast } from "primevue";
import { ref } from "vue";


export default function useActivityDetailReports() {
    const activityDetailReports = ref([]);
    const toast = useToast();
    const errors = ref({});

    async function storeActivityDetailReport(params = {}) {
        try {
            const response = await axios.post('/api/activitydetailreports', params, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: response.data.message,
                life: 3000   
            });
            return true;
        } catch (error) {
            if(error.response.status === 422) {
                for (const key in error.response.data.errors) {
                    errors.value = error.response.data.errors
                }
            }
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: error.response.data.message,
                life: 3000
            });
            return false;
        }
    }

    async function deleteActivityDetailReport(id) {
        try {
            const response = await axios.delete(`/api/activitydetailreports/${id}`);
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: response.data.message,
                life: 3000
            });
            activityDetailReports.value = activityDetailReports.value.filter(report => report.id !== id);
            return true;
        } catch (error) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: error.response.data.message,
                life: 3000
            });
            return false
        }
    }

    async function getActivityDetailReports(params = {}) {
        try {
            const response = await axios.get('/api/activitydetailreports', { params });
            console.log(response.data)
            activityDetailReports.value = response.data.data;
        } catch (error) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: error.response.data.message,
                life: 3000
            });
            console.log(error);
        }
    }

    return {
        activityDetailReports,
        storeActivityDetailReport,
        deleteActivityDetailReport,
        getActivityDetailReports
    }
}