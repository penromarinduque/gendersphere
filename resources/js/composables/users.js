import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useUsers() {
    const user = ref([])
    const users = ref([])
    const personinfos = ref([])
    const personinfo = ref([])

    const errors = ref('')
    const router = useRouter()

    const toaster = createToaster({ 
        position: "top"
        // max:
     });

    const getUsers = async () => {
        let response = await axios.get('/api/users')
        users.value = response.data.data
    }

    const getUser = async (id) => {
        let response = await axios.get(`/api/users/${id}`)
        user.value = response.data.data
        // console.log(response.data);
    }

    const storeUser = async (data) => {
        console.log(data)
        errors.value = ''
        try {
            await axios.post('/api/users', data)
            await router.push({ name: 'users.index' })
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

    const updateUser = async (id) => {
        errors.value = ''
        try {
            await axios.patch(`/api/users/${id}`, user.value)
            await router.push({ name: 'users.index' })
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

    const destroyUser = async (id) => {
        try {
            await axios.delete(`/api/users/${id}`)
            toaster.info(`Deleted!`);
        } catch (e) {
            console.log(e);
        }
        
    }

    const getPersonInfos = async () => {
        let response = await axios.get('/api/personinfos/all/persons')
        personinfos.value = response.data.data
        console.log(personinfos.value);
    }

    const getPersonEmail = async (id) => {
        let response = await axios.get(`/api/personinfos/${id}`)
        // console.log(response)
        return response.data.data.email_add
    }

    const generatePassword = async () => {
        let pass = '';
        let str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' +
            'abcdefghijklmnopqrstuvwxyz0123456789@#$';

        for (let i = 1; i <= 8; i++) {
            let char = Math.floor(Math.random()
                * str.length + 1);

            pass += str.charAt(char)
        }

        return pass;
    }

    return {
        errors,
        user,
        users,
        personinfos,
        getUser,
        getUsers,
        storeUser,
        updateUser,
        destroyUser,
        generatePassword,
        getPersonInfos,
        getPersonEmail,
    }
}