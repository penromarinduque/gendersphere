<template>
  <Dialog
    :visible="visible"
    @update:visible="emit('update:visible', $event)"
    modal
    :closeOnEscape="true"
    header="View Certificate"
    :style="{ width: '450px' }"
  >
    <!-- Outer Card Container -->
    <div class="border border-gray-200 rounded-2xl shadow-md bg-white overflow-hidden">

      <!-- Header -->
      <div class="bg-gray-100 border-b border-gray-200 px-6 py-4">
        <h2 class="text-lg font-semibold text-gray-700"> Certificate</h2>
      </div>

      <!-- Main Content Area -->
      <div class="p-4">
        <!-- Loading State -->
        <template v-if="loading">
          <div class="flex flex-col items-center justify-center h-48 border border-blue-200 rounded-xl bg-blue-50 shadow-inner">
            <svg class="animate-spin h-6 w-6 text-blue-400 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
            </svg>
            <p class="text-blue-600 text-sm font-medium">Loading certificate...</p>
          </div>
        </template>

        <!-- Certificate Exists -->
        <template v-else-if="certUrl">
          <div class="border border-gray-200 rounded-2xl p-4 bg-white shadow-sm hover:shadow-md transition">
            <img
              :src="certUrl"
              alt="Certificate"
              class="w-full rounded-xl shadow border border-gray-100 mb-4"
            />
          </div>
          <div class="text-right p-4">
            <Button
              icon="pi pi-trash"
              label="Delete Certificate"
              severity="danger"
              class="w-full md:w-auto"
              @click="deleteCertificate"
            />
          </div>
        </template>

        <!-- No Certificate, Upload UI -->
        <template v-else-if="certificateChecked">
          <p class="text-gray-600 text-sm font-medium text-center">No certificate found.</p>
          <div
            class="rounded-2xl border-2 border-dashed border-gray-300 p-6 bg-white hover:border-primary-500 hover:bg-gray-50 transition cursor-pointer shadow-sm"
          > 
            <div class="flex flex-col items-center justify-center space-y-4 text-center">
              <label
                for="certificate-upload"
                class="w-full flex flex-col items-center justify-center"
              >
                <svg
                  class="w-12 h-12 mb-2 text-gray-400"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="1.5"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 16.5V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18v-1.5M16.5 12l-4.5-4.5m0 0L7.5 12m4.5-4.5V18"
                  />
                </svg>
                <p class="text-sm text-gray-700">
                  <span class="font-semibold text-primary-600">Click to upload</span> or drag and drop
                </p>
                <p class="text-xs text-gray-500">PNG, JPG up to 5MB</p>
                <input
                  id="certificate-upload"
                  type="file"
                  accept="image/*"
                  @change="uploadCertificate"
                  class="hidden"
                />
              </label>
            </div>
          </div>
        </template>
        
                <!-- Uploading -->
        <template v-else-if="uploading">
          <div class="flex flex-col items-center justify-center h-48 border border-yellow-200 rounded-xl bg-yellow-50 shadow-inner">
            <svg class="animate-spin h-6 w-6 text-yellow-500 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
            </svg>
            <p class="text-yellow-600 text-sm font-medium">Uploading certificate...</p>
          </div>
        </template>
      </div>
    </div>
  </Dialog>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from 'vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import axios from 'axios';

const props = defineProps({
  visible: Boolean,
  trainingId: Number,
  attendeeId: Number,
});
const emit = defineEmits(['update:visible', 'refresh']);
const certUrl = ref(null);
const loading = ref(false);
const certificateChecked = ref(false); 
const uploading = ref(false);

// Fetch certificate URL when dialog opens
watch(() => props.visible, async (isOpen) => {
  if (isOpen && props.attendeeId) {
    loading.value = true;
    certUrl.value = null;
    certificateChecked.value = false;
    try {
      const res = await axios.get(`/api/trainings/${props.trainingId}/certificate/${props.attendeeId}`);
      certUrl.value = res.data?.url ?? null;
    } catch {
      certUrl.value = null;
    } finally {
      loading.value = false;
      certificateChecked.value = true;
    }
  }
  
  if (!isOpen) {
    certUrl.value = null; //Clear content when dialog is closed
    certificateChecked.value = false;
  }
});

const uploadCertificate = async (e) => {
  const file = e.target.files[0];
  if (!file || !props.attendeeId) return;
  const fd = new FormData();
  fd.append('certificate', file);

  const uploading = ref(true);

  try {
    await axios.post(`/api/trainings/${props.trainingId}/certificate/${props.attendeeId}`, fd);
    emit('refresh'); // Tell parent to refresh state
    const res = await axios.get(`/api/trainings/${props.trainingId}/certificate/${props.attendeeId}`);
    certUrl.value = res.data?.url ?? null;
  } catch (err) {
    console.error('Upload failed:', err);
  } finally {
    uploading.value = false;
  }
};

const deleteCertificate = async () => {
  try {
    await axios.delete(`/api/trainings/${props.trainingId}/certificate/${props.attendeeId}`);
    certUrl.value = null;
    emit('refresh');
  } catch (err) {
    console.error('Delete failed:', err);
  }
};

</script>
