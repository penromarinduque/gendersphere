<template>
    <form class="space-y-6" @submit.prevent="editTraining">
        <input type="hidden" name="id" id="id" v-model="training.id">
        <div class="space-y-4 rounded-md">
            <h3><b>Edit Info</b></h3>
            <hr>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div class="pb-1">
                    <label for="trainingtitle" class="block text-md font-medium text-gray-700">Training Title </label>
                    <div class="mt-1">
                        <input type="text" name="trainingtitle" id="trainingtitle" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="training.training_title">
                        <span class="text-sm text-red-600" v-if="errors?.training_title">{{ errors.training_title[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="trainingstart" class="block text-md font-medium text-gray-700">Training Start </label>
                    <div class="mt-1">
                        <input type="date" name="trainingstart" id="trainingstart" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.training_start">
                        <span class="text-sm text-red-600" v-if="errors?.training_start">{{ errors.training_start[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="trainingend" class="block text-md font-medium text-gray-700">Training End </label>
                    <div class="mt-1">
                        <input type="date" name="trainingend" id="trainingend" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.training_end">
                        <span class="text-sm text-red-600" v-if="errors?.training_end">{{ errors.training_end[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="durationhours" class="block text-md font-medium text-gray-700">Duration (Hours)</label>
                    <div class="mt-1">
                        <input type="text" readonly name="durationhours" id="durationhours"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.duration_hours">
                        <span class="text-sm text-red-600" v-if="errors?.duration_hours">{{ errors.duration_hours[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="trainingtype" class="block text-md font-medium text-gray-700">Learning Description Type</label>
                    <div class="mt-1">
                        <select name="trainingtype" id="trainingtype" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="training.learning_description_type">
                            <option value="managerial">Managerial</option>
                            <option value="supervisory">Supervisory</option>
                            <option value="technical">Technical</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.learning_description_type">{{ errors.learning_description_type[0] }}</span>
                    </div>
                </div>           
                <div class="pb-1">
                    <label for="sponsor" class="block text-md font-medium text-gray-700">Sponsor/Facilitator</label>
                    <input type="text" name="sponsor" id="sponsor" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="training.sponsor_facilitator">
                    <span class="text-sm text-red-600" v-if="errors?.sponsor_facilitator">{{ errors.sponsor_facilitator[0] }}</span>
                </div>
            <div class="pb-1">
                <label for="trainingnature" class="block text-md font-medium text-gray-700">Training Nature</label>
                  <select id="trainingnature" name="trainingnature"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    v-model="training.training_nature">
                    <option value="attended">Attended</option>
                    <option value="conducted">Conducted</option>
                  </select>
                   <span class="text-sm text-red-600" v-if="errors?.training_nature">{{ errors.training_nature }}</span>
            </div>
            <div class="pb-1">
              <label for="isgadrelated" class="block text-md font-medium text-gray-700">GAD Related</label>
              <select id="isgadrelated" name="isgadrelated"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                v-model="training.is_gad_related"> 
                <option :value="true">Yes</option>      
                <option :value="false">No</option>  
              </select>
              <span class="text-sm text-red-600" v-if="errors.is_gad_related">{{errors.is_gad_related}}</span>
            </div>
                
            </div>
            <div class="float-right py-4 space-x-4">
            <!-- Cancel Button with Icon -->
            <router-link
                :to="{ name: 'trainings.index' }"
                class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring ring-gray-300 disabled:opacity-25"
            >
                <i class="pi pi-times mr-2"></i> Cancel
            </router-link>

            <!-- Save Button -->
            <Button
                type="submit"
                label="Save Changes"
                icon="pi pi-save"
                iconPos="left"
                :loading="loading"
                size="small"
                class="!h-[40px]"
            />
            </div>
        </div>
    </form>
</template>
 
<script setup>
import Button from "primevue/button"
import useTrainings from '@/composables/trainings'
import { onMounted, reactive, watch} from 'vue';

const { errors, training, updateTraining, getTraining, loading, calculateHours, msToHours, formatDateToYYYYMMDD } = useTrainings();

const props = defineProps({
    id: {
        required: true,
        type: String
    }
});


const form = reactive({
    training_start: formatDateToYYYYMMDD(new Date()),
    training_end: formatDateToYYYYMMDD(new Date()),
    duration_hours: '',
})

watch(() => [form.training_start, form.training_end],
  ([start, end]) => {
    if (start && end) {
      const startDate = new Date(start)
      const endDate = new Date(end)

      if (!isNaN(startDate) && !isNaN(endDate) && endDate >= startDate) {
        const msDifference = endDate - startDate
        const hours = calculateHours(msToHours(msDifference)) // includes start and end day
        form.duration_hours = hours
      } else {
        form.duration_hours = ''
      }
    } else {
      form.duration_hours = ''
    }
  }
)
onMounted(async () => {
  await getTraining(props.id)

  // Initialize form fields from fetched training
  form.training_start = training.value.training_start
  form.training_end = training.value.training_end
  form.duration_hours = training.value.duration_hours
})
/* onMounted() */
/* watch(training, () => {
    // console.log(personinfo.value.municipality_id)
})
  */
const editTraining = async () => {
    training.value.duration_hours = form.duration_hours
    training.value.training_start = form.training_start
    training.value.training_end = form.training_end
    await updateTraining(props.id)
}

</script>