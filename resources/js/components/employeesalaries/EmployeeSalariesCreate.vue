<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>Add Gender Issue/ GAD Mandate</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'employeesalaries.index', params: { person_info_id: $props.person_info_id } }" class="text-sm font-medium">Cancel</router-link>
            </button>
        </div>
    </div>
    <hr>
    <div class="py-4 px-4 mb-5 rounded-md shadow-md">
        <form class="space-y-6" @submit.prevent="saveEmployeeSalary">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="salary_year" class="block text-md font-medium text-gray-700">Year</label>
                    <div class="mt-1">
                        <select name="salary_year" id="salary_year" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="text-transform: capitalize;" v-model="form.salary_year">
                            <option value="">-Select Year-</option>
                            <option v-for="item in yearlist" :key="item.id" :value="item.year">{{ item.year }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.salary_year">{{ errors.salary_year[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="gender_issue_mandate" class="block text-md font-medium text-gray-700">Amount</label>
                    <div class="mt-1">
                        <input type="text" name="amount " id="amount "
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.amount ">
                        <span class="text-sm text-red-600" v-if="errors?.amount ">{{ errors.amount[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="py-4">
                <div class="pb-5 pt-0">
                    <button type="submit" class="inline-flex items-center px-4 py-2 ml-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-800 border border-transparent rounded-md ring-blue-300 hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring disabled:opacity-25 float-right">
                    SAVE
                </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script setup>
import useGenderIssues from '../../composables/genderissues'
import usePersonInfos from '../../composables/personinfos';
import useEmployeeSalaries from '../../composables/employeesalaries';
import { reactive, onMounted } from 'vue'

const props = defineProps({
    person_info_id: {
        required: true,
        type: String
    }
})

const form = reactive({
    salary_year: '',
    amount: '',
    person_info_id: props.person_info_id
})

const { yearlist, getYearlist } = useGenderIssues()
const { errors, storeEmployeeSalary } = useEmployeeSalaries()
onMounted(getYearlist)

const saveEmployeeSalary  = async () => {
    await storeEmployeeSalary({ ...form })
}
</script>