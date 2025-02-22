import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'
 
export default function usePersonInfos() {
    const personinfo = ref([])
    const personinfos = ref([])
    const provinces = ref([])
    const municipalities = ref([])
    const barangays = ref([])
    const loading = ref(false)
 
    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
     });
 
    const getPersonInfos = async (page = 1, searchkey = "") => {
        let response = await axios.get('/api/personinfos', { params: { page:page, searchkey:searchkey } })
        // console.log(response.data)
        personinfos.value = response.data
    }
 
    const getPersonInfo = async (id) => {
        let response = await axios.get(`/api/personinfos/${id}`)
        personinfo.value = response.data.data
        // console.log(response.data);
    }
 
    const storePersonInfo = async (data) => {
        loading.value = true;
        errors.value = ''
        try {
            await axios.post('/api/personinfos', data)
            await router.push({ name: 'personinfos.index' })
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
 
    const updatePersonInfo = async (id) => {
        // console.log(personinfo);
        loading.value = true;
        errors.value = ''
        try {
            await axios.patch(`/api/personinfos/${id}`, personinfo.value)
            await router.push({ name: 'personinfos.index' })
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

    const destroyPersonInfo = async (id) => {
        loading.value = true;
        try {
            await axios.delete(`/api/personinfos/${id}`)
            toaster.info(`Deleted!`);
            loading.value = false;
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
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
        barangays.value = response.data.data
        // console.log(response.data);
    }
 
    return {
        errors,
        personinfo,
        personinfos,
        provinces,
        municipalities,
        barangays,
        loading,
        getPersonInfo,
        getPersonInfos,
        storePersonInfo,
        updatePersonInfo,
        destroyPersonInfo,
        getProvinces,
        getMunicipalities,
        getBarangays
    }
}