<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>Edit Committee</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'committees.index' }" class="text-sm font-medium">Cancel</router-link>
                <!-- <span class="text-sm font-medium">Cancel</span> -->
            </button>
        </div>
    </div>
    <hr>
    <div class="py-4 px-4 mb-5 rounded-md shadow-md">
        <form class="space-y-6" @submit.prevent="editCommittee">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-5 gap-4">
                <div class="pb-1">
                    <label for="year_covered" class="block text-md font-medium text-gray-700">Year Covered</label>
                    <div class="mt-1">
                        <select name="year_covered" id="year_covered" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="text-transform: capitalize;" v-model="committee.year_covered">
                            <option value="">-Select Year-</option>
                            <option v-for="item in yearlist" :key="item.id" :value="item.year">{{ item.year }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.year_covered">{{ errors.year_covered[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="person_info_id" class="block text-md font-medium text-gray-700">PENRO EMPLOYEE</label>
                    <div class="mt-1">
                        <select name="person_info_id" id="person_info_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="text-transform: capitalize;" v-model="committee.person_info_id">
                            <option value="">-Select Employee-</option>
                            <option v-for="item in personinfos" :key="item.id" :value="item.id">{{ item.lastname+', '+item.firstname+' '+item.middlename+' '+item.extname }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.person_info_id">{{ errors.person_info_id[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="committee_position_id" class="block text-md font-medium text-gray-700">Position</label>
                    <div class="mt-1">
                        <select name="committee_position_id" id="committee_position_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="text-transform: capitalize;" v-model="committee.committee_position_id">
                            <option value="">-Select Position-</option>
                            <option v-for="item in committeepositions" :key="item.id" :value="item.id">{{ item.position_title }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.committee_position_id">{{ errors.committee_position_id[0] }}</span>
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
import useCommittees from '../../composables/committees'
import { reactive, onMounted } from 'vue'

const { errors, committee, yearlist, personinfos, committeepositions, getYearlist, getPersonInfos, getCommitteePositions, getCommittee, updateCommittee } = useCommittees()

const props = defineProps({
    id: {
        required: true,
        type: String
    }
})

onMounted(getPersonInfos)
onMounted(getCommitteePositions)
onMounted(getYearlist)
onMounted(() => getCommittee(props.id))

const editCommittee = async () => {
    await updateCommittee(props.id)
}
</script>