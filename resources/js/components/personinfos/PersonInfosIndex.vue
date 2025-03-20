<template>
    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>List of Employees</b></h3>
        </div>
        <div class="col-span-1">
            <div class="flex mb-4 place-content-end">
                <button class="inline-flex items-center mr-2 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">
                    <router-link :to="{ name: 'personinfos.create' }" class="text-sm font-medium">Create Personal Info</router-link>
                </button>
                <a href="/committees" class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25">
                    <!-- <router-link :to="committees" class="text-sm font-medium">GAD Committees</router-link> --><span class="text-sm font-medium">GAD Committees</span>
                </a>
            </div>
        </div>
    </div>

    <div class="mb-2">
        <!-- <input type="text" class="block w-72 h-10 mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Enter key to search..." v-model="searchkey" v-on:keyup="searchKey"/> -->
        <InputText v-model="searchkey" v-on:keyup="searchKey" type="text" placeholder="Search Employee" size="small" class="w-full md:w-56 me-2" />
        <Select @change="filterEmployees" v-model="employmentStatusFilter" placeholder="Filter Employment Type" optionLabel="name" optionValue="value"  class="w-full md:w-56 mb-2 me-2" size="small" :options="[{name: 'COS', value: 'cos'}, {name: 'Permanent', value: 'permanent'}, {name: 'All', value: 'all'}]" />
        <Select @change="filterEmployees" v-model="genderFilter" placeholder="Filter Gender" class="w-full md:w-56 mb-2" size="small" optionLabel="name" optionValue="value" :options="[{name: 'Male', value: 'male'}, {name: 'Female', value: 'female'}, { name: 'LGBTQIA+', value: 'lgbtqia+'}, {name: 'All', value: 'all'}]" />
    </div>

    <div class="mb-2">
        <Panel header="Summary">
            <div class="grid grid-cols-3">
                <div >
                    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">Gender</h6>
                    <p >Male : {{ summary.total_males }}</p>
                    <p >Female : {{ summary.total_females }}</p>
                    <p >LGBTQIA+ : {{ summary.total_lgbtqiaplus }}</p>
                </div>
                <div>
                    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">Employment Type</h6>
                    <p >Permanent : {{ summary.total_permanents }}</p>
                    <p >COS : {{ summary.total_cos }}</p>
                </div>
                <div>
                    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">Total Employees : {{ summary.total_employees }}</h6>
                </div>
            </div>
        </Panel>
    </div>

    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
        <table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Name</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Gender</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Civil Status</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Birthdate</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Age</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Address</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Height</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Blood Type</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">Actions</th>
            </tr>
            </thead>
 
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-for="personinfo in personinfos.data" :key="personinfo.id">
                <tr class="bg-white">
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ personinfo.lastname+', '+personinfo.firstname+' '+personinfo.middlename+' ' }}</span><span v-if="personinfo.extname!==null">{{ personinfo.extname }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ personinfo.gender }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ personinfo.civil_status }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span>{{ personinfo.birthdate }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span>{{ personinfo.age }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span>{{ personinfo.barangay_name+', '+personinfo.municipality_name+', '+personinfo.province_name }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        {{ personinfo.height.toFixed(2) }}
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        {{ personinfo.blood_type }}
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <router-link :to="{ name: 'personinfos.edit', params: { id: personinfo.id } }" class="inline-flex items-center mr-2 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">Edit</router-link> 
                        
                        <button @click="deletePersonInfo(personinfo.id)"
                        class="inline-flex items-center mr-2 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                        Delete</button>

                        <!-- <Button @click="deletePersonInfo(personinfo.id)" type="submit" label="DELETE" :loading="loading" severity="danger" size="small" /> -->

                        <!-- <router-link :to="{ name: 'employeesalaries.index', params: { person_info_id: personinfo.id } }" class="inline-flex items-center mr-2 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25">Salary</router-link>  -->
                    </td>
                </tr>
            </template>
                <!-- <tr v-if="personinfos.data">
                    <td colspan="9" class="text-center text-red-600">No results found!</td>
                </tr> -->
            </tbody>
        </table>
        <div class="flex mt-3 place-content-end">
            <TailwindPagination
                :data="personinfos"
                @pagination-change-page="getPersonInfos"
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

// Here we're using a Composable file, its code is above
import usePersonInfos from '@/composables/personinfos'

// onMounted will define what method to "fire" automatically
import { onMounted } from 'vue';

// We need only two things from the useCompanies() composable
const { personinfos, getPersonInfos, destroyPersonInfo, loading, genderFilter, employmentStatusFilter, getPersonInfoSummary, summary } = usePersonInfos();

const deletePersonInfo = async (id) => {
    if (!window.confirm('You sure you want to delete this record?')) {
        return
    }
    
    await destroyPersonInfo(id);
    await getPersonInfos();
    // console.log(1);
}

const searchKey = async (event) => {
    let search_key = event.target.value;
    await getPersonInfos(1, search_key);
}

const filterEmployees = async () => {
    await getPersonInfos(1, "");
}

// We get the companies immediately
onMounted(() => {
    getPersonInfos()
    getPersonInfoSummary()
})

</script>