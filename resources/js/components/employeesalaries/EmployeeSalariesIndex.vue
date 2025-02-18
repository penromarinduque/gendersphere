<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>Salary of: <span style="text-transform: uppercase;">{{ personinfo.lastname+', '+personinfo.firstname+' '+personinfo.middlename+' ' }}</span><span v-if="personinfo.extname!==null">{{ personinfo.extname }}</span></b> </h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center h-8 mr-1 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'employeesalaries.create' }" class="text-sm font-medium">Add New Salary</router-link>
            </button>
            <button class="inline-flex items-center h-8 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'personinfos.index' }" class="text-sm font-medium">Back</router-link>
            </button>
        </div>
    </div>
    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
        <table class="min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Year</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Salary</span>
                </th>
                <th class="border border-slate-300 px-6 py-1 bg-gray-50">Actions</th>
            </tr>
            </thead>
 
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-for="employeesalary in employeesalaries.data" :key="employeesalary.id">
                <tr class="bg-white">

                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span>{{ employeesalary.salary_year }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span>{{ employeesalary.amount }}</span>
                    </td>
                    <td class="border border-slate-300 px-6 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <router-link :to="{ name: 'employeesalaries.edit', params: { id: employeesalary.id } }" class="inline-flex items-center mr-2 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">Edit</router-link> 
                        
                        <button @click="deleteEmployeeSalary(employeesalary.id)"
                        class="inline-flex items-center mr-2 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                        Delete</button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div> 
</template>
<script setup>
import usePersonInfos from '../../composables/personinfos';
import useEmployeeSalaries from '../../composables/employeesalaries';
import { onMounted } from 'vue'

const { personinfo, getPersonInfo } = usePersonInfos()
const { employeesalaries, getEmployeeSalaries } = useEmployeeSalaries()

const props = defineProps({
    person_info_id: {
        required: true,
        type: String
    }
})

onMounted(() => getPersonInfo(props.person_info_id))
onMounted(() => getEmployeeSalaries(props.person_info_id))

const deleteEmployeeSalary = async (id) => {

}

</script>