<template>
    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>List of Trainings</b></h3>
        </div>
        <div class="col-span-1">
            <div class="flex mb-4 place-content-end">                 
                <router-link :to="{ name: 'trainings.create' }" class="inline-flex items-center mr-2 px-4 py-1 text-s font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">
                    <i class="pi pi-plus mr-2"></i> Add Training
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
                :options="trainingTypes" 
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="col-span-full">
            <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">
            Training Type Summary
            </h6>
        </div>

        <div v-for="type in summary.by_training" :key="type.learning_description_type">
            <p class="text-sm">
            {{ capitalizeFirstLetter(type.learning_description_type) }}: 
            <b>{{ type.instance_count }}</b>
            </p>
        </div>

        <div class="col-span-full mt-2">
            <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">
            Total Trainings: {{ summary.total_instances }}
            </h6>
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
            <ViewAttendeesDrawer
                :visible="attendeesDrawerVisible"
                :trainingId="selectedTraining"
                @close="attendeesDrawerVisible = false"
            />            
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
                            <span>{{ training.learning_description_type.charAt(0).toUpperCase() + training.learning_description_type.slice(1) }}</span>
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
                            <Button class="me-2" icon="pi pi-pencil" label ="Edit" @click="$router.push({ name: 'trainings.edit', params: { id: training.id } })" size="small" variant="outlined" severity="primary"></Button>
                            <Button class="me-2" icon="pi pi-trash" label ="Delete" @click="handleDelete($event, training.id)" size="small" variant="outlined" severity="danger"></Button> <ConfirmPopup/>
                        </td>
                    </tr>
                </template>
            </template>
            <template v-else>
                <tr>
                    <td colspan="9" class="text-center text-gray-500 py-4">
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

const { capitalizeFirstLetter, confirmDelete } = useCommonUtils();
const attendeesDrawerVisible = ref(false);
const selectedTraining = ref(null);

function openDrawer(training) {
  selectedTraining.value = training;
  attendeesDrawerVisible.value = true;
}
// We need only two things from the useCompanies() composable
const { trainings, getTrainings, destroyTraining, getTrainingSummary, summary, yearOptions, 
        trainingTitleOptions, trainingNatureOptions, employeeOptions, trainingTypes, loadTrainingTypeOptions } = useTrainings();

const deleteTraining = async (id) => {
    await destroyTraining(id);
    await getTrainings();
    await getTrainingSummary();
    await fetchFilters();
    // console.log(1);
}

// Reactive filter object
const filters = reactive({
  year: null,
  trainingTitle: null,
  employee: null,
  trainingType: null,
  trainingNature: null,
});

// Fetch dynamic options
const fetchFilters = async () => {
  try {
    // Training Titles
    const trainingTitleRes = await axios.get('/api/traininglist');
    trainingTitleOptions.value = trainingTitleRes.data.data.map(t => ({
      label: t,
      value: t
    }));

    // Employees
    const employeeRes = await axios.get('/api/officeemployees');
    employeeOptions.value = employeeRes.data.data.map(emp => ({
      label: emp.name,
      value: emp.id
    }));
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
    loadTrainingTypeOptions();
});

const handleDelete = (event, id) => {
  confirmDelete(event, id, deleteTraining, {
    message: 'Delete this item?',
    acceptLabel: 'Delete',
    rejectLabel: 'Cancel'
  });
};

</script>