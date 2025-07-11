import { ref } from "vue"
import axios from "../utils/axios"


export default function useAuth() {

    const user = ref(null);

    const getUser = async () => {
        let response = await axios.get('/api/auth/user')
        user.value = response.data.data;
        console.log("user auth : ", response.data.data)
        return response.data.data;
    }   

    return {
        getUser,
        user
    }
}