<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div class="mb-5">
            <h2 class="text-lg"><b>Add New Attendee for: </b>
                <span v-if="activitydetail.sub_activity===null">Main Activity - <u>{{ activitydetail.main_activity }}</u></span>
                <span v-if="activitydetail.sub_activity!==null"><u><span v-html="activitydetail.sub_activity"></span></u></span>
                <p v-if="activitydetail.sub_activity===null">Targets:
                    <u><span v-if="activitydetail.sub_activity===null" v-html="activitydetail.targets"></span></u>
                </p>
            </h2>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center h-8 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'activitydetails.attendees', params: { id: props.id, ga_id: props.ga_id} }" class="text-sm font-medium">Back to Attendees List</router-link>
            </button>
        </div>
    </div>
    <div class="py-4 px-4 mb-5 border border-blue-600 rounded-md shadow-md">
        <form class="space-y-6" @submit.prevent="saveAttendeePersonnel">
            <div class="space-y-4">
                <h2 class="leading-6"><b>USE THIS FOR IF THE ATTENDEE IS PENRO EMPLOYEE</b></h2>
                <hr>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
                <div class="pb-1">
                    <label for="person_info_id" class="block text-md font-medium text-gray-700">PENRO EMPLOYEE</label>
                    <div class="mt-1">
                        <select name="person_info_id" id="person_info_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="text-transform: capitalize;" v-model="formp.person_info_id">
                            <option value="">-Select Employee-</option>
                            <option v-for="item in personinfos" :key="item.id" :value="item.id">{{ item.lastname+', '+item.firstname+' '+item.middlename+' ' }}<span v-if="item.extname!==null">{{ item.extname }}</span></option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.person_info_id">{{ errors.person_info_id[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 pt-8">
                    <input type="hidden" name="person_type" id="person_type" v-model="formp.person_type" >
                    <input type="hidden" name="activity_id" id="activity_id" v-model="formp.activity_id" >
                    <button type="submit" class="inline-flex items-center px-4 py-2 ml-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-800 border border-transparent rounded-md ring-blue-300 hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring disabled:opacity-25">
                    SAVE
                </button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="py-4 px-4 border border-indigo-600 rounded-md shadow-md">
        <form class="space-y-6" @submit.prevent="saveAttendee">
            <div class="space-y-4 mb-2">
                <h2 class="leading-6"><b>Use this form if the Attendee is not from PENRO Office</b></h2>
                <hr>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    <div class="pb-1">
                        <label for="lastname" class="block text-md font-medium text-gray-700">Lastname <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="lastname" id="lastname" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.lastname">
                            <span class="text-sm text-red-600" v-if="errors?.lastname">{{ errors.lastname[0] }}</span>
                        </div>
                    </div>
                    <div class="pb-1">
                        <label for="firstname" class="block text-md font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="firstname" id="firstname" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.firstname">
                            <span class="text-sm text-red-600" v-if="errors?.firstname">{{ errors.firstname[0] }}</span>
                        </div>
                    </div>
                    <div class="pb-1">
                        <label for="middlename" class="block text-md font-medium text-gray-700">Middle Name <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="text" name="middlename" id="middlename" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.middlename">
                            <span class="text-sm text-red-600" v-if="errors?.middlename">{{ errors.middlename[0] }}</span>
                        </div>
                    </div>
                    <div class="pb-1">
                        <label for="extname" class="block text-md font-medium text-gray-700">Extension Name</label>
                        <div class="mt-1">
                            <input type="text" name="extname" id="extname" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.extname">
                            <span class="text-sm text-red-600" v-if="errors?.extname">{{ errors.extname[0] }}</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                    <div class="pb-1">
                        <label for="gender" class="block text-md font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select name="gender" id="gender" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.gender">
                                <option value="">-Select Gender-</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="lgbtqia+">LGBTQIA+</option>
                            </select>
                            <span class="text-sm text-red-600" v-if="errors?.gender">{{ errors.gender[0] }}</span>
                        </div>
                    </div>
                    <div class="pb-1">
                        <label for="age" class="block text-md font-medium text-gray-700">Age <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <input type="number" name="age" id="age" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.age">
                            <span class="text-sm text-red-600" v-if="errors?.age">{{ errors.age[0] }}</span>
                        </div>
                    </div>
                    <div class="pb-1">
                        <label for="contact_no" class="block text-md font-medium text-gray-700">Contact No.</label>
                        <input type="text" name="contact_no" id="contact_no" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.contact_no">
                        <span class="text-sm text-red-600" v-if="errors?.contact_no">{{ errors.contact_no[0] }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                    <div class="pb-1">
                        <label for="province_id" class="block text-md font-medium text-gray-700">ADDRESS: Province <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select name="province_id" id="province_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.province_id" @change="getMunicipals($event)">
                                <option value="">-Select Province-</option>
                                <option v-for="item in provinces" :key="item.id" :value="item.id">{{ item.province_name }}</option>
                            </select>
                            <span class="text-sm text-red-600" v-if="errors?.province_id">{{ errors.province_id[0] }}</span>
                        </div>
                    </div>
                    <div class="pb-1">
                        <label for="municipality_id" class="block text-md font-medium text-gray-700">Municipality <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select name="municipality_id" id="municipality_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.municipality_id" @change="getMunicipalBrgys($event)">
                                <option value="">-Select Municipality-</option>
                                <option v-for="municipality in municipalities" :key="municipality.id" :value="municipality.id">{{ municipality.municipality_name }}</option>
                            </select>
                            <span class="text-sm text-red-600" v-if="errors?.municipality_id">{{ errors.municipality_id[0] }}</span>
                        </div>
                    </div>
                    <div class="pb-1">
                        <label for="barangay_id" class="block text-md font-medium text-gray-700">Barangay <span class="text-red-500">*</span></label>
                        <div class="mt-1">
                            <select name="barangay_id" id="barangay_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.barangay_id">
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
                        <input type="text" name="organization" id="organization" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.organization">
                        <span class="text-sm text-red-600" v-if="errors?.organization">{{ errors.organization[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="flex py-4 place-content-end">
                <input type="hidden" name="person_type" id="person_type" v-model="form.person_type" >
                <input type="hidden" name="activity_id" id="activity_id" v-model="form.activity_id" >
                <button type="button" class="inline-flex items-center px-4 py-2 mr-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                    <router-link :to="{ name: 'activitydetails.attendees', params: {id: activitydetail.id, ga_id: props.ga_id } }" class="text-sm font-medium">Cancel</router-link>
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md ring-indigo-300 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring disabled:opacity-25">
                    SAVE
                </button>
            </div>
        </form>
    </div>
    
</template>

<script setup>
import useActivities from '../../composables/activities'
import useActivityDetails from '../../composables/activitydetails'
import useAttendees from '../../composables/attendees';
import { reactive, onMounted } from 'vue'

const { errors, personinfos, provinces, municipalities, barangays, getPersonInfos, getProvinces, getMunicipalities, getBarangays, storeAttendee } = useAttendees()
const { activitydetail, getActivityDetail } = useActivityDetails()

const props = defineProps({
    id: {
        required: true,
        type: String
    },
    ga_id: {
        required: true,
        type: String
    }
})

const formp = reactive({
    person_info_id: '',
    person_type: 1,
    activity_id: props.id,
    ga_id: props.ga_id
})
 
const form = reactive({
    lastname: '',
    firstname: '',
    middlename: '',
    extname: '',
    gender: '',
    age: '',
    province_id: '',
    municipality_id: '',
    barangay_id: '',
    contact_no: '',
    organization: '',
    person_type: 2,
    activity_id: props.id,
    ga_id: props.ga_id
})

console.log(props.id)
// onMounted(() => getActivity(props.id))
onMounted(() => getActivityDetail(props.id))
onMounted(getProvinces)
onMounted(getPersonInfos)

const saveAttendeePersonnel = async () => {
    await storeAttendee({ ...formp })
}

const saveAttendee = async () => {
    await storeAttendee({ ...form })
}

const getMunicipals = async (event) => {
    let prov_id = event.target.value;
    console.log(prov_id); 
    if (prov_id!=="") {
        await getMunicipalities(prov_id)
    }  
}

const getMunicipalBrgys = async (event) => {
    let mun_id = event.target.value;
    console.log(mun_id);   
    if (mun_id!=="") {
        await getBarangays(mun_id)
    }
}
</script>