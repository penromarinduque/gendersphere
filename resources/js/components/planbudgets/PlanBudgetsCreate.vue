<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>Add New Plan and Budget</b></h3>
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
        <form class="space-y-6" @submit.prevent="savePlanBudget" autocomplete="off">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-5 gap-4">
                <div class="pb-1">
                    <label for="year" class="block text-md font-medium text-gray-700">Year Covered</label>
                    <div class="mt-1">
                        <select name="year" id="year" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="text-transform: capitalize;" v-model="form.year" @change="getGenderIssues($event)">
                            <option value="">-Select Year-</option>
                            <option v-for="item in yearlist" :key="item.year" :value="item.year">{{ item.year }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.year">{{ errors.year[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="focus" class="block text-md font-medium text-gray-700">Focus</label>
                    <div class="mt-1">
                        <select name="focus" id="focus" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.focus">
                            <option value="">-Select Focus-</option>
                            <option value="client">Client Focus</option>
                            <option value="organizational">Organizational Focus</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.focus">{{ errors.focus[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-3">
                    <label for="goal_id" class="block text-md font-medium text-gray-700">Goal</label>
                    <div class="mt-1">
                        <select name="goal_id" id="goal_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.goal_id">
                            <option value="">-Select Goal-</option>
                            <option v-for="item in goals" :key="item.id" :value="item.id">{{ item.goal_no+') '+item.gad_goal }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.goal_id">{{ errors.goal_id[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-4">
                <div class="pb-1 col-span-3">
                    <label for="gender_issue_id" class="block text-md font-medium text-gray-700">Gender Issue/GAD Mandate</label>
                    <div class="mt-1">
                        <select name="gender_issue_id" id="gender_issue_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.gender_issue_id">
                            <option value="">-Select Gender Issue/GAD Mandate-</option>
                            <option v-for="item in genderissuesbyyear" :key="item.id" :value="item.id">{{ item.gender_issue_mandate }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.gender_issue_id">{{ errors.gender_issue_id[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-4">
                <div class="pb-1">
                    <label for="cause_gender_issue_id" class="block text-md font-medium text-gray-700">Cause of Gender Issue</label>
                    <div class="mt-1">
                        <select name="cause_gender_issue_id" id="cause_gender_issue_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.cause_gender_issue_id">
                            <option value="">-Select Cause of Gender Issue-</option>
                            <option v-for="item in causegenderissues" :key="item.id" :value="item.id">{{ item.cause }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.cause_gender_issue_id">{{ errors.cause_gender_issue_id[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-4">
                <div class="pb-1">
                    <label for="objective_id" class="block text-md font-medium text-gray-700">GAD Result Statement/ GAD Objective</label>
                    <div class="mt-1">
                        <select name="objective_id" id="objective_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="form.objective_id">
                            <option value="">-Select GAD Result Statement/ GAD Objective-</option>
                            <option v-for="item in objectives" :key="item.id" :value="item.id">{{ item.gad_objective }}</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.objective_id">{{ errors.objective_id[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-4">
                <div class="pb-1">
                    <label for="relevant_org" class="block text-md font-medium text-gray-700">Relevant Organization MFO/PAP or PPA</label>
                    <div class="mt-1">
                        <input type="text" name="relevant_org" id="relevant_org" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.relevant_org">
                        <span class="text-sm text-red-600" v-if="errors?.relevant_org">{{ errors.relevant_org[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="float-right py-4">
                <div class="pb-1">
                    <button type="submit" class="inline-flex items-center px-4 py-2 ml-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-800 border border-transparent rounded-md ring-blue-300 hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring disabled:opacity-25">
                    SAVE
                </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import usePlanBudgets from '../../composables/planbudgets'
import useGoals from '../../composables/goals'
import useGenderIssues from '../../composables/genderissues'
import useCauseGenderIssues from '../../composables/causegenderissues'
import useObjectives from '../../composables/objectives'
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

const { errors, yearlist, getYearlist, storePlanBudget } = usePlanBudgets()
const { goals, getGoals } = useGoals()
const { genderissuesbyyear, getGenderIssuesByYear } = useGenderIssues()
const { causegenderissues, getCauseGenderIssues } = useCauseGenderIssues()
const { objectives, getObjectives } = useObjectives()

onMounted(getYearlist)
onMounted(getGoals)
onMounted(getCauseGenderIssues)
onMounted(getObjectives)

const savePlanBudget  = async () => {
    await storePlanBudget({ ...form })
}

const getGenderIssues = async (event) => {
    let year = event.target.value;
    console.log(year); 
    if (year!=="") {
        await getGenderIssuesByYear(year)
    }  
}
</script>