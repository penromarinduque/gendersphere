import { ref } from "vue"
import axios from "../utils/axios"


export default function useAuth() {

    const user = ref(null);

    const getUser = async () => {
        let response = await axios.get('/api/auth/user')
        return response.data.data
    }   

    return {
        getUser
    }
}