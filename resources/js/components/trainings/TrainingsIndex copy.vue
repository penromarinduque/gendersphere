<template>
    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>List of Trainings</b></h3>
        </div>
        <div class="col-span-1">
            <div class="flex mb-4 place-content-end">                 
                <router-link :to="{ name: 'trainings.create' }" class="inline-flex items-center mr-2 px-4 py-1 text-s font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">
                    <i class="pi pi-plus mr-2"></i> Create Training
                </router-link>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <div class="mb-2">
  <!-- Year Filter -->
  <Select 
    v-model="filters.year" 
    :options="yearOptions" 
    optionLabel="label" 
    optionValue="value"
    placeholder="Filter by Year"
    size="small" 
    class="w-full md:w-56 me-2" 
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
    size="small" 
    class="w-full md:w-56 me-2" 
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
    size="small" 
    class="w-full md:w-56 me-2"
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
    size="small" 
    class="w-full md:w-56 me-2" 
    showClear 
    filter 
    @change="applyFilters"
  />

    <Select 
        v-model="filters.trainingNature" 
        :options="trainingNatureOptions" 
        optionLabel="label" 
        optionValue="value"
        placeholder="Filter by Nature"
        size="small" 
        class="w-full md:w-56 me-2"
        showClear 
        filter 
        @change="applyFilters"
    />
        <Button 
            label="Clear Filters" 
            size="small"
            class="p-button-outlined p-button-secondary w-full md:w-56 me-2" 
            :disabled="!Object.values(filters).some(val => val)" 
            @click="clearFilters"
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
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">To</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Number of Hours</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Type of LD (Managerial/Supervisory/Technical/etc)</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Sponsor/Facilitator</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Training Nature</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">GAD Related</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    Actions
                </th>
            </tr>
            </thead>
 
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-if="trainings.data && trainings.data.length">
                <template v-for="training in trainings.data" :key="training.id">
                    <tr class="bg-white whitespace-nowrap"> <!-- This applies no-wrap to the entire row -->
                        <td class="border border-slate-300 px-6 py-2 text-md text-center leading-5 text-gray-900 w-max ">
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
                            <span>{{ training.training_nature.charAt(0).toUpperCase() + training.training_nature.slice(1)}}</span>
                        </td>
                            <td class="border border-slate-300 px-6 py-2 text-md text-center leading-5 text-gray-900 w-max">
                            <span>{{ training.is_gad_related? 'Yes' : 'No' }}</span>
                        </td>
                        <td class="border border-slate-300 px-6 py-2 text-md text-center leading-5 text-gray-900 w-max">                              
                            <Button class="me-2" icon="pi pi-users" label="View Attendees" @click="openDrawer(training.id)" size="small" variant="outlined" severity="info"/>
                                <ViewAttendeesDrawer
                                :visible="attendeesDrawerVisible"
                                :trainingId="selectedTraining"
                                @close="attendeesDrawerVisible = false"
                                />
                            <Button class="me-2" icon="pi pi-pencil" label ="Edit" @click="$router.push({ name: 'trainings.edit', params: { id: training.id } })" size="small" variant="outlined" severity="primary"></Button>
                            <Button class="me-2" icon="pi pi-trash" label ="Delete" @click="handleDelete($event, training.id)" size="small" variant="outlined" severity="danger"></Button> <ConfirmPopup />
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
import Panel from 'primevue/panel';
import { onMounted, reactive, ref } from 'vue';
import ViewAttendeesDrawer from './ViewAttendeesDrawer.vue';
import axios from 'axios';
import 'primeicons/primeicons.css';

// Here we're using a Composable file, its code is above
import useTrainings from '@/composables/trainings'
import { useCommonUtils } from '@/composables/commonutils';

const { useConfirmDelete } = useCommonUtils();
const attendeesDrawerVisible = ref(false);
const selectedTraining = ref(null);

function openDrawer(training) {
  selectedTraining.value = training;
  attendeesDrawerVisible.value = true;
}
// We need only two things from the useCompanies() composable
const { trainings, getTrainings, destroyTraining, loading, trainingTypeFilter, getTrainingSummary, summary } = useTrainings();

const deleteTraining = async (id) => {
    await destroyTraining(id);
    await getTrainings();
    await getTrainingSummary();
    await fetchFilters();
    // console.log(1);
}

/* const searchkey = ref('');
const searchKey = async (event) => {
    let search_key = event.target.value;
    await getTrainings(1, search_key);
} */


// Reactive filter object
const filters = reactive({
  year: null,
  trainingTitle: null,
  employee: null,
  trainingType: null,
  trainingNature: null,
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
const trainingNatureOptions = ref([
  { label: 'Attended', value: 'attended' },
  { label: 'Conducted', value: 'conducted' }
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
    console.log('Employee list response:', employeeRes.data); 
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
    year: filters.year,
    title: filters.trainingTitle,
    employee_id: filters.employee,
    type: filters.trainingType,
    training_nature: filters.trainingNature,
  };

  await getTrainings(1, null, query); // Assuming you pass filters via 3rd param
};

const clearFilters = async () => {
  filters.year = null;
  filters.trainingTitle = null;
  filters.employee = null;
  filters.trainingType = null;
  filters.trainingNature = null;
  await getTrainings(); // reload data
};

onMounted(() => {
    getTrainings();
    getTrainingSummary();
    fetchFilters();
    
});

const { confirmDelete } = useConfirmDelete();

const handleDelete = (event, id) => {
  confirmDelete(event, id, deleteTraining, {
    message: 'Delete this item?',
    acceptLabel: 'Delete',
    rejectLabel: 'Cancel'
  });
};

/* const filterTrainings = async () => {
    console.log('Selected Type:', trainingTypeFilter.value);
    await getTrainings(1, trainingTypeFilter.value);
} */
    // We get the companies immediately
</script>