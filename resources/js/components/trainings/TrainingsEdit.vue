<template>
    <form class="space-y-6" @submit.prevent="editTraining">
        <input type="hidden" name="id" id="id" v-model="training.id">
        <div class="space-y-4 rounded-md">
            <h3><b>Edit Info</b></h3>
            <hr>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div class="pb-1">
                    <label for="trainingtitle" class="block text-md font-medium text-gray-700">Training Title <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="trainingtitle" id="trainingtitle" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="training.training_title">
                        <span class="text-sm text-red-600" v-if="errors?.training_title">{{ errors.training_title[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="trainingstart" class="block text-md font-medium text-gray-700">Training Start <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="datetime-local" name="trainingstart" id="trainingstart" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="training.training_start">
                        <span class="text-sm text-red-600" v-if="errors?.training_start">{{ errors.training_start[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="trainingend" class="block text-md font-medium text-gray-700">Training End <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="datetime-local" name="trainingend" id="trainingend" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="training.training_end">
                        <span class="text-sm text-red-600" v-if="errors?.training_end">{{ errors.training_end[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="durationhours" class="block text-md font-medium text-gray-700">Duration Hours</label>
                    <div class="mt-1">
                        <input type="text" readonly name="durationhours" id="durationhours"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="training.duration_hours">
                        <span class="text-sm text-red-600" v-if="errors?.duration_hours">{{ errors.durationhours[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="trainingtype" class="block text-md font-medium text-gray-700">Learning Description Type <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <select name="trainingtype" id="trainingtype" placeholder="-Select Training Type-" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="training.learning_description_type">
                            <option value="" disabled selected>-Select Learning Description Type-</option>
                            <option value="managerial">Managerial</option>
                            <option value="supervisory">Supervisory</option>
                            <option value="technical">Technical</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.learning_description_type">{{ errors.learning_description_type[0] }}</span>
                    </div>
                </div>           
                <div class="pb-1">
                    <label for="sponsor" class="block text-md font-medium text-gray-700">Sponsor/Facilitator<span class="text-red-500">*</span></label>
                    <input type="text" name="sponsor" id="sponsor" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="training.sponsor_facilitator">
                    <span class="text-sm text-red-600" v-if="errors?.sponsor_facilitator">{{ errors.sponsor_facilitator[0] }}</span>
                </div>
            </div>
            <div class="float-right py-4">
                <button type="button" class="inline-flex items-center px-4 py-2 mr-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                            <router-link :to="{ name: 'trainings.index' }" class="text-sm font-medium">Cancel</router-link>
                </button>
                <!-- <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md ring-indigo-300 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring disabled:opacity-25">
                    Save Changes
                </button> -->
                <Button type="submit" label="SAVE CHANGES" :loading="loading" size="small" />
            </div>
        </div>
    </form>
</template>
 
<script setup>
import Button from "primevue/button"
import useTrainings from '@/composables/trainings'
import { onMounted, reactive, watch} from 'vue';

const { errors, training, updateTraining, getTraining, loading } = useTrainings();

const props = defineProps({
    id: {
        required: true,
        type: String
    }
});

const manilaOffsetMinutes = 8 * 60 // +8 hours

function toDatetimeLocal(dateString, offsetMinutes = 0) {
  const date = new Date(dateString)

  // Add the offset (in minutes) to convert to target timezone
  date.setMinutes(date.getMinutes() + offsetMinutes)

  const iso = date.toISOString()
  return iso.slice(0, 16) // Return in YYYY-MM-DDTHH:mm format
}

const form = reactive({
    training_title: '',
    training_start: toDatetimeLocal(new Date(), manilaOffsetMinutes),
    training_end: toDatetimeLocal(new Date(), manilaOffsetMinutes),
    duration_hours: '',
    learning_description_type: '',
    sponsor_facilitator: '',
})

watch(() => [form.training_start, form.training_end],
  ([start, end]) => {
    if (start && end) {
      const startDate = new Date(start)
      const endDate = new Date(end)

      if (!isNaN(startDate) && !isNaN(endDate) && endDate >= startDate) {
        const msDifference = endDate - startDate
        const hours = msDifference / (1000*60*60) // includes start and end day
        form.duration_hours = hours.toFixed(2) // Format to 2 decimal places
      } else {
        form.duration_hours = ''
      }
    } else {
      form.duration_hours = ''
    }
  }
)
onMounted(() => getTraining(props.id))
/* onMounted() */
/* watch(training, () => {
    // console.log(personinfo.value.municipality_id)
})
  */
const editTraining = async () => {
    await updateTraining(props.id)
}

</script>