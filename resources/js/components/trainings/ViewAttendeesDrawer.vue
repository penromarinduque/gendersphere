<template>
  <Drawer
    v-model:visible="isVisible"
    position="right"
    @close="certDialogVisible = false"
    :showCloseIcon="false"
    class="!w-full md:!w-80 lg:!w-[30rem]"
    @hide="emit('close')"
  >
    <template #header>
      <div class = "flex items-start mb-1">
        <div class="border border-gray-300 px-4 py-1 mr-2 bg-white rounded-t-md shadow-sm flex items-center justify-between">
          <span class="text-xl font-semibold text-center">{{ trainingName }}</span>   
        </div>
        <Button icon="pi pi-times" @click="isVisible = false" text />
      </div>
    </template>

    <div class="flex justify-between items-start mb-1 border p-4">
      <div class="text-2xl font-bold text-gray-800">
        Attendees     
        <div class="mt-4">
          <h3 class="text-lg font-bold mt-4">Gender Summary</h3>
          <ul class="grid grid-cols-3 md:grid-cols-2  lg:grid-cols-3 gap-y-1 ml-2 text-sm text-gray-700 text-left">
            <li v-for="gender in allGenders" :key="gender">
              {{ capitalize(gender) }}: {{ genderSummary[gender] ?? 0 }}
            </li>
            <li>
              Total: {{ totalAttendees }}
            </li>
          </ul>
        </div>
      </div>

  <!-- Buttons: Stack vertically -->
    <div class="flex flex-col items-end space-y-2">
      <Button 
        icon="pi pi-user-plus"
        label="Add Attendees" 
        @click="addDialogVisible = true" 
        class = "max-h-[50px] h-full max-w-[150px] w-full"
      />
      
      <Button 
        icon="pi pi-trash"
        label="Remove All" 
        severity="danger"
        @click="removeAllAttendees"
        class="max-h-[50px] h-full max-w-[150px] w-full"
      />
    </div>
  </div>
  <div v-if="loading" class="flex flex-col items-center justify-center h-48 border border-blue-200 rounded-xl bg-blue-50 shadow-inner">
    <svg class="animate-spin h-8 w-8 text-blue-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
    </svg>
    <p class="text-blue-600 text-sm font-medium">Loading attendees...</p>
  </div>

    <div v-else-if="attendees.length">
      <InputText
        v-model="searchQuery"
        placeholder="Search attendees..."
        class="w-full mb-2"
      />
      <ul class="space-y-0.5">
        <li v-for="attendee in filteredAttendees" :key="attendee.id" class=" border rounded flex justify-between  items-center pl-3 !bg-violet-100 hover:bg-gray-100">
          <div class="text-left text-sm font-semibold text-gray-800">
            <strong>
              {{ attendee.firstname }} 
              {{ attendee.lastname }}
            </strong><br />

          </div>
          <div class="flex space-x-2 my-1 mx-1">
                <Button
                  icon="pi pi-file-pdf"
                  @click="openCertDialog(attendee.id)"
                  severity="info"
                  size="small"
                  label="View Certificate"
                  class="max-h-[30px] text-xs"                  
                />
                <Button
                  icon="pi pi-trash"
                  severity="danger"
                  @click="removeAttendee(attendee.id)"
                  size="small"
                  label="Remove"
                  class="max-h-[30px] text-xs"
                />
            </div>
        </li>
      </ul>
    </div>
    <div v-if="!filteredAttendees.length && searchQuery">
      <span class="text-left text-sm font-semibold text-gray-800 text-gray-500 border rounded flex justify-between  items-center pl-3 !bg-violet-100 hover:bg-gray-100 p-3"><strong>No matching attendees found.</strong></span>
    </div>

    <AddAttendeesDialog
      :visible="addDialogVisible"
      :training-id="trainingId"
      :already-added-ids="attendees.map(a => a.id)"
      @close="addDialogVisible = false"
      @added="fetchAttendees"
    />
        <!-- Certificate Dialog -->
   <ViewAddCertificateDialog
      :closeOnEscape="true"
      :visible="certDialogVisible"
      :training-id="trainingId"
      :attendee-id="selectedAttendee"
      @update:visible="certDialogVisible = $event"
      @refresh="fetchAttendees"
    />

  </Drawer>
</template>

<script setup>
import { ref, watch, computed, onMounted, onBeforeUnmount } from 'vue';
import axios from 'axios';
import Drawer from 'primevue/drawer';
import Button from 'primevue/button';
import AddAttendeesDialog from './AddAttendeesDialog.vue';
import InputText from 'primevue/inputtext';
import ViewAddCertificateDialog from './ViewAddCertificateDialog.vue';

const searchQuery = ref('');
const props = defineProps({
  visible: Boolean,
  trainingId: Number
});
const emit = defineEmits(['close']);
const isVisible = ref(false);
const attendees = ref([]);
const loading = ref(false);
const addDialogVisible = ref(false);
const trainingName = ref('');
const allPersonInfos = ref([])           // All persons (from API)
const totalAttendees = computed(() => attendees.value.length);
const certDialogVisible = ref(false);
const selectedAttendee = ref(null);

// Fetch personInfos once (you can also move this to a shared composable)
const fetchPersonInfos = async () => {
  try {
    const res = await axios.get('/api/personinfos');
    allPersonInfos.value = Array.isArray(res.data) ? res.data : res.data.data;
    console.log("All Person Infos:", allPersonInfos.value);
  } catch (err) {
    console.error('Error fetching person infos', err);
  }
};

const fetchAttendees = async () => {
  try {
    const res = await axios.get(`/api/trainings/${props.trainingId}/attendees`);
    attendees.value = Array.isArray(res.data) ? res.data : res.data.data;
    console.log("Attendees:", attendees.value);
  } catch (err) {
    console.error('Error fetching attendees', err);
  }
};


// Get all unique genders from personInfos
const allGenders = computed(() => {
  const set = new Set()
  allPersonInfos.value.forEach(p => {
    const g = p.gender?.toLowerCase()?.trim()
    if (g) set.add(g)
  })
  return Array.from(set)
})

// Gender summary based on attendees
const genderSummary = computed(() => {
  const summary = {};

  // Initialize all known genders to 0
  allGenders.value.forEach(g => {
    summary[g.toLowerCase()] = 0;
  });

  // Count attendees by gender
  attendees.value.forEach(att => {
    const gender = att.gender?.toLowerCase()?.trim();
    if (gender && summary.hasOwnProperty(gender)) {
      summary[gender]++;
    }
  });

  return summary;
});

// Capitalize helper
const capitalize = str =>
  str.charAt(0).toUpperCase() + str.slice(1)

// Call it when component loads

const fetchTrainingName = async () => {
  try {
  const res = await axios.get(`/api/trainings/${props.trainingId}/training_title`);
  trainingName.value = res.data.training_title;
  } catch (err) {
    console.error('Failed to fetch training name', err);
    trainingName.value = '';
  }
};

const removeAttendee = async (personInfoId) => {
  const confirmed = window.confirm('Are you sure you want to remove this attendee?');
  if (!confirmed) return;

  try {
    await axios.delete(`/api/trainings/${props.trainingId}/attendees/${personInfoId}`);
    attendees.value = attendees.value.filter(a => a.id !== personInfoId);
  } catch (e) {
    console.error('Failed to remove attendee', e);
  }
};


const removeAllAttendees = async () => {
  if (!attendees.value.length) return;

  const confirmRemove = window.confirm('Are you sure you want to remove all attendees?');
  if (!confirmRemove) return;

  try {
    // Backend must support bulk delete
    await axios.delete(`/api/trainings/${props.trainingId}/attendees`);
    attendees.value = [];
  } catch (error) {
    console.error('Failed to remove all attendees', error);
  }
};

const filteredAttendees = computed(() => {
  if (!searchQuery.value) return attendees.value;

  return attendees.value.filter(att => {
    const fullName = `${att.firstname} ${att.middlename ?? ''} ${att.lastname}`.toLowerCase();
    return fullName.includes(searchQuery.value.toLowerCase());
  });
});

function openCertDialog(attId) {
  selectedAttendee.value = attId;
  certDialogVisible.value = true;
}


onMounted(() => {
  if (props.visible && props.trainingId) {
    fetchTrainingName();
    fetchAttendees();
    fetchPersonInfos();
  }
  console.log("All person infos:", allPersonInfos.value);
  console.log("Attendees list:", attendees.value);
  console.log("All Genders:", allGenders.value);
  console.log("Gender Summary:", genderSummary.value);
})

watch(() => props.visible, async (val) => {
  isVisible.value = val;
  if (val && props.trainingId) {
    loading.value = true;
    await Promise.all([
      fetchTrainingName(),
      fetchAttendees(),
      fetchPersonInfos()  // Make sure this is included here
    ]);
    loading.value = false;
  }
});

watch(isVisible, (val) => {
  if (!val) emit('close');
  selectedAttendee.value = null;
  searchQuery.value = null
});

function onKeyDown(e) {
  if (e.key === 'Escape') {
    if (certDialogVisible.value) {
      // Close the certificate dialog only
      certDialogVisible.value = false;

      // Prevent drawer from detecting Escape
      e.preventDefault();
      e.stopImmediatePropagation();
    } else {
      // No dialog open — let the drawer close normally
      isVisible.value = false;
    }
  }
}

onMounted(() => {
  window.addEventListener('keydown', onKeyDown, true);
});

onBeforeUnmount(() => {
  window.removeEventListener('keydown', onKeyDown, true);
});

/* // Compute gender counts dynamically
const genderSummary = computed(() => {
  const summary = {};

  attendees.value.forEach(att => {
    const gender = att.gender?.toLowerCase() || 'unknown';

    summary[gender] = (summary[gender] || 0) + 1;
  });

  return summary;
}); */
</script>