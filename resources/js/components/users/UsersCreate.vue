<template>
    <form class="space-y-6" @submit.prevent="saveUser">
        <div class="space-y-4 rounded-md">
            <h3><b>Add New</b></h3>
            <hr>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="person_info_id" class="block text-md font-medium text-gray-700">Personnel (Employee)</label>
                    <div class="mt-1">
                        <select name="person_info_id" id="person_info_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.person_info_id" @change="getPerson($event)">
                            <option value="">-Select Personnel-</option>
                            <option v-for="item in personinfos" :key="item.id" :value="item.id">{{ item.lastname+', '+item.firstname+' '+item.middlename+' ' + (item.extname ?? '') }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.person_info_id">{{ errors.person_info_id[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="email" class="block text-md font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input type="text" name="email" id="email"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.email">
                        <span class="text-sm text-red-600" v-if="errors?.email">{{ errors.email[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">                    
                    <div class="flex items-center float-right">
                        <input id="gen_passw" type="checkbox" @click="generatePass('gen_passw');" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="gen_passw" class="ms-1 mr-2 text-sm font-medium text-gray-900 dark:text-gray-300">Generate</label>

                        <input id="show_passw" type="checkbox" @click="showPass('show_passw', 'password');" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="show_passw" class="ms-1 text-sm font-medium text-gray-900 dark:text-gray-300">Show</label>
                    </div>
                    <label for="password" class="block text-md font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input type="password" name="password" id="password"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.password">
                        <span class="text-sm text-red-600" v-if="errors?.password">{{ errors.password[0] }}</span>
                    </div>
                    
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="usertype" class="block text-md font-medium text-gray-700">Role</label>
                    <div class="mt-1">
                        <select name="usertype" id="usertype" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.usertype">
                            <option value="">-Select Role-</option>
                            <option value="2">Encoder</option>
                            <option value="3">Viewer</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.usertype">{{ errors.usertype[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="float-right py-4">
                <button type="button" class="inline-flex items-center px-4 py-2 mr-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                    <router-link :to="{ name: 'users.index' }" class="text-sm font-medium">Cancel</router-link>
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md ring-indigo-300 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring disabled:opacity-25">
                    Save
                </button>
            </div>
        </div>
    </form>
</template>
 
<script setup>
import useUsers from '../../composables/users'
import { reactive, onMounted } from 'vue'
 
const form = reactive({
    person_info_id: '',
    email: '',
    password: '',
    usertype: ''
})
 
const { errors, personinfos, storeUser, generatePassword, getPersonInfos, getPersonEmail } = useUsers()
 
const saveUser = async () => {
    await storeUser({ ...form })
}

const getPerson = async (event) => {
    let person_id = event.target.value;
    let email_add = await getPersonEmail(person_id)
    // console.log(email_add)
    form.email = email_add
}

const generatePass = async (chkbox_fld) => {
    let pw = await generatePassword()
    let chkbox = document.getElementById(chkbox_fld);
    if (chkbox.checked == true) {
        form.password = pw;
    } else {
        form.password="";
    }
}

onMounted(getPersonInfos)

const showPass = async (chkbox_fld, passw_fld) => {
    let chkbox = document.getElementById(chkbox_fld);
    if (chkbox.checked == true) {
        document.getElementById(passw_fld).type="text";
    } else{
        document.getElementById(passw_fld).type="password";
    }
}
</script>