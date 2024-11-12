<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div >
            <h3 class="text-lg"><b>Activity Details</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center mr-1 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'activitydetails.create', params: { ga_id: props.ga_id } }" class="text-sm font-medium">Add New</router-link>
            </button>
            <button class="inline-flex items-center mr-1 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'planbudgets.index' }" class="text-sm font-medium">Back to Plan & Budget</router-link>
            </button>
        </div>
    </div>
    <hr>
    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
        <div class="py-3">
            <form @submit.prevent="editGadActivity(gadactivity.id)">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 xl:grid-cols-6 gap-4">
                    <div class="pb-1 col-span-4">
                        <label for="sub_activity" class="block text-md font-medium text-gray-700"><b>GAD Activity</b></label>
                        <div class="mt-1">
                            <input name="main_activity" id="main_activity"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="gadactivity.main_activity">
                            <span class="text-sm text-red-600" v-if="errors?.main_activity">{{ errors.main_activity[0] }}</span>
                        </div>
                    </div>
                    <div class="pt-1 pb-1 col-span-2">
                        <label for="sub_activity" class="block text-md font-medium text-gray-700">&nbsp;</label>
                        <button type="submit" class="inline-flex items-center mr-2 px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md ring-indigo-300 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring disabled:opacity-25">
                            UPDATE
                        </button>
                        <button type="button" @click="deleteGadActivity(props.ga_id)"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25" v-if="activitydetails.length === 0">
                        Delete</button>
                    </div>
                </div>
                <!-- <h3 class="text-lg"><b>GAD Activity: <u>{{ gadactivity.main_activity }}</u></b></h3> -->
            </form>
        </div>
        <table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Sub Activity</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Performance Indicators /Targets</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actual Results /Outputs and Outcomes</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">GAD Budget</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actual Cost / Cost Expenditure</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Responsible Unit/Office</span>
                </th>
                <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Remarks</span>
                </th>
                <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actions</span>
                </th>
            </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-for="item in activitydetails" :key="item.id">
                <tr class="bg-white align-text-top">
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <!-- <span style="text-transform: capitalize;">{{ item.sub_activity }}</span> -->
                        <span v-html="item.sub_activity"></span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <!-- <span style="text-transform: capitalize;">{{ item.targets }}</span> -->
                        <span v-html="item.targets"></span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <!-- <span style="text-transform: capitalize;">{{ item.actual_result }}</span> -->
                        <span v-html="item.actual_result"></span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.gad_budget.toLocaleString() }}</span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;" v-if="item.actual_cost!=0">{{ item.actual_cost.toLocaleString() }}</span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.responsible_unit }}</span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <!-- <span style="text-transform: capitalize;">{{ item.remarks }}</span> -->
                        <span v-html="item.remarks"></span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <button class="inline-flex items-center mr-1 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25">
                            <router-link :to="{ name: 'activitydetails.updateaccom', params: { id: item.id, ga_id: props.ga_id } }" class="text-sm font-medium">Update Accom.</router-link>
                        </button>
                        <router-link :to="{ name: 'activitydetails.edit', params: { id: item.id, ga_id: props.ga_id } }" class="inline-flex items-center mr-2 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">Edit</router-link> 
                        <button @click="deleteActivityDetail(item.id, props.ga_id)"
                        class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                        Delete</button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>
<script setup>
import useGadActivities from '@/composables/gadactivities';
import useActivityDetails from '../../composables/activitydetails';
import { onMounted } from 'vue'

const { gadactivity, getGadActivity, updateGadActivity, destroyGadActivity } = useGadActivities()
const { activitydetails, getActivityDetails, destroyActivityDetail } = useActivityDetails()

const props = defineProps({
    ga_id: {
        required: true,
        type: String
    }
})

onMounted(() => getGadActivity(props.ga_id))
onMounted(() => getActivityDetails(props.ga_id))

const deleteActivityDetail = async (id, gaId) => {
    if (!window.confirm('You sure you want to delete this record?')) {
        return
    }
    
    await destroyActivityDetail(id)
    await getActivityDetails(gaId)
    // console.log(1);
}

const editGadActivity = async (gadactivity_id) => {
    // console.log(gadactivity_id);
    await updateGadActivity(gadactivity_id, props.ga_id);
}

const deleteGadActivity = async (gadactivity_id) => {
    if (!window.confirm('You sure you want to delete this record?')) {
        return
    }
    console.log(gadactivity_id);
    await destroyGadActivity(gadactivity_id)
}

</script>