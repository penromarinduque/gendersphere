<template>
    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>List of Trainings</b></h3>
        </div>
        <div class="col-span-1">
            <div class="flex mb-4 place-content-end">
                <button class="inline-flex items-center mr-2 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">
                    <router-link :to="{ name: 'trainings.create' }" class="text-sm font-medium">Create Training</router-link>
                </button>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
  <!-- Year Filter -->
  <Select 
    v-model="filters.year" 
    :options="yearOptions" 
    optionLabel="label" 
    optionValue="value"
    placeholder="Filter by Year"
    class="w-full" 
    showClear
    filter
    @change="applyFilters"
  />
  <!-- Training Title Filter -->
  <Select 
    v-model="filters.trainingTitle" 
    :options="trainingTitleOptions" 
    optionLabel="label" 
    optionValue="value"
    placeholder="Filter by Title"
    class="w-full" 
    showClear 
    filter 
    @change="applyFilters"
  />

  <!-- Employee Filter -->
  <Select 
    v-model="filters.employee" 
    :options="employeeOptions" 
    optionLabel="label" 
    optionValue="value"
    placeholder="Filter by Employee"
    class="w-full" 
    showClear 
    filter 
    @change="applyFilters"
  />

  <!-- Training Type Filter -->
  <Select 
    v-model="filters.trainingType" 
    :options="trainingTypeOptions" 
    optionLabel="label" 
    optionValue="value"
    placeholder="Filter by Type"
    class="w-full" 
    showClear 
    filter 
    @change="applyFilters"
  />
</div>
   </div>

    <div class="mb-2">
        <Panel header="Summary">
            <div class="grid grid-cols-3">
                <div >
                    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">Training Type</h6>
                    <p >Managerial: {{ summary.total_managerial }}</p>
                    <p >Supervisory : {{ summary.total_supervisory }}</p>
                    <p >Technical : {{ summary.total_technical }}</p>
                    <p >Foundation : {{ summary.total_foundation }}</p>
                </div>
                <div>
                    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">Total Trainings : {{ summary.total_trainings }}</h6>
                </div>
            </div>
        </Panel>
    </div>

    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
        <table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Title of Learning and Development Interventions/Training Programs (Write in full)</span>
                </th>
          <!--       <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Inclusive Dates of attendance (mm/dd/yyyy)</span>
                </th> -->
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">From</span>
                </th>
                <th class="border border-slate-300 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">To</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Number of Hours</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Type of LD (Managerial/Supervisory/Technical/etc)</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Conducted/Sponsored by (write in full)</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">Actions</th>
            </tr>
            </thead>
 
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-if="trainings.data && trainings.data.length">
                <template v-for="training in trainings.data" :key="training.id">
                    <tr class="bg-white whitespace-nowrap"> <!-- This applies no-wrap to the entire row -->
                        <td class="border border-slate-300 px-6 py-2 text-md text-center leading-5 text-gray-900 w-max">
                            <span class="capitalize">{{ training.training_title }}</span>
                        </td>
                        <td class="border border-slate-300 px-6 py-2 text-md text-center leading-5 text-gray-900 w-max">
                            <span class="capitalize">{{ training.training_start }}</span>
                        </td>
                        <td class="border border-slate-300 px-6 py-2 text-md text-center leading-5 text-gray-900 w-max">
                            <span class="capitalize">{{ training.training_end }}</span>
                        </td>
                        <td class="border border-slate-300 px-6 py-2 text-md text-center leading-5 text-gray-900 w-max">
                            <span>{{ training.duration_hours }}</span>
                        </td>
                        <td class="border border-slate-300 px-6 py-2 text-md text-center leading-5 text-gray-900 w-max">
                            <span>{{ training.learning_description_type }}</span>
                        </td>
                        <td class="border border-slate-300 px-6 py-2 text-md text-center leading-5 text-gray-900 w-max">
                            <span>{{ training.sponsor_facilitator }}</span>
                        </td>
                        <td class="border border-slate-300 px-6 py-2 text-md text-center leading-5 text-gray-900 w-max">                              
                            <Button class="me-2" label="View Attendees" @click="openDrawer(training.id)" size="small" variant="outlined" severity="info"/>
                                <ViewAttendeesDrawer
                                :visible="attendeesDrawerVisible"
                                :trainingId="selectedTraining"
                                @close="attendeesDrawerVisible = false"
                                />
                            <Button class="me-2" label ="Edit" @click="$router.push({ name: 'trainings.edit', params: { id: training.id } })" size="small" variant="outlined" severity="primary">Edit</Button>
                            <Button class="me-2" label ="Delete" @click="deleteTraining(training.id)" size="small" variant="outlined" severity="danger">Delete</Button>
                        </td>
                    </tr>
                </template>
            </template>
            <template v-else>
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-4">
                        No records found.
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
        <div class="flex mt-3 place-content-end">
            <TailwindPagination
                :data="trainings"
                @pagination-change-page="getTrainings"
            />
        </div>
    </div>
</template>

<script setup>
import Button from "primevue/button";
import { TailwindPagination } from 'laravel-vue-pagination';
import Select from 'primevue/select';
import InputText from 'primevue/inputtext';
import Panel from 'primevue/panel';
import { onMounted, reactive, ref } from 'vue';
import ViewAttendeesDrawer from './ViewAttendeesDrawer.vue';
import axios from 'axios';

// Here we're using a Composable file, its code is above
import useTrainings from '@/composables/trainings'

const attendeesDrawerVisible = ref(false);
const selectedTraining = ref(null);

function openDrawer(training) {
  selectedTraining.value = training;
  attendeesDrawerVisible.value = true;
}
// We need only two things from the useCompanies() composable
const { trainings, getTrainings, destroyTraining, loading, trainingTypeFilter, getTrainingSummary, summary } = useTrainings();

const deleteTraining = async (id) => {
    if (!window.confirm('You sure you want to delete this record?')) {
        return;
    }

    await destroyTraining(id);
    await getTrainings();
    // console.log(1);
}

/* const searchkey = ref('');
const searchKey = async (event) => {
    let search_key = event.target.value;
    await getTrainings(1, search_key);
} */


// Reactive filter object
const filters = ref({
  year: null,
  trainingTitle: null,
  employee: null,
  trainingType: null,
});

// Select options
const yearOptions = ref([]);
const trainingTitleOptions = ref([]);
const employeeOptions = ref([]);
const trainingTypeOptions = ref([
  { label: 'Managerial', value: 'managerial' },
  { label: 'Supervisory', value: 'supervisory' },
  { label: 'Technical', value: 'technical' },
  { label: 'Foundation', value: 'foundation' },
]);

// Fetch dynamic options
const fetchFilters = async () => {
  try {
    // Training Titles
    const trainingTitleRes = await axios.get('/api/traininglist');
    console.log(trainingTitleRes.data)
    trainingTitleOptions.value = trainingTitleRes.data.data.map(t => ({
      label: t,
      value: t
    }));
    console.log('Training list response:', trainingTitleRes.data); 

    // Employees
    const employeeRes = await axios.get('/api/employeedropdown');
    employeeOptions.value = employeeRes.data.data.map(emp => ({
      label: emp.name,
      value: emp.id
    }));
    console.log('Training list response:', employeeRes.data); 
    // Years (e.g., from 2020 to current year)
    const currentYear = new Date().getFullYear();
    yearOptions.value = Array.from({ length: 6 }, (_, i) => {
      const y = currentYear - i;
      return { label: y.toString(), value: y };
    });

  } catch (err) {
    console.error('Error loading filters', err);
  }
};

// Apply filters
const applyFilters = async () => {
  const query = {
    year: filters.value.year,
    title: filters.value.trainingTitle,
    employee_id: filters.value.employee,
    type: filters.value.trainingType
  };

  await getTrainings(1, null, query); // Assuming you pass filters via 3rd param
};

onMounted(() => {
    getTrainings();
    getTrainingSummary();
    fetchFilters();
});

/* const filterTrainings = async () => {
    console.log('Selected Type:', trainingTypeFilter.value);
    await getTrainings(1, trainingTypeFilter.value);
} */
    // We get the companies immediately
</script>