<template>
  <div class="py-6">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="p-4 bg-white shadow sm:rounded-lg">

        <div class="mb-4">
          <h3 class="text-lg font-bold">Training Report</h3>
        </div>

        <div v-if="trainings.length > 0" class="overflow-x-auto">
          <table class="min-w-full text-sm border border-gray-300 divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Title</th>
                <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Date</th>
                <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Duration</th>
                <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Nature</th>
                <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Type</th>
                <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">GAD Related</th>
                <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Sponsor/Facilitator</th>
                <th class="px-4 py-2 text-center font-medium text-gray-700 border-r border-gray-300">Attendees</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <tr
                v-for="instance in trainings"
                :key="instance.id"
                class="border-b border-gray-300"
                >
                <td class="px-4 py-2 border-r border-gray-300">
                    {{ instance.training_title ? capitalizeFirstLetter(instance.training_title) : '-' }}
                </td>

                <td class="px-4 py-2 border-r border-gray-300">
                    {{ formatDate(instance.training_start) }} - {{ formatDate(instance.training_end) }}
                </td>

                <td class="px-4 py-2 border-r border-gray-300">
                    {{ parseInt(instance.duration_hours) }} hrs
                </td>

                <td class="px-4 py-2 border-r border-gray-300">
                    {{ instance.training_nature ? capitalizeFirstLetter(instance.training_nature) : '-' }}
                </td>

                <td class="px-4 py-2 border-r border-gray-300">
                    {{ instance.learning_description_type ? capitalizeFirstLetter(instance.learning_description_type) : '-' }}
                </td>

                <td class="px-4 py-2 border-r border-gray-300">
                    {{ instance.is_gad_related ? 'Yes' : 'No' }}
                </td>

                <td class="px-4 py-2 border-r border-gray-300">
                    {{ instance.sponsor_facilitator ? capitalizeFirstLetter(instance.sponsor_facilitator) : '-' }}
                </td>

                <td class="px-4 py-2">
                    {{ instance.attendees?.length ?? 0 }}
                </td>
                </tr>
            </tbody>
          </table>
        </div>

        <div v-else class="text-gray-600">
          No trainings found for the selected criteria.
        </div>

        <!-- Optional Pagination Placeholder -->
        <!--
        <div class="mt-4">
          <YourPaginationComponent :data="paginationData" @change="fetchTrainings" />
        </div>
        -->

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useCommonUtils } from '@/composables/commonutils';

const { capitalizeFirstLetter } = useCommonUtils()

const trainings = ref([])

const fetchTrainings = async () => {
  try {
    const response = await axios.get('/api/trainings')
    trainings.value = response.data.data || response.data
  } catch (error) {
    console.error('Error fetching trainings:', error)
  }
}

const formatDate = (dateStr) => {
  if (!dateStr) return '-'
  const options = { year: 'numeric', month: 'short', day: '2-digit' }
  return new Date(dateStr).toLocaleDateString(undefined, options)
}

onMounted(fetchTrainings)
</script>
