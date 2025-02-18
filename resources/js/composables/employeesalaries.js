import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useEmployeeSalaries() {
    const employeesalary = ref([])
    const employeesalaries = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getEmployeeSalaries = async (person_info_id) => {
        let response = await axios.get('/api/employeesalaries', { params: { person_info_id:person_info_id } })
        console.log(response.data)
        employeesalaries.value = response.data
    }

    const getEmployeeSalary = async (id) => {
        let response = await axios.get(`/api/employeesalaries/${id}`)
        employeesalary.value = response.data.data
        // console.log(response.data);
    }

    const storeEmployeeSalary = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/employeesalaries', data)
            await router.push({ name: 'employeesalaries.index' })
            toaster.success(`Successfully Saved!`);
        } catch (e) {
            // console.log(e);
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
 
    }
 
    const updateEmployeeSalary = async (id, person_info_id) => {
        // console.log(personinfo);
        errors.value = ''
        try {
            await axios.patch(`/api/employeesalaries/${id}`, employeesalary.value)
            await router.push({ name: 'employeesalaries.index', params: {person_info_id:person_info_id} })
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

    const destroyEmployeeSalary = async (id) => {
        try {
            await axios.delete(`/api/employeesalaries/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
        }
        
    }

    return {
        errors,
        employeesalary,
        employeesalaries,
        getEmployeeSalaries,
        getEmployeeSalary,
        storeEmployeeSalary,
        updateEmployeeSalary,
        destroyEmployeeSalary
    }
}