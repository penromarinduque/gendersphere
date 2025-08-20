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
                        <input type="date" name="trainingstart" id="trainingstart" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.training_start">
                        <span class="text-sm text-red-600" v-if="localErrors.training_start">{{ localErrors.training_start }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="trainingend" class="block text-md font-medium text-gray-700">Training End <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="date" name="trainingend" id="trainingend" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.training_end">
                        <span class="text-sm text-red-600" v-if="localErrors.training_end">{{ localErrors.training_end }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="durationhours" class="block text-md font-medium text-gray-700">Duration (Hours)</label>
                    <div class="mt-1">
                        <input type="text" readonly name="durationhours" id="durationhours"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.duration_hours">
                        <span class="text-sm text-red-600" v-if="localErrors.duration_hours">{{ localErrors.duration_hours }}</span>
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
                            <option value="foundation">Foundation</option>
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
            <div class="pb-1">
                <label for="trainingnature" class="block text-md font-medium text-gray-700">Training Nature</label>
                  <select id="trainingnature" name="trainingnature"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    v-model="form.training_nature">
                    <option value="" disabled selected>-Select Training Nature-</option>
                    <option value="attended">Attended</option>
                    <option value="conducted">Conducted</option>
                  </select>
                   <span class="text-sm text-red-600" v-if="localErrors.training_nature">{{ localErrors.training_nature }}</span>
            </div>
            <div class="pb-1">
              <label for="isgadrelated" class="block text-md font-medium text-gray-700">GAD Related</label>
              <select id="isgadrelated" name="isgadrelated"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                v-model="form.is_gad_related">
                <option value="" disabled selected>-Yes or No-</option> 
                <option :value="true">Yes</option>      
                <option :value="false">No</option>  
              </select>
              <span class="text-sm text-red-600" v-if="localErrors.is_gad_related">{{ localErrors.is_gad_related}}</span>
            </div>
          </div>  
       <div class="float-right py-4 space-x-4">
          <input type="hidden" name="officeid" id="officeid" v-model="form.office_id" > 
   <!-- Cancel Button (router-link styled as a button) -->
        <router-link
          :to="{ name: 'trainings.index' }"
          class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold tracking-widest text-white transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25 h-10"
        >
          <i class="pi pi-times mr-2 text-sm"></i>
          Cancel
        </router-link>

        <!-- Save Button (PrimeVue) -->
        <Button
          icon="pi pi-save"
          type="submit"
          label="Save"
          :loading="loading"
          size="small"
          class="h-10"
        />
        </div>
    </div>
    </form>
</template>
 

<script setup>
import Button from "primevue/button";
import { reactive, onMounted, watch, computed } from 'vue'
import axios from 'axios'
import useTrainings from "../../composables/trainings";

// 2. Composable with storeTraining method
const { errors, storeTraining, loading, calculateHours, msToHours, formatDateToYYYYMMDD } = useTrainings();

// 1. Reactive form object
const form = reactive({
    training_title: '',
    training_start: formatDateToYYYYMMDD(new Date()),
    training_end: formatDateToYYYYMMDD(new Date()),
    duration_hours: '',
    learning_description_type: '',
    sponsor_facilitator: '',
    training_nature: '',
    is_gad_related: false,
    office_id: '', // this will be set from auth user
})

const localErrors = reactive({
  training_title: '',
  training_start: '',
  training_end: '',
  duration_hours: '',
  learning_description_type: '',
  sponsor_facilitator: '',
  training_nature: '',
  is_gad_related: '',
})

const manilaOffsetMinutes = 8 * 60 // +8 hours

const validateForm = () => {
  let valid = true

  // Clear previous errors
  //Object.keys(localErrors).forEach(key => (localErrors[key] = ''))

  // Helper function to check if a value is empty
  const isEmptyString = (val) => {
    return val === undefined || val === null || (typeof val === 'string' && val.trim() === '');
  };

  // training_title
  if (isEmptyString(form.training_title)) {
    localErrors.training_title = 'Required';
    valid = false;
  }

  // training_start
  if (isEmptyString(form.training_start)) {
    localErrors.training_start = 'Required';
    valid = false;
  }

  // training_end
  if (isEmptyString(form.training_end)) {
    localErrors.training_end = 'Required';
    valid = false;

  } else if (!isEmptyString(form.training_start) && new Date(form.training_end) < new Date(form.training_start)) {
    localErrors.training_start = 'Start date cannot be after end date';
    localErrors.training_end = 'End date cannot be before start date';
    valid = false;
  }

  // learning_description_type
  if (isEmptyString(form.learning_description_type)) {
    localErrors.learning_description_type = 'Required';
    valid = false;
  }

  // sponsor_facilitator
  if (isEmptyString(form.sponsor_facilitator)) {
    localErrors.sponsor_facilitator = 'Required';
    valid = false;
  }

  // training_nature
  if (isEmptyString(form.training_nature)) {
    localErrors.training_nature = 'Required';
    valid = false;
  }

  // is_gad_related
  if (isEmptyString(form.is_gad_related)) {
    localErrors.is_gad_related = 'Required';
    valid = false;
  }
  return valid
}

// 3. On component mount, get the authenticated user
onMounted(async () => {
    try {
        const { data: user } = await axios.get('/api/user') // Assumes Sanctum or Passport auth
        form.office_id = user.office_id //Set office_id from logged-in user
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
        const hours = calculateHours(msToHours(msDifference)); 
        
        // Set duration_hours to 2 decimal places
        form.duration_hours = hours // Format to 2 decimal places
      } 
      
      else {
        form.duration_hours = ''
      }
    } 
    else {
      form.duration_hours = ''
    }
  },
  { immediate: true }
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
  // Clear only once here
    Object.keys(localErrors).forEach(key => {
    localErrors[key] = '';});
  // Frontend validation
  if (!validateForm()) return;

  try {
    await storeTraining({ ...form });
  } catch (error) {
    if (error.response?.status === 422) {
      const serverErrors = error.response.data.errors;

      // Assign server-side validation errors to localErrors
    Object.assign(localErrors, Object.fromEntries(
    Object.entries(serverErrors).map(([key, value]) => [key, value[0]])));
    }
  }
};


</script>
