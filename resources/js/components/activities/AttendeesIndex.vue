<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>Attendees of: </b>
                <span v-if="activitydetail.sub_activity===null">Main Activity - <u>{{ activitydetail.main_activity }}</u></span>
                <span v-if="activitydetail.sub_activity!==null"><u><span v-html="activitydetail.sub_activity"></span></u></span>
                <p v-if="activitydetail.sub_activity===null">Targets:
                    <u><span v-if="activitydetail.sub_activity===null" v-html="activitydetail.targets"></span></u>
                </p>
            </h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center h-8 mr-1 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'attendees.create', params: { id: props.id, ga_id: props.ga_id } }" class="text-sm font-medium">Add Attendee</router-link>
            </button>
            <button class="inline-flex items-center h-8 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'activitydetails.index', params: { ga_id: props.ga_id } }" class="text-sm font-medium">Back to Activity Details</router-link>
            </button>
        </div>
    </div>    
    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
        <table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Name</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Gender</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Age</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Address</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Organization</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actions</span>
                </th>
            </tr>
            </thead>
 
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-for="item in attendees" :key="item.id">
                <tr class="bg-white">
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.lastname+', '+item.firstname+' '+item.middlename+' ' }}</span><span v-if="item.extname!==null">{{ item.extname }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.gender }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                       {{ item.birthdate ? computeAge(item.birthdate) : item.age }}
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.barangay_name+', '+item.municipality_name+', '+item.province_name }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span v-if="item.person_type==1" style="text-transform: capitalize;">PENRO-Marinduque</span>
                        <span v-if="item.person_type==2" style="text-transform: capitalize;">{{ item.organization }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <router-link :to="{ name: 'attendees.edit', params: { id: activitydetail.id, ga_id: props.ga_id, person_info_id: item.person_info_id } }" v-if="item.person_type==2" class="inline-flex items-center mr-2 px-2 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">Edit</router-link> 
                        <button @click="removeAttendee(item.attendee_id, activitydetail.id)" class="inline-flex items-center px-2 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                            Remove</button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script setup>
// import useActivities from '../../composables/activities'
import useActivityDetails from '../../composables/activitydetails'
import useAttendees from '../../composables/attendees';
import usePersonInfos from '../../composables/personinfos'
import { onMounted } from 'vue'

const { errors, attendees, getAttendees, destroyAttendee } = useAttendees()
const { activitydetail, getActivityDetail } = useActivityDetails()
const { computeAge } = usePersonInfos()

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

// onMounted(() => getActivity(props.id))
onMounted(() => getActivityDetail(props.id))
onMounted(() => getAttendees(props.id))

const removeAttendee = async (id, activity_id) => {
    // console.log(id);
    if (!window.confirm('You sure you want to remove this Attendee from the list?')) {
        return
    }
    await destroyAttendee(id)
    await getAttendees(activity_id)
}
</script>