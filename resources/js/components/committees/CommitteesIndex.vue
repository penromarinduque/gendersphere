<template>
    <div class="grid grid-cols-1 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-5 gap-4 mb-3">
        <div class="col-span-1">
            <h3 class="text-lg"><b>List of GADFPS Committees</b></h3>
        </div>
        <div class="col-span-3">
            <div class="flex flex-no-wrap">
                <div class="w-auto flex-none px-2">
                    <div>
                        <select name="year" id="year" class="w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            v-on:change="getByYear"
                            v-model="selectedYear"
                        >
                            <option value="">-YEAR-</option>

                            <option v-for="year in years" :key="year" :value="year">{{year}}</option>
                            
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-1 flex mb-4 place-content-end">
            <button class="inline-flex items-center mr-1 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'committees.create' }" class="text-sm font-medium">Add New</router-link>
            </button>
        </div>
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
                        {{ item.age }}
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
            </tbody>
        </table>

        <div class="flex mt-3 place-content-end">
            <!-- <TailwindPagination
                :data="committees"
                @pagination-change-page="getCommittees"
            /> -->
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { TailwindPagination } from 'laravel-vue-pagination';
// Here we're using a Composable file, its code is above
import useCommittees from '@/composables/committees'

// onMounted will define what method to "fire" automatically
import { onMounted } from 'vue';

// We need only two things from the useCompanies() composable
const { committees, getCommittees, destroyCommittee } = useCommittees()

let curr_year = new Date().getFullYear()
const years = Array.from({length: 7}, (value, index) => curr_year - index)
// console.log(years)
const selectedYear = ref(curr_year)

const deleteCommittee = async (id) => {
    if (!window.confirm('You sure you want to delete this record?')) {
        return
    }
    
    await destroyCommittee(id)
    await getCommittees()
    // console.log(1);
}

const getByYear = async (event) => {
    let get_year = event.target.value;
    await getCommittees(1, get_year);
    // console.log(search_key);
}

// We get the companies immediately
onMounted(getCommittees)

</script>