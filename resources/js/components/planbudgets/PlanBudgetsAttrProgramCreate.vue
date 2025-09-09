<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>Add New Attributed Program</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'planbudgets.index' }" class="text-sm font-medium">Back</router-link>
                <!-- <span class="text-sm font-medium">Back</span> -->
            </button>
        </div>
    </div>
    <hr>
    <div class="py-4 px-4 mb-5 rounded-md shadow-md">
        <form class="space-y-6" @submit.prevent="saveAttributedProgram" autocomplete="off">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                <div class="pb-1">
                    <label for="year" class="block text-md font-medium text-gray-700">Year Covered <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <select name="year" id="year" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="text-transform: capitalize;" v-model="form.year" @change="getGenderIssues($event)">
                            <option value="">-Select Year-</option>
                            <option v-for="item in yearlist" :key="item.year" :value="item.year">{{ item.year }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.year">{{ errors.year[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="focus" class="block text-md font-medium text-gray-700">Focus <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <select name="focus" id="focus" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.focus">
                            <option value="">-Select Focus-</option>
                            <option value="attributed program" selected>Attributed Program</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.focus">{{ errors.focus[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="program_name" class="block text-md font-medium text-gray-700">Program Name <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="program_name" id="program_name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.program_name">
                        <span class="text-sm text-red-600" v-if="errors?.program_name">{{ errors.program_name[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="budget" class="block text-md font-medium text-gray-700">Budget <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="budget" id="budget" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.budget">
                        <span class="text-sm text-red-600" v-if="errors?.budget">{{ errors.budget[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="percentage" class="block text-md font-medium text-gray-700">Percentage <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="number" step="0.01" name="percentage" id="percentage" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.percentage">
                        <span class="text-sm text-red-600" v-if="errors?.percentage">{{ errors.percentage[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="relevant_org" class="block text-md font-medium text-gray-700">Relevant Organization MFO/PAP or PPA <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="relevant_org" id="relevant_org" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.relevant_org">
                        <span class="text-sm text-red-600" v-if="errors?.relevant_org">{{ errors.relevant_org[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-4">
                
                
            </div>
            <div class="float-right py-4">
                <div class="pb-1">
                    <!-- <button type="submit" class="inline-flex items-center px-4 py-2 ml-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-800 border border-transparent rounded-md ring-blue-300 hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring disabled:opacity-25">
                        SAVE
                    </button> -->
                    <Button type="submit" label="SAVE" :loading="loading" size="small" />
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import Button from "primevue/button"
import usePlanBudgets from '../../composables/planbudgets'
import useGoals from '../../composables/goals'
import useGenderIssues from '../../composables/genderissues'
import useCauseGenderIssues from '../../composables/causegenderissues'
import useObjectives from '../../composables/objectives'
import useAuth from '../../composables/auth'
import { reactive, onMounted } from 'vue'

const form = reactive({
    year: '',
    focus: '',
    goal_id: '',
    gender_issue_id: '',
    cause_gender_issue_id: '',
    objective_id: '',
    relevant_org: '',
})

const { errors, yearlist, loading, getYearlist, storePlanBudget, storeAttributedProgram } = usePlanBudgets()
const { goals, getGoals } = useGoals()
const { genderissuesbyyear, getGenderIssuesByYear } = useGenderIssues()
const { causegenderissues, getCauseGenderIssues } = useCauseGenderIssues()
const { objectives, getObjectives } = useObjectives()
const { user:authUser, getUser } = useAuth();


onMounted(async()=>{
    await getUser();
    getYearlist()
    getGoals({
        office_id: authUser.value.office_id
    })
    getCauseGenderIssues({
        office_id: authUser.value.office_id
    })
    getObjectives({
        office_id: authUser.value.office_id
    })
})

const saveAttributedProgram = async () => {
    await storeAttributedProgram({ ...form })
}

const getGenderIssues = async (event) => {
    let year = event.target.value;
    console.log(year); 
    if (year!=="") {
        await getGenderIssuesByYear(year)
    }  
}
</script>