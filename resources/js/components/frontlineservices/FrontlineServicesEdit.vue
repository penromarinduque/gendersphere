<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>Edit Frontline Service</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'frontlineservices.index' }" class="text-sm font-medium">Cancel</router-link>
            </button>
        </div>
    </div> 
    <hr>
    <div class="py-4 px-4 mb-5 rounded-md shadow-md">
        <form class="space-y-6" @submit.prevent="editFrontlineService">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="permit_type_id" class="block text-md font-medium text-gray-700">Permit Type</label>
                    <div class="mt-1">
                        <select name="permit_type_id" id="permit_type_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="text-transform: 'capitalize';" v-model="frontlineservice.permit_type_id" >
                            <option value="">-Select Permit Type-</option>
                            <option v-for="item in permittypesbystatus" :key="item.id" :value="item.id">{{ item.service+' - '+item.permit_type }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.permit_type_id">{{ errors.permit_type_id[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="client_name" class="block text-md font-medium text-gray-700">Name of Client</label>
                    <div class="mt-1">
                        <input type="text" name="client_name" id="client_name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Complete Name of Client/ Representative" v-model="frontlineservice.client_name" >
                        <span class="text-sm text-red-600" v-if="errors?.client_name ">{{ errors.client_name[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="gender" class="block text-md font-medium text-gray-700">Gender</label>
                    <div class="mt-1">
                        <select name="gender" id="gender" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="frontlineservice.gender">
                            <option value="">-Select Gender-</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.gender">{{ errors.gender[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="date_applied" class="block text-md font-medium text-gray-700">Date Applied/Received</label>
                    <div class="mt-1">
                        <input type="date" name="date_applied" id="date_applied"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="frontlineservice.date_applied">
                        <span class="text-sm text-red-600" v-if="errors?.date_applied">{{ errors.date_applied[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="date_released" class="block text-md font-medium text-gray-700">Date Approved/Released</label>
                    <div class="mt-1">
                        <input type="date" name="date_released" id="date_released"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="frontlineservice.date_released">
                        <span class="text-sm text-red-600" v-if="errors?.date_released">{{ errors.date_released[0] }}</span>
                    </div>
                </div>
            </div>
            <h5 class="pb-0">Address:</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="municipality_id" class="block text-md font-medium text-gray-700">Municipality</label>
                    <div class="mt-1">
                        <select name="municipality_id" id="municipality_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="frontlineservice.municipality_id" @change="getMunicipalBrgys($event)">
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
                        v-model="frontlineservice.barangay_id">
                            <option value="">-Select Barangay-</option>
                            <option v-for="brgy in barangays" :key="brgy.id" :value="brgy.id">{{ brgy.barangay_name }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.barangay_id">{{ errors.barangay_id[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="float-right py-4">
                <div class="pb-1">
                    <button type="submit" class="inline-flex items-center px-4 py-2 ml-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-800 border border-transparent rounded-md ring-blue-300 hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring disabled:opacity-25">
                    SAVE CHANGES
                </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { onMounted, watch } from 'vue'
import useFrontlineServices from '../../composables/frontlineservices'
import usePermitTypes from '../../composables/permittypes';
import usePersonInfos from '../../composables/personinfos'

const { errors, frontlineservice, getFrontlineService, updateFrontlineService } = useFrontlineServices()
const { permittypesbystatus, getPermitTypesByStatus } = usePermitTypes()
const { municipalities, barangays, getMunicipalities, getBarangays } = usePersonInfos()

const props = defineProps({
    id: {
        required: true,
        type: String
    }
})

onMounted(() => getFrontlineService(props.id))
onMounted(() => getPermitTypesByStatus(1))
onMounted(() => getMunicipalities(23))
watch(frontlineservice, () => {
    getBarangays(frontlineservice.value.municipality_id);
})

const editFrontlineService = async () => {
    await updateFrontlineService(props.id)
}

const getMunicipalBrgys = async (event) => {
    let mun_id = event.target.value;
    console.log(mun_id);   
    if (mun_id!=="") {
        await getBarangays(mun_id)
    }
}
</script>