<template>
    <form class="space-y-6" @submit.prevent="saveAdmin">
        <div class="space-y-4 rounded-md">
            <h3><b>Create Admin User</b></h3>
            <hr>
            <h3><b>Personal Information</b></h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="name" class="block text-md font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                    <InputText v-model="form.first_name" type="text" name="first_name" id="first_name" size="small" class="w-full" placeholder="First Name"></InputText>  
                    <span class="text-sm text-red-600" v-if="errors?.first_name">{{ errors.first_name[0] }}</span>
                </div>
                <div class="pb-1">
                    <label for="name" class="block text-md font-medium text-gray-700">Middle Name <span class="text-red-500">*</span></label>
                    <InputText v-model="form.middle_name" type="text" name="middle_name" id="middle_name" size="small" class="w-full" placeholder="Middle Name"></InputText>  
                    <span class="text-sm text-red-600" v-if="errors?.middle_name">{{ errors.middle_name[0] }}</span>
                </div>
                <div class="pb-1">
                    <label for="name" class="block text-md font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
                    <InputText v-model="form.last_name" type="text" name="last_name" id="last_name" size="small" class="w-full" placeholder="Last Name"></InputText>  
                    <span class="text-sm text-red-600" v-if="errors?.last_name">{{ errors.last_name[0] }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="name" class="block text-md font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                    <Select v-model="form.gender" :options="[{label: 'Male', value: 'male'}, {label: 'Female', value: 'female'}, {label: 'LGBTQIA+', value: 'lgbtqia+'}]" name="gender" id="gender" size="small" class="w-full" optionLabel="label" optionValue="value" placeholder="Gender"></Select>
                    <span class="text-sm text-red-600" v-if="errors?.gender">{{ errors.gender[0] }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="office_id" class="block text-md font-medium text-gray-700">Office <span class="text-red-500">*</span></label>
                    <Select v-model="form.office_id" :options="offices" name="gender" id="office_id" class="w-full" size="small" optionLabel="office_name" optionValue="id" placeholder="Office" filter></Select>
                    <span class="text-sm text-red-600" v-if="errors?.office_id">{{ errors.office_id[0] }}</span>
                </div>
                <div class="pb-1">
                    <label for="email" class="block text-md font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                    <InputText name="email" id="email" v-model="form.email" class="w-full" size="small" placeholder="Email"></InputText>
                    <span class="text-sm text-red-600" v-if="errors?.email">{{ errors.email[0] }}</span>
                </div>
                <div class="pb-1">                    
                    <div class="flex items-center float-right">
                        <!-- <input id="gen_passw" type="checkbox" @click="generatePass('gen_passw');" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"> -->
                        <Checkbox size="small" inputId="gen_passw" @click="generatePass('gen_passw');" binary />
                        <label for="gen_passw" class="ms-1 mr-2 text-sm font-medium text-gray-900 dark:text-gray-300">Generate</label>
                    </div>
                    <label for="password" class="block text-md font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                    <Password id="password" placeholder="Password"  v-model="form.password" toggleMask class="w-full" inputStyle="width: 100%;" size="small" />
                    <span class="text-sm text-red-600" v-if="errors?.password">{{ errors.password[0] }}</span>
                </div>
            </div>  
            <div class="flex float-right py-4 gap-2">
                <Button asChild v-slot="props"  severity="secondary">
                    <router-link :to="{ name: 'users.index' }" :class="props.class">Cancel</router-link>
                </Button>
                <Button type="submit" label="Save Admin" :loading="loading" size="small">
                </Button>
            </div>
        </div>
    </form>
</template>
 
<script setup>
    import useUsers from '../../composables/users';
    import useOffices from '../../composables/offices';
    import { reactive, onMounted, ref } from 'vue';
    import Button from "primevue/button";
    import InputText from 'primevue/inputtext';
    import Select from 'primevue/select';
    import Password from 'primevue/password';
    import Checkbox from 'primevue/checkbox';
    
    const form = reactive({
        first_name: '',
        middle_name: '',
        last_name: '',
        gender : '',
        email: '',
        password: '',
        office_id: ''
    })
    
    const { errors, personinfos, storeUser, generatePassword, getPersonInfos, getPersonEmail, storeAdmin } = useUsers();
    const { offices, getAllOffices } = useOffices();
    const loading = ref(false)

    const saveAdmin = async () => {
        loading.value = true;
        await storeAdmin({ ...form })
        loading.value = false;
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

    onMounted(async () => {
        getPersonInfos()
        getAllOffices()
    });

    const showPass = async (chkbox_fld, passw_fld) => {
        let chkbox = document.getElementById(chkbox_fld);
        if (chkbox.checked == true) {
            document.getElementById(passw_fld).type="text";
        } else{
            document.getElementById(passw_fld).type="password";
        }
    }
</script>