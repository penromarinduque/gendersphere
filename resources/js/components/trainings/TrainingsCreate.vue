<template>
    <form class="space-y-6" @submit.prevent="saveTraining">
        <div class="space-y-4 rounded-md">
            <h3><b>Add New</b></h3>
            <hr>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div class="pb-1">
                    <label for="trainingtitle" class="block text-md font-medium text-gray-700">Training Title <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="trainingtitle" id="trainingtitle" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.training_title">
                        <span class="text-sm text-red-600" v-if="localErrors.training_title">{{ localErrors.training_title }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="trainingstart" class="block text-md font-medium text-gray-700">Training Start <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="datetime-local" name="trainingstart" id="trainingstart" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.training_start">
                        <span class="text-sm text-red-600" v-if="localErrors.training_start">{{ localErrors.training_start }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="trainingend" class="block text-md font-medium text-gray-700">Training End <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="datetime-local" name="trainingend" id="trainingend" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.training_end">
                        <span class="text-sm text-red-600" v-if="localErrors.training_end">{{ localErrors.training_end }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="durationhours" class="block text-md font-medium text-gray-700">Duration Hours</label>
                    <div class="mt-1">
                        <input type="text" readonly name="durationhours" id="durationhours"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.duration_hours">
                        <span class="text-sm text-red-600" v-if="errors?.duration_hours">{{ errors.durationhours[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="trainingtype" class="block text-md font-medium text-gray-700">Learning Description Type <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <select name="trainingtype" id="trainingtype" placeholder="-Select Training Type-" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.learning_description_type">
                            <option value="" disabled selected>-Select Learning Description Type-</option>
                            <option value="managerial">Managerial</option>
                            <option value="supervisory">Supervisory</option>
                            <option value="technical">Technical</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="localErrors.learning_description_type">{{ localErrors.learning_description_type }}</span>
                    </div>
                </div>           
                <div class="pb-1">
                    <label for="sponsor" class="block text-md font-medium text-gray-700">Sponsor/Facilitator<span class="text-red-500">*</span></label>
                    <input type="text" name="sponsor" id="sponsor" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.sponsor_facilitator">
                    <span class="text-sm text-red-600" v-if="localErrors.sponsor_facilitator">{{ localErrors.sponsor_facilitator }}</span>
                </div>
            </div>
       <div class="float-right py-4">
            <input type="hidden" name="officeid" id="officeid" v-model="form.office_id" > 
            <button type="button" class="inline-flex items-center px-4 py-2 mr-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                <router-link :to="{ name: 'trainings.index' }" class="text-sm font-medium">Cancel</router-link>
            </button>
            <!-- <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md ring-indigo-300 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring disabled:opacity-25">
                SAVE
            </button> -->
            <Button type="submit" label="SAVE" :loading="loading" size="small" />
        </div>
    </div>
    </form>
</template>
 

<script setup>
import Button from "primevue/button";
import { reactive, onMounted, watch, computed } from 'vue'
import axios from 'axios'
import useTrainings from "../../composables/trainings";

function toDatetimeLocal(dateString, offsetMinutes = 0) {
  const date = new Date(dateString)

  // Add the offset (in minutes) to convert to target timezone
  date.setMinutes(date.getMinutes() + offsetMinutes)

  const iso = date.toISOString()
  return iso.slice(0, 16) // Return in YYYY-MM-DDTHH:mm format
}
// 1. Reactive form object
const form = reactive({
    training_title: '',
    training_start: toDatetimeLocal(new Date(), manilaOffsetMinutes),
    training_end: toDatetimeLocal(new Date(), manilaOffsetMinutes),
    duration_hours: '',
    learning_description_type: '',
    sponsor_facilitator: '',
    office_id: '', // this will be set from auth user
})

const localErrors = reactive({
  training_title: '',
  training_start: '',
  training_end: '',
  learning_description_type: '',
  sponsor_facilitator: '',
})

const manilaOffsetMinutes = 8 * 60 // +8 hours

const validateForm = () => {
  let valid = true

  // Clear previous errors
  Object.keys(localErrors).forEach(key => (localErrors[key] = ''))

  if (!form.training_title.trim()) {
    localErrors.training_title = 'Required'
    valid = false
  }

  if (!form.training_start) {
    localErrors.training_start = 'Required'
    valid = false
  }

  if (!form.training_end) {
    localErrors.training_end = 'Required'
    valid = false
  } 
  else if (new Date(form.training_end) < new Date(form.training_start)) {
    localErrors.training_start = 'Start date cannot be after end date'
    localErrors.training_end = 'End date cannot be before start date'
    valid = false
  }

  if (!form.learning_description_type) {
    localErrors.learning_description_type = 'Required'
    valid = false
  }

  if (!form.sponsor_facilitator.trim()) {
    localErrors.sponsor_facilitator = 'Required'
    valid = false
  }

  return valid
}

// 2. Composable with storeTraining method
const { errors, storeTraining, loading } = useTrainings();

// 3. On component mount, get the authenticated user
onMounted(async () => {
    try {
        const { data: user } = await axios.get('/api/user') // Assumes Sanctum or Passport auth
        form.office_id = user.office_id // 👈 Set office_id from logged-in user
    } catch (error) {
        console.error('Error fetching auth user:', error)
    }
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

/* const validateForm = () => {
  let valid = true

  // Clear previous errors
  Object.keys(localErrors).forEach(key => (localErrors[key] = ''))

 if (new Date(form.training_end) < new Date(form.training_start)) {
    localErrors.training_end = 'End date cannot be before start date'
    valid = false
  }

  if (!form.learning_description_type) {
    localErrors.learning_description_type = 'Learning Description Type is required'
    valid = false
  }

  return valid
} */
// 4. Save the form
const saveTraining = async () => {
     console.log('Form to submit:', form)
    if (!validateForm()) return
    await storeTraining({ ...form }); // Spread form data to payload
}

</script>
