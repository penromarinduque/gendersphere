<template>
  <Dialog
    v-model:visible="isVisible"
    modal
    header="Add Attendees"
    :style="{ width: '30rem' }"
    @hide="emit('close')"
  >
    <div>
      <MultiSelect
        v-model="selectedUsers"
        :options="attendees"
        optionLabel="name"
        optionValue="id"
        placeholder="Select users"
        filter
        class="w-full"
      />
    </div>

    <template #footer>
      <Button label="Cancel" @click="emit('close')" severity="secondary" outlined />
      <Button label="Add" @click="addAttendees" :loading="loading" severity="success"/>
    </template>
  </Dialog>
</template>

<script setup>
import Dialog from 'primevue/dialog';
import MultiSelect from 'primevue/multiselect';
import Button from 'primevue/button';
import { ref, watch } from 'vue';
import axios from 'axios';
import { createToaster } from '@meforma/vue-toaster'

const props = defineProps({
  visible: Boolean,
  trainingId: {
    type: [Number],
    required: true
  },
  alreadyAddedIds: {
    type: Array,
    default: () => []
  },
});

const emit = defineEmits(['close', 'added']);

const isVisible = ref(false);
const attendees = ref([]);
const selectedUsers = ref([]);
const loading = ref(false);
const toaster = createToaster({ 
  position: "top"
        // max:
});

// Watch for dialog open
watch(() => props.visible, async (val) => {
  isVisible.value = val;
  if (val) {
    await fetchAttendees();
  }
});

// Close on hide
watch(isVisible, (val) => {
  if (!val) emit('close');
});

// Fetch all users and filter out those already added
const fetchAttendees = async () => {
  try {
    const res = await axios.get('/api/employeedropdown');
    const rawList = res.data?.data ?? res.data;

    const attendeeList = rawList.map(person => ({
      ...person,
      name: person.name // already combined by backend
    }));

    attendees.value = attendeeList.filter(
      attendee => !props.alreadyAddedIds.includes(attendee.id)
    );
  } catch (err) {
    console.error('Failed to load users', err);
  }
};

// Add attendees to the training
const addAttendees = async () => {

  if (!props.trainingId || selectedUsers.value.length === 0) {
    toaster.warning(`No users selected`);
    return;
  }

  try {
    loading.value = true;
    console.log("Selected person_info_ids:", selectedUsers.value);
    await axios.post(`/api/trainings/${props.trainingId}/attendees`, {
      person_info_ids: selectedUsers.value
    });   
    selectedUsers.value = []; // <- this clears the selection
    emit('added');  // parent can refresh attendees
    emit('close');
  } catch (err) {
    console.error('Failed to add attendees', err);
  } finally {
    loading.value = false;
  }
};
</script>
