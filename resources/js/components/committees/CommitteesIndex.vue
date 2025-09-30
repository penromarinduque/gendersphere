<template>
    <div class="grid grid-cols-1 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-5 gap-4 mb-3">
        <div class="col-span-1">
            <h3 class="text-lg"><b>List of GADFPS Committees</b></h3>
        </div>
        <div class="col-span-4 flex justify-end gap-2">
            <Button size="small" variant="outlined" @click="showRsoDialog()">RSO</Button>
            <Button asChild v-slot="props" size="small">
                <router-link :to="{ name: 'committees.create' }" :class="props.class">Add New</router-link>
            </Button>
        </div>
    </div>

    <div class="mb-2">
        <Select @change="getByYear" v-model="selectedYear" :options="yearlist" optionLabel="year" optionValue="year"  placeholder="Filter by Year"  class="w-full md:w-56 mb-2 me-2" size="small" />
        <Select @change="filterCommittees" v-model="selectedEmpStatus" placeholder="Filter by Employement Status"  class="w-full md:w-56 mb-2 me-2" size="small" optionLabel="name" optionValue="value" :options="[{name: 'New', value: 'new'}, {name: 'Renewed', value: 'renewed'}, {name: 'All', value: 'all'}]" />
        <Select @change="filterCommittees" v-model="selectedGender" placeholder="Filter by Gender"  class="w-full md:w-56 mb-2 me-2" size="small" optionLabel="name" optionValue="value" :options="[{name: 'Male', value: 'male'}, {name: 'Female', value: 'female'}, {name: 'LGBTQIA+', value: 'lgbtqia+'}, {name: 'All', value: 'all'}]" />
    </div>

    <div class="mb-2">
        <Panel header="Summary">
            <div class="grid grid-cols-5">
                <div >
                    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">Permanent Employees</h6>
                    <p >Male : {{ committeeSummary.total_permanents_male }}</p>
                    <p >Female : {{ committeeSummary.total_permanents_female }}</p>
                    <p >LGBTQIA+ : {{ committeeSummary.total_permanents_lgbtqiaplus }}</p>
                </div>
                <div >
                    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">COS Employees</h6>
                    <p >Male : {{ committeeSummary.total_cos_male }}</p>
                    <p >Female : {{ committeeSummary.total_cos_female }}</p>
                    <p >LGBTQIA+ : {{ committeeSummary.total_cos_lgbtqiaplus }}</p>
                </div>
                <div>
                    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">Males</h6>
                    <p >Permanent : {{ committeeSummary.total_permanents_male }}</p>
                    <p >COS : {{ committeeSummary.total_cos_male }}</p>
                </div>
                <div>
                    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">Females</h6>
                    <p >Permanent : {{ committeeSummary.total_permanents_female }}</p>
                    <p >COS : {{ committeeSummary.total_cos_female }}</p>
                </div>
                <div>
                    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">LGBTQIA+</h6>
                    <p >Permanent : {{ committeeSummary.total_permanents_lgbtqiaplus }}</p>
                    <p >COS : {{ committeeSummary.total_cos_lgbtqiaplus }}</p>
                </div>
            </div>
        </Panel>
    </div>

    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
        <table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Year</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Name</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Position</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Gender</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Address</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Age</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actions</span>
                </th>
            </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-for="item in committees.data" :key="item.id">
                <tr class="bg-white">
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.year_covered }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.lastname+', '+item.firstname+' '+item.middlename+' ' }}</span><span v-if="item.extname!==null">{{ item.extname }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.position_title }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.gender }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.barangay_name+', '+item.municipality_name+', '+item.province_name }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        {{ computeAge(item.birthdate, item.year_covered) }}
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <router-link :to="{ name: 'committees.edit', params: { id: item.id } }"
                    class="inline-flex items-center mr-2 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">Edit</router-link> 
                        <button @click="deleteCommittee(item.id)"
                        class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                        Delete</button>
                    </td>
                </tr>
            </template>
            <tr v-if="committees.data && committees.data.length === 0">
                <td colspan="9" class="text-center border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">No records found</td>
            </tr>
            </tbody>
        </table>

        <div class="flex mt-3 place-content-end">
         <!-- <Paginator :rows="10" :totalRecords="120" :rowsPerPageOptions="[10, 20, 30]"></Paginator> -->
         <TailwindPagination :data="committees" @pagination-change-page="paginate" />
     </div>
    </div>

    <RSO :yearlist="yearlist" :rsoDialogVisible="rsoDialogVisible" @close="rsoDialogVisible = false"></RSO>

</template>

<script setup>
import { ref } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
import useCommittees from '@/composables/committees';
import Select from 'primevue/select';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import { onMounted } from 'vue';
import Panel from 'primevue/panel';
import usePersonInfos from '../../composables/personinfos';
import useAuth from '../../composables/auth';
import RSO from './RSO.vue';

const { committees, getCommittees, destroyCommittee, getCommitteeSummary, committeeSummary, getYearlist, yearlist, selectedYear } = useCommittees();
const { computeAge } = usePersonInfos();
const { user: authUser, getUser } = useAuth();

const selectedEmpStatus = ref('all');
const selectedGender= ref('all');

const rsoDialogVisible = ref(false);

const deleteCommittee = async (id) => {
    if (!window.confirm('You sure you want to delete this record?')) {
        return
    }
    
    await destroyCommittee(id);
    await getCommittees(1, selectedYear.value, selectedEmpStatus.value, selectedGender.value, authUser.value.office_id);
    // console.log(1);
}

const getByYear = async (event) => {
    let get_year = event.value;
    
    await getCommittees(1, get_year, selectedEmpStatus.value, selectedGender.value, authUser.value.office_id);
}

const filterCommittees = async () => {
    await getCommittees(1, selectedYear.value, selectedEmpStatus.value, selectedGender.value);
}

const paginate = async (page) => {
    await getCommittees(page, selectedYear.value, selectedEmpStatus.value);
}
const showRsoDialog = () => {
    rsoDialogVisible.value = true;
}

// We get the companies immediately
onMounted(async()=>{
    await getUser();
    await getCommittees(undefined, selectedYear.value, undefined, undefined, authUser.value.office_id);
    // console.log("committees : ", committees.value);
    getYearlist();
})

</script>