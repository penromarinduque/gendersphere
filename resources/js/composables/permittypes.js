import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function usePermitTypes() {
    const permittype = ref([])
    const permittypes = ref([])
    const permittypesbystatus = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getPermitTypes = async () => {
        let response = await axios.get('/api/permittypes')
        permittypes.value = response.data.data
    }
 
    const getPermitType = async (id) => {
        let response = await axios.get(`/api/permittypes/${id}`)
        permittype.value = response.data.data
        // console.log(response.data);
    }

    const storePermitType = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/permittypes', data)
            await router.push({ name: 'permittypes.index' })
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
 
    const updatePermitType = async (id) => {
        // console.log(permittype);
        errors.value = ''
        try {
            await axios.patch(`/api/permittypes/${id}`, permittype.value)
            await router.push({ name: 'permittypes.index' })
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

    const destroyPermitType = async (id) => {
        try {
            await axios.delete(`/api/permittypes/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
        }
    }

    const getPermitTypesByStatus = async (status) => {
        let response = await axios.get(`/api/permittypebystatus/${status}`)
        // console.log(response.data)
        permittypesbystatus.value = response.data.data
    }

    return {
        errors,
        permittype,
        permittypes,
        permittypesbystatus,
        getPermitType,
        getPermitTypes,
        storePermitType,
        updatePermitType,
        destroyPermitType,
        getPermitTypesByStatus
    }
}