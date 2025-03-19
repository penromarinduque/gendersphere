<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>List of Frontline Services Records</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center mr-1 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'frontlineservices.create' }" class="text-sm font-medium">Add New</router-link>
            </button>
        </div>
    </div>
    
    <div>
        <Select @change="getFrontlineServices" v-model="selectedYear" :options="yearlist" optionLabel="year" optionValue="year"  placeholder="Filter Year"  class="w-full md:w-56 mb-2 me-2" size="small" />
        <Select @change="getFrontlineServices" v-model="selectedPermitType" :options="permittypes" optionLabel="permit_type" optionValue="id"  placeholder="Filter Permit Type" class="w-full md:w-56 mb-2" size="small" />
    </div>

    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">



        <table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Permit Type</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Permit No.</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Name of the Client</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Gender</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Address</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Date Applied/Received</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Date Approved/Released</span>
                </th>
                <th class="border border-slate-300 px-6 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actions</span>
                </th>
            </tr>
            </thead>
 
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-for="item in frontlineservices.data" :key="item.id">
                <tr class="bg-white">
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.service+' - '+item.permit_type }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.permit_no }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.client_name }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.gender }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.barangay_name+', '+item.municipality_name }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.date_applied }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.date_released }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <router-link :to="{ name: 'frontlineservices.edit', params: { id: item.id } }" class="inline-flex items-center mr-2 px-2 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">Edit</router-link> 
                        <button @click="deleteFrontlineService(item.id)" class="inline-flex items-center px-2 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                            Delete</button>
                    </td>
                </tr>
            </template>
            <tr v-if="!frontlineservices.length">
                <td colspan="9" class="text-center border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">No records found</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="flex mt-3 place-content-end">
         <!-- <Paginator :rows="10" :totalRecords="120" :rowsPerPageOptions="[10, 20, 30]"></Paginator> -->
         <TailwindPagination :data="frontlineservices" @pagination-change-page="getFrontlineServices" />
     </div>
</template>

<script setup>
import useFrontlineServices from '../../composables/frontlineservices';
import useFrontlineServiceTypes from '../../composables/frontlineservicetypes';
import usePermitTypes from '../../composables/permittypes';
import { onMounted } from 'vue'
import Select from 'primevue/select';
import Paginator from 'primevue/paginator';
import { TailwindPagination } from 'laravel-vue-pagination';

const { frontlineservices, selectedYear, yearlist, selectedPermitType, getFrontlineServices, destroyFrontlineService, getYearlist } = useFrontlineServices();
const { getFrontlineServiceTypes, frontlineservicetypes } = useFrontlineServiceTypes();
const { permittypes, getPermitTypes } = usePermitTypes();

const deleteFrontlineService = async (id) => {
    // console.log(id);
    if (!window.confirm('You sure you want to remove this Attendee from the list?')) {
        return
    }
    await destroyFrontlineService(id)
    await getFrontlineServices()
}

onMounted(() => {
    getFrontlineServices();
    getFrontlineServiceTypes();
    getYearlist();
    getPermitTypes();
});

</script>