import { ref } from "vue"
import axios from "../utils/axios"
import { useToast } from "primevue/usetoast";


export default function useAuth() {

    const user = ref(null);
    const can = ref({});
    const toast = useToast();

    const getUser = async () => {
        let response = await axios.get('/api/auth/user')
        user.value = response.data.data;
        console.log("user auth : ", response.data.data)
        return response.data.data;
    }   

    const canAccess = async (action, model) => {
        try {
            const response = await axios.get(`/api/auth/can-access?action=${action}&model=${model}`);
            can.value[`${action}_${model}`] = response.data;
            console.log("can access : ", response.data)
            return response.data;
        } catch (error) {
            console.log(error);
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: error.response.data.message,
                life: 3000
            })
        }
    }

    return {
        getUser,
        canAccess,
        can,
        user
    }
}