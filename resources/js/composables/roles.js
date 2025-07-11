
import { ref } from "vue";
import axios from '../utils/axios'
import {useToast} from 'primevue/usetoast';

export default function useRoles() {
    const toast = useToast();
    const errors = ref('');
    
    const addRole = async (data) => {
        try {
            await axios.post('/api/roles', data);
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Role successfully saved',
                life: 3000
            })
            return true;
        } catch (e) {
            console.log(e);
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            });
            if(e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
        return false;
    }

    const deleteRole = async (id) => {
        try {
            await axios.delete(`/api/roles/${id}`)
            toast.add({
                severity: 'success',
                summary: 'Success',
                detail: 'Role successfully deleted',
                life: 3000
            });
            return true;
        } catch (e) {
            console.log(e);
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: e.response.data.message,
                life: 3000
            })
        }
        return false;
    }

    return {
        addRole,
        errors,
        deleteRole
    }
}