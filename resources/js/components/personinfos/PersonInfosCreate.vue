<template>
    <form class="space-y-6" @submit.prevent="savePersonInfo">
        <div class="space-y-4 rounded-md">
            <h3><b>Add New</b></h3>
            <hr>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div class="pb-1">
                    <label for="lastname" class="block text-md font-medium text-gray-700">Lastname <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="lastname" id="lastname"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.lastname">
                        <span class="text-sm text-red-600" v-if="errors?.lastname">{{ errors.lastname[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="firstname" class="block text-md font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="firstname" id="firstname"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.firstname">
                        <span class="text-sm text-red-600" v-if="errors?.firstname">{{ errors.firstname[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="middlename" class="block text-md font-medium text-gray-700">Middle Name <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="middlename" id="middlename"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.middlename">
                        <span class="text-sm text-red-600" v-if="errors?.middlename">{{ errors.middlename[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="extname" class="block text-md font-medium text-gray-700">Extension Name</label>
                    <div class="mt-1">
                        <input type="text" name="extname" id="extname"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.extname">
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
                    <label for="civil_status" class="block text-md font-medium text-gray-700">Civil Status <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <select name="civil_status" id="civil_status" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.civil_status">
                            <option value="">-Select Civil Status-</option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="widowed">Widowed</option>
                            <option value="separated">Separated</option>
                            <option value="other">Other/s</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.civil_status">{{ errors.civil_status[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="birthdate" class="block text-md font-medium text-gray-700">Birthdate <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="date" name="birthdate" id="birthdate"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.birthdate">
                        <span class="text-sm text-red-600" v-if="errors?.birthdate">{{ errors.birthdate[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="height" class="block text-md font-medium text-gray-700">Height (m)</label>
                    <input type="text" name="height" id="height" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.height">
                    <span class="text-sm text-red-600" v-if="errors?.height">{{ errors.height[0] }}</span>
                </div>
                <div class="pb-1">
                    <label for="weight" class="block text-md font-medium text-gray-700">Weight (kg)</label>
                    <input type="text" name="weight" id="weight" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.weight">
                    <span class="text-sm text-red-600" v-if="errors?.weight">{{ errors.weight[0] }}</span>
                </div>
                <div class="pb-1">
                    <label for="blood_type" class="block text-md font-medium text-gray-700">Blood Type</label>
                    <select name="blood_type" id="blood_type" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.blood_type">
                        <option value="">-Select Blood Type-</option>
                        <option value="A">A</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B">B</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O">O</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB">AB</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                    <span class="text-sm text-red-600" v-if="errors?.blood_type">{{ errors.blood_type[0] }}</span>
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div class="pb-1">
                    <label for="education_level" class="block text-md font-medium text-gray-700">Education Level <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <select name="education_level" id="education_level" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.education_level">
                            <option value="">-Select Education Level-</option>
                            <option value="elementary">Elementary</option>
                            <option value="secondary">Secondary</option>
                            <option value="vocational">Vocational/Trade Course</option>
                            <option value="college">College</option>
                            <option value="graduate_studies">Graduate Studies</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.education_level">{{ errors.education_level[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="contact_no" class="block text-md font-medium text-gray-700">Contact No. <span class="text-red-500">*</span></label>
                    <input type="text" name="contact_no" id="contact_no"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.contact_no">
                    <span class="text-sm text-red-600" v-if="errors?.contact_no">{{ errors.contact_no[0] }}</span>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="email_add" class="block text-md font-medium text-gray-700">Email address <span class="text-red-500">*</span></label>
                    <input type="text" name="email_add" id="email_add"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.email_add">
                    <span class="text-sm text-red-600" v-if="errors?.email_add">{{ errors.email_add[0] }}</span>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="employment_type" class="block text-md font-medium text-gray-700">Employment Type <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <select name="employment_type" id="employment_type" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.employment_type">
                            <option value="">-Select Employment Type-</option>
                            <option value="permanent">Permanent</option>
                            <option value="cos">Contract of Service</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.employment_type">{{ errors.employment_type[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="employment_type" class="block text-md font-medium text-gray-700">Employment Status</label>
                    <div class="mt-1">
                        <select name="employment_status" id="employment_status" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.employment_status">
                            <option value="">-Select Employment Status-</option>
                            <option value="new">New</option>
                            <option value="renewed">Renewed</option>
                            <option value="retired">Retired</option>
                            <option value="resigned">Resigned</option>
                            <option value="terminated">Terminated</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.employment_status">{{ errors.employment_status[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 ">
                    <label for="position" class="block text-md font-medium text-gray-700">Position <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="position" id="position" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.position">
                        <span class="text-sm text-red-600" v-if="errors?.position">{{ errors.position[0] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="float-right py-4">
            <input type="hidden" name="organization" id="organization" v-model="form.organization" >
            <input type="hidden" name="person_type" id="person_type" v-model="form.person_type" >
            <button type="button" class="inline-flex items-center px-4 py-2 mr-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                <router-link :to="{ name: 'personinfos.index' }" class="text-sm font-medium">Cancel</router-link>
            </button>
            <!-- <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md ring-indigo-300 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring disabled:opacity-25">
                SAVE
            </button> -->
            <Button type="submit" label="SAVE" :loading="loading" size="small" />
        </div>
        
    </form>
</template>
 
<script setup>
import Button from "primevue/button";
import usePersonInfos from '../../composables/personinfos'
import { reactive, onMounted } from 'vue'
 
const form = reactive({
    lastname: '',
    firstname: '',
    middlename: '',
    extname: '',
    gender: '',
    civil_status: '',
    birthdate: '',
    height: '',
    weight: '',
    blood_type: '',
    province_id: '',
    municipality_id: '',
    barangay_id: '',
    education_level: '',
    employment_type: '',
    position: '',
    contact_no: '',
    email_add: '',
    organization: 'DENR - PENRO Marinduque',
    person_type: '1'
})
 
const { errors, provinces, municipalities, barangays, storePersonInfo, getProvinces, getMunicipalities, getBarangays, loading } = usePersonInfos()

onMounted(getProvinces)
 
const savePersonInfo = async () => {
    await storePersonInfo({ ...form })
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