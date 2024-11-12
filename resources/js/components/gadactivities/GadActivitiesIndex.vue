<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div >
            <h3 class="text-lg"><b>GAD Activity Details</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center mr-1 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'planbudgets.index' }" class="text-sm font-medium">Back</router-link>
            </button>
        </div>
    </div>
    <hr>
    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
        <div class="py-3">
            <h3 class="text-lg"><b>GAD Activity: <u>{{ gadactivity.main_activity }}</u></b></h3>
        </div>
    </div>
</template>
<script setup>
import useGadActivities from '@/composables/gadactivities';
import useActivityDetails from '../../composables/activitydetails';
import { onMounted } from 'vue'

const { gadactivity, getGadActivity } = useGadActivities()
const { activitydetails, getActivityDetails } = useActivityDetails()

const props = defineProps({
    ga_id: {
        required: true,
        type: String
    }
})

onMounted(() => getGadActivity(props.ga_id))
onMounted(() => getActivityDetails(props.ga_id))

</script>