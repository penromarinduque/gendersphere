<template>
    <form class="space-y-6" @submit.prevent="editAttendee">
        <div class="space-y-4 rounded-md">
            <h3><b>Add New Attendee for: <span><u>{{ activity.gad_activity }}</u></span></b></h3>
            <hr>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div class="pb-1">
                    <label for="lastname" class="block text-md font-medium text-gray-700">Lastname</label>
                    <div class="mt-1">
                        <input type="text" name="lastname" id="lastname"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="personinfo.lastname">
                        <span class="text-sm text-red-600" v-if="errors?.lastname">{{ errors.lastname[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="firstname" class="block text-md font-medium text-gray-700">First Name</label>
                    <div class="mt-1">
                        <input type="text" name="firstname" id="firstname"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="personinfo.firstname">
                        <span class="text-sm text-red-600" v-if="errors?.firstname">{{ errors.firstname[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="middlename" class="block text-md font-medium text-gray-700">Middle Name</label>
                    <div class="mt-1">
                        <input type="text" name="middlename" id="middlename"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="personinfo.middlename">
                        <span class="text-sm text-red-600" v-if="errors?.middlename">{{ errors.middlename[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="extname" class="block text-md font-medium text-gray-700">Extension Name</label>
                    <div class="mt-1">
                        <input type="text" name="extname" id="extname"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="personinfo.extname">
                        <span class="text-sm text-red-600" v-if="errors?.extname">{{ errors.extname[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="gender" class="block text-md font-medium text-gray-700">Gender</label>
                    <div class="mt-1">
                        <select name="gender" id="gender" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="personinfo.gender">
                            <option value="">-Select Gender-</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.gender">{{ errors.gender[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="age" class="block text-md font-medium text-gray-700">Age</label>
                    <div class="mt-1">
                        <input type="number" name="age" id="age" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="personinfo.age">
                        <span class="text-sm text-red-600" v-if="errors?.age">{{ errors.age[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="contact_no" class="block text-md font-medium text-gray-700">Contact No.</label>
                    <input type="text" name="contact_no" id="contact_no" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="personinfo.contact_no">
                    <span class="text-sm text-red-600" v-if="errors?.contact_no">{{ errors.contact_no[0] }}</span>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="province_id" class="block text-md font-medium text-gray-700">ADDRESS: Province</label>
                    <div class="mt-1">
                        <select name="province_id" id="province_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="personinfo.province_id" @change="getMunicipals($event)">
                            <option value="">-Select Province-</option>
                            <option v-for="item in provinces" :key="item.id" :value="item.id">{{ item.province_name }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.province_id">{{ errors.province_id[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="municipality_id" class="block text-md font-medium text-gray-700">Municipality</label>
                    <div class="mt-1">
                        <select name="municipality_id" id="municipality_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="personinfo.municipality_id" @change="getMunicipalBrgys($event)">
                            <option value="">-Select Municipality-</option>
                            <option v-for="municipality in municipalities" :key="municipality.id" :value="municipality.id">{{ municipality.municipality_name }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.municipality_id">{{ errors.municipality_id[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="barangay_id" class="block text-md font-medium text-gray-700">Barangay</label>
                    <div class="mt-1">
                        <select name="barangay_id" id="barangay_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="personinfo.barangay_id">
                            <option value="">-Select Barangay-</option>
                            <option v-for="brgy in barangays" :key="brgy.id" :value="brgy.id">{{ brgy.barangay_name }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.barangay_id">{{ errors.barangay_id[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="organization" class="block text-md font-medium text-gray-700">Oragnization</label>
                    <input type="text" name="organization" id="organization" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="personinfo.organization">
                    <span class="text-sm text-red-600" v-if="errors?.organization">{{ errors.organization[0] }}</span>
                </div>
            </div>
        </div>
        <div class="float-right py-4">
            <input type="hidden" name="person_type" id="person_type" v-model="personinfo.person_type" >
            <button type="button" class="inline-flex items-center px-4 py-2 mr-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                <router-link :to="{ name: 'activities.attendees', params: props.id }" class="text-sm font-medium">Cancel</router-link>
            </button>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md ring-indigo-300 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring disabled:opacity-25">
                SAVE CHANGES
            </button>
        </div>
        
    </form>
</template>

<script setup>
import useActivities from '../../composables/activities'
import { reactive, onMounted, watch } from 'vue'
 
// const form = reactive({
//     lastname: '',
//     firstname: '',
//     middlename: '',
//     extname: '',
//     gender: '',
//     age: '',
//     province_id: '',
//     municipality_id: '',
//     barangay_id: '',
//     contact_no: '',
// })
 
const { errors, activity, personinfo, provinces, municipalities, barangays, getActivity, getPersonInfo, updatePersonInfo, getProvinces, getMunicipalities, getBarangays } = useActivities()

const props = defineProps({
    id: {
        required: true,
        type: String
    },
    person_info_id: {
        required: true,
        type: String
    }
})

// console.log(props.person_info_id)
onMounted(() => getActivity(props.id))
onMounted(() => getPersonInfo(props.person_info_id))
onMounted(getProvinces)
watch(personinfo, () => {
    console.log(personinfo.value.municipality_id)
    getMunicipalities(personinfo.value.province_id);
    getBarangays(personinfo.value.municipality_id);
})

const editAttendee = async () => {
    await updatePersonInfo(props.person_info_id, props.id)
}

const getMunicipals = async (event) => {
    let prov_id = event.target.value;
    // console.log(prov_id); 
    if (prov_id!=="") {
        await getMunicipalities(prov_id)
    }  
}

const getMunicipalBrgys = async (event) => {
    let mun_id = event.target.value;
    // console.log(mun_id);   
    if (mun_id!=="") {
        await getBarangays(mun_id)
    }
}
</script>