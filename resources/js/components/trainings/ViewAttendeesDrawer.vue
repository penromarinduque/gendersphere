<template>
  <Drawer
    v-model:visible="isVisible"
    position="right"
    :header= "trainingName"
    class="!w-full md:!w-80 lg:!w-[30rem]"
    @hide="emit('close')"
  >
  <div class="flex justify-between items-center mb-1 border">
    <div class="text-2xl font-bold text-gray-800"> Attendees     
      <div class="mt-4">
        <h3 class="text-lg font-bold mt-4">Gender Summary</h3>
        <ul class="grid grid-cols-3 gap-y-1 gap-x-4 ml-5 text-sm text-gray-700">
          <li v-for="gender in allGenders" :key="gender">
            {{ capitalize(gender) }}: {{ genderSummary[gender] ?? 0 }}
          </li>
          <li>
            Total: {{ totalAttendees }}
          </li>
        </ul>
      </div>
    </div> 
    <Button label="Add Attendees" @click="addDialogVisible = true" />
  </div> 
  <div v-if="loading">Loading attendees...</div>
    <div v-else-if="attendees.length">
      <ul class="space-y-0.5">
        <li v-for="attendee in attendees" :key="attendee.id" class=" border rounded flex justify-between  items-center">
          <div>
            <strong>
              {{ attendee.firstname }} 
              {{ attendee.middlename ? attendee.middlename + ' ' : '' }}
              {{ attendee.lastname }}
            </strong><br />

          </div>
          <Button
            severity="danger"
            @click="removeAttendee(attendee.id)"
            size="small"
            label="Remove"
            class="max-h-[20px] max-w-[80px] text-center"
          />  
        </li>
      </ul>
    </div>
    <div v-else class="text-gray-500">No attendees found.</div>

    <AddAttendeesDialog
    :visible="addDialogVisible"
    :training-id="trainingId"
    :already-added-ids="attendees.map(a => a.id)"
    @close="addDialogVisible = false"
    @added="fetchAttendees"
    />
  </Drawer>
</template>

<script setup>
import { ref, watch, computed, onMounted } from 'vue';
import axios from 'axios';
import Drawer from 'primevue/drawer';
import Button from 'primevue/button';
import AddAttendeesDialog from './AddAttendeesDialog.vue';

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
const removeAttendee = async (personInfoId) => {
  try {
    await axios.delete(`/api/trainings/${props.trainingId}/attendees/${personInfoId}`);
    attendees.value = attendees.value.filter(a => a.id !== personInfoId);
  } catch (e) {
    console.error('Failed to remove attendee', e);
  }
};

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
});

const fetchTrainingName = async () => {
  try {
  const res = await axios.get(`/api/trainings/${props.trainingId}/training_title`);
  trainingName.value = res.data.training_title;
  } catch (err) {
    console.error('Failed to fetch training name', err);
    trainingName.value = '';
  }
};

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
