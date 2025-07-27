import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'
import { useToast } from 'primevue/usetoast'
 
export default function usePersonInfos() {
    const personinfo = ref([])
    const personinfos = ref([])
    const provinces = ref([])
    const municipalities = ref([])
    const barangays = ref([])
    const loading = ref(false);
    const genderFilter = ref('');
    const employmentStatusFilter = ref('');
    const summary = ref({});
    const employees = ref([]);
    const personInfoChartData = ref({});

    const errors = ref('');
    const router = useRouter();
    const toast = useToast();
    const toaster = createToaster({ 
        position: "top"
        // max:
    });
 
    const getPersonInfos = async (page = 1, searchkey = "", otherParams = {}) => {

        let response = await axios.get('/api/personinfos', {
            params: { 
                ...otherParams,
                page:page, 
                searchkey:searchkey, 
                gender:genderFilter.value, 
                employment_status:employmentStatusFilter.value 
            } 
        });
        // console.log(response.data)
        personinfos.value = response.data
    }
 
    const getPersonInfo = async (id) => {
        let response = await axios.get(`/api/personinfos/${id}`)
        console.log(response.data.data)
        personinfo.value = response.data.data
        // console.log(response.data);
    }
 
    const storePersonInfo = async (data) => {
        loading.value = true;
        errors.value = ''
        try {
            await axios.post('/api/personinfos', data)
            await router.push({ name: 'personinfos.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Person successfully saved',
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
 
    const updatePersonInfo = async (id) => {
        // console.log(personinfo);
        loading.value = true;
        errors.value = ''
        try {
            await axios.patch(`/api/personinfos/${id}`, personinfo.value)
            await router.push({ name: 'personinfos.index' })
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Person successfully updated',
                life: 3000
            })
            loading.value = false;
        } catch (e) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            })
            console.log(e);
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
            loading.value = false;
        }
    }

    const destroyPersonInfo = async (id) => {
        loading.value = true;
        try {
            await axios.delete(`/api/personinfos/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Person successfully deleted',
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
        console.log(response.data.data);
        barangays.value = response.data.data
        // console.log(response.data);
    }

    const getPersonInfoSummary = async ($query) => {
        let response = await axios.get('/api/personinfos/summary', {
            params: $query
        });
        summary.value = response.data
    }
    
    const getEmployees  = async (employmentType = null) => {
        let response = await axios.get('/api/personinfos/get-employees', {
            params: {
                employment_type: employmentType
            }
        });
        employees.value = response.data
    }

    const getPersonInfoChartData = async () => {
        let response = await axios.get('/api/personinfos/get-chart-data');
        personInfoChartData.value = response.data
        console.log(response.data);
    }

    const computeAge = (date, year = null) => {
        var today = year ? new Date('12-31-' + year) :  new Date();
        var birthDate = new Date(date);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    const setEmpStatusSeverityColor = (status) => {
        if (status == 'new') {
            return 'success';
        } else if (status == 'renewed') {
            return 'primary';
        } else if (status == 'retired' || status == 'resigned') {
            return 'secondary';
        } else if (status == 'terminated') {
            return 'danger';
        }
    }

    const setEmpTypeSeverityColor = (type) => {
        if (type == 'permanent') {
            return 'primary';
        } else if (type == 'cos') {
            return 'warn';
        }
    }

    return {
        errors,
        personinfo,
        personinfos,
        provinces,
        municipalities,
        barangays,
        loading,
        genderFilter,
        employmentStatusFilter,
        summary,
        employees,
        personInfoChartData,
        getPersonInfoChartData,
        getEmployees,
        getPersonInfo,
        getPersonInfos,
        storePersonInfo,
        updatePersonInfo,
        destroyPersonInfo,
        getProvinces,
        getMunicipalities,
        getBarangays,
        getPersonInfoSummary,
        computeAge,
        setEmpStatusSeverityColor,
        setEmpTypeSeverityColor
    }
}