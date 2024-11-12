<template>
    <form class="space-y-6" @submit.prevent="saveActivity">
        <div class="space-y-4 rounded-md">
            <h3><b>Add New</b></h3>
            <hr>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                <div class="pb-1">
                    <label for="activity_type" class="block text-md font-medium text-gray-700">Type</label>
                    <div class="mt-1">
                        <select name="activity_type" id="activity_type" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.activity_type">
                            <option value="">-Select Type-</option>
                            <option value="client">Client Focus</option>
                            <option value="organizational">Organizational Focus</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.activity_type">{{ errors.activity_type[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="gad_activity" class="block text-md font-medium text-gray-700">GAD Activity</label>
                    <div class="mt-1">
                        <textarea name="gad_activity" id="gad_activity"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.gad_activity"></textarea>
                        <span class="text-sm text-red-600" v-if="errors?.gad_activity">{{ errors.gad_activity[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="name_title" class="block text-md font-medium text-gray-700">Name/ Title</label>
                    <div class="mt-1">
                        <input type="text" name="name_title" id="name_title"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.name_title">
                        <span class="text-sm text-red-600" v-if="errors?.name_title">{{ errors.name_title[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <div class="pb-1">
                    <label for="date_conducted" class="block text-md font-medium text-gray-700">Date Conducted</label>
                    <div class="mt-1">
                        <input type="date" name="date_conducted" id="date_conducted"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.date_conducted">
                        <span class="text-sm text-red-600" v-if="errors?.date_conducted">{{ errors.date_conducted[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="place_conducted" class="block text-md font-medium text-gray-700">Place Conducted</label>
                    <div class="mt-1">
                        <input type="text" name="place_conducted" id="place_conducted" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.place_conducted">
                        <span class="text-sm text-red-600" v-if="errors?.place_conducted">{{ errors.place_conducted[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="resource_speakers" class="block text-md font-medium text-gray-700">Resource Speakers</label>
                    <div class="mt-1">
                        <input type="text" name="resource_speakers" id="resource_speakers" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.resource_speakers">
                        <span class="text-sm text-red-600" v-if="errors?.resource_speakers">{{ errors.resource_speakers[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-6 gap-4">
                <div class="pb-1 col-span-3">
                    <label for="remarks" class="block text-md font-medium text-gray-700">Remarks</label>
                    <div class="mt-1">
                        <textarea name="remarks" id="remarks" rows="2"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.remarks"></textarea>
                        <span class="text-sm text-red-600" v-if="errors?.remarks">{{ errors.remarks[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-1">
                    <label for="gad_budget_allotment" class="block text-md font-medium text-gray-700">GAD Budget Allotment</label>
                    <div class="mt-1">
                        <input type="text" name="gad_budget_allotment" id="gad_budget_allotment" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.gad_budget_allotment">
                        <span class="text-sm text-red-600" v-if="errors?.gad_budget_allotment">{{ errors.gad_budget_allotment[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-1">
                    <label for="gad_allocated" class="block text-md font-medium text-gray-700">GAD Allocated</label>
                    <div class="mt-1">
                        <input type="text" name="gad_allocated" id="gad_allocated" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.gad_allocated">
                        <span class="text-sm text-red-600" v-if="errors?.gad_allocated">{{ errors.gad_allocated[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-1">
                    <label for="gad_remaining_budget" class="block text-md font-medium text-gray-700">GAD Remaining Budget</label>
                    <div class="mt-1">
                        <input type="text" name="gad_remaining_budget" id="gad_remaining_budget" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="form.gad_remaining_budget">
                        <span class="text-sm text-red-600" v-if="errors?.gad_remaining_budget">{{ errors.gad_remaining_budget[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

            </div>
        </div>
        <div class="float-right py-4">
            <button type="button" class="inline-flex items-center px-4 py-2 mr-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                <router-link :to="{ name: 'activities.index' }" class="text-sm font-medium">Cancel</router-link>
            </button>
            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md ring-indigo-300 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring disabled:opacity-25">
                SAVE
            </button>
        </div>
        
    </form>
</template>

<script setup>
import useActivities from '../../composables/activities'
import { reactive, onMounted } from 'vue'
 
const form = reactive({
    activity_type: '',
    name_title: '',
    date_conducted: '',
    place_conducted: '',
    resource_speakers: '',
    remarks: '',
    gad_budget_allotment: '',
    gad_allocated: '',
    gad_remaining_budget: ''
})
 
const { errors, storeActivity } = useActivities()

const saveActivity = async () => {
    await storeActivity({ ...form })
}


</script>