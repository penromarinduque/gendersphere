<template>
  <form class="space-y-6" @submit.prevent="saveTraining">
    <div class="space-y-4 rounded-md">
      <h3><b>Add New</b></h3>
      <hr>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
          <div class="pb-1">
            <label for="trainingtitle" class="block text-md font-medium text-gray-700">Training Title <span class="text-red-500">*</span></label>
            <div class="mt-1">
              <input
                autocomplete="off"
                type="text"
                name="trainingtitle"
                id="trainingtitle"
                list="training-titles"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                v-model="form.training_title"
                @input="fetchSuggestions"
              />
              <datalist id="training-titles">
                <option
                  v-for="training in suggestions"
                  :key="training.id"
                  :value="training.training_title"
                />
              </datalist>
              <span class="text-sm text-red-600" v-if="localErrors.training_title">
                {{ localErrors.training_title }}
              </span>
            </div>
                </div>
                <div class="pb-1">
                    <label for="trainingstart" class="block text-md font-medium text-gray-700">Training Start <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="date" name="trainingstart" id="trainingstart" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.training_start"
                                @input="lastModifiedField = 'training_start'">
                        <span class="text-sm text-red-600" v-if="localErrors.training_start">{{ localErrors.training_start }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="trainingend" class="block text-md font-medium text-gray-700">Training End <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="date" name="trainingend" id="trainingend" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.training_end"
                                @input="lastModifiedField = 'training_end'">
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
                      <select
                        name="trainingtype"
                        id="trainingtype"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.learning_description_type"
                        :disabled="isExistingTraining">
                        <option value="" disabled selected>-Select Training Type-</option> 
                        <option v-for="type in trainingTypes" :key="type.value" :value="type.value">
                          {{ type.label }}
                        </option>
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
                    v-model="form.training_nature"
                    :disabled="isExistingTraining">
                    <option value="" disabled selected>-Select Training Nature-</option>
                    <option value="attended">Attended</option>
                    <option value="conducted">Conducted</option>
                  </select>
                   <span class="text-sm text-red-600" v-if="localErrors.training_nature">{{ localErrors.training_nature }}</span>
            </div>
            <div class="pb-1">
              <label for="isgadrelated" class="block text-md font-medium text-gray-700">GAD Related<span class="text-red-500">*</span></label>
              <select id="isgadrelated" name="isgadrelated"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                v-model="form.is_gad_related"
                :disabled="isExistingTraining">
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
          label="Save Training"
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
import { reactive, onMounted, watch, ref} from 'vue'
import axios from 'axios'
import useTrainings from "../../composables/trainings"
import useUsers from "../../composables/users";

// 2. Composable with storeTraining method

const { errors, toaster, suggestions, storeTraining, loading, trainingTypes, loadTrainingTypeOptions, calculateHours, msToHours, formatDateToYYYYMMDD } = useTrainings();
const { authUser, getAuthenticatedUser } = useUsers();
// 1. Reactive form object
const form = reactive({
  training_title: '',
  training_start: formatDateToYYYYMMDD(new Date()),
  training_end: formatDateToYYYYMMDD(new Date()),
  learning_description_type: '',
  training_nature: '',
  is_gad_related: '',
  sponsor_facilitator: '',
  office_id: '',
  duration_hours: ''
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

const isExistingTraining = ref(false);
const lastModifiedField = ref('');
const fieldsToWatch = Object.keys(localErrors);

const validateForm = () => {
  let valid = true;

  // Clear previous errors
  Object.keys(localErrors).forEach(key => {
    localErrors[key] = '';
  });

  // Define validation rules for each field
  const rules = {
    training_title: {
      required: true,
      message: 'Training title is required.'
    },
    training_start: {
      required: true,
      message: 'Training start date is required.'
    },
    training_end: {
      required: true,
      message: 'Training end date is required.'
    },
    learning_description_type: {
      required: true,
      message: 'Learning description type is required.'
    },
    sponsor_facilitator: {
      required: true,
      message: 'Sponsor/Facilitator is required.'
    },
    training_nature: {
      required: true,
      message: 'Training nature is required.'
    },
    is_gad_related: {
      required: true,
      message: 'Please indicate if this training is GAD-related.'
    }
  };

  // Loop through each rule and apply validation
  for (const field in rules) {
    const rule = rules[field];
    const value = form[field];

    if (rule.required && (value === undefined || value === null || value === '' || (typeof value === 'string' && value.trim() === ''))) {
      localErrors[field] = rule.message;
      valid = false;
    }
  }

  // Validate date order (training_start must be before or equal to training_end)
  const start = new Date(form.training_start);
  const end = new Date(form.training_end);

  if (form.training_start && form.training_end && !isNaN(start) && !isNaN(end) && start > end) {
    localErrors.training_start = 'Start date cannot be after end date.';
    localErrors.training_end = 'End date cannot be before start date.';
    valid = false;
  }

  return valid;
};

const populateFieldsFromTraining = (training) => {
  form.learning_description_type = training.learning_description_type || '';
  form.training_nature = training.training_nature || '';
  form.is_gad_related = training.is_gad_related === true || training.is_gad_related === 'true';
};

const saveTraining = async () => {

  // Clear previous frontend errors
  Object.keys(localErrors).forEach(key => {
    localErrors[key] = '';
  });

  // Run client-side validation
  if (!validateForm()) return;

  
  // Build the payload with a nested training_instance object
  const payload = {
      training_title: form.training_title.trim(),
      learning_description_type: form.learning_description_type,
      training_nature: form.training_nature,
      is_gad_related: Boolean(form.is_gad_related),
      training_instance: {
        training_start: form.training_start,
        training_end: form.training_end,
        duration_hours: Number(form.duration_hours),
        sponsor_facilitator: form.sponsor_facilitator,
        office_id: form.office_id
      }
  };

  try {
    await storeTraining(payload);
  } catch (error) {
    if (error.response?.status === 422) {
      const serverErrors = error.response.data.errors;
      const serverMessage = error.response.data.message;

      // Laravel-style error mapping
      Object.entries(serverErrors).forEach(([key, messages]) => {
        const flatKey = key.includes('training_instance.')
          ? key.replace('training_instance.', '')
          : key;
        localErrors[flatKey] = messages[0]; // show only the first error
      });

      // Show server message as a toaster (e.g., "Duplicate training found.")
      if (serverMessage) {
        toaster.error(serverMessage);
      } else {
        toaster.error("Validation failed. Please check the fields.");
      }
    } else {
      toaster.error("An unexpected error occurred. Please try again later.");
    }
  }
};

const fetchSuggestions = async () => {
  if (form.training_title.length < 2) {
    suggestions.value = [];
    return;
  }

  try {
    const res = await axios.get('/api/trainings/suggestions', {
      params: { q: form.training_title }
    });

    suggestions.value = res.data; // full training objects
  } catch (error) {
    console.error('Error fetching suggestions:', error);
  }
};

// 3. On component mount, get the authenticated user
onMounted(async () => {
    await loadTrainingTypeOptions();
      try {
    const response = await axios.get('/api/authuser/officeid');
    console.log('Fetched office_id:', response.data.office_id);
    form.office_id = response.data.office_id || '';
  } catch (error) {
    console.error('Failed to fetch office_id:', error);
  }
});

fieldsToWatch.forEach((field) => {
  watch(() => form[field], (val) => {
    if (val !== '' && localErrors[field]) {
      localErrors[field] = '';
    }
  });
});

// Detect which field was last modified
watch(() => form.training_start, () => {
  lastModifiedField.value = 'training_start';
}, { flush: 'sync' });

watch(() => form.training_end, () => {
  lastModifiedField.value = 'training_end';
}, { flush: 'sync' });

// Core logic: validate and compute duration
watch(
  () => [form.training_start, form.training_end],
  ([start, end]) => {
    const startDate = new Date(start);
    const endDate = new Date(end);
    const isValid = (date) => date instanceof Date && !isNaN(date);

    // Reset duration
    form.duration_hours = '';

    // Skip logic if either date is invalid
    if (!isValid(startDate) || !isValid(endDate)) return;

    // Clear previous errors
    localErrors.training_start = '';
    localErrors.training_end = '';

    if (startDate <= endDate) {
      // Valid date range, calculate hours
      const msDifference = endDate - startDate;
      const hours = calculateHours(msToHours(msDifference));
      form.duration_hours = parseFloat(hours.toFixed(2));
    } else {
      // Invalid date range, show error only on the last changed field
      if (lastModifiedField.value === 'training_start') {
        localErrors.training_start = 'Start date cannot be after end date.';
      } else {
        localErrors.training_end = 'End date cannot be before start date.';
      }
    }
  },
  { immediate: true }
);

watch(() => form.training_title, (newTitle) => {
  const selected = suggestions.value.find(item => item.training_title === newTitle);

  if (selected) {
    isExistingTraining.value = true;
    populateFieldsFromTraining(selected);
  } else {
    isExistingTraining.value = false;

    // Optionally reset populated fields if the title is changed to a custom one
    form.learning_description_type = '';
    form.training_nature = '';
    form.is_gad_related = '';
  }
});

</script>
