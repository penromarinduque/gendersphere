<template>
    <div class="grid grid-cols-1 md:grid-cols-5 lg:grid-cols-5 xl:grid-cols-5 gap-4 mb-3">
        <div class="col-span-1">
            <h3 class="text-lg"><b>List of GAD Plan and Budget </b></h3>
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
                <router-link :to="{ name: 'planbudgets.create' }" class="text-sm font-medium">Add New</router-link>
            </button>
        </div>
    </div>
    <div class="min-w-full overflow-hidden overflow-x-auto align-middle sm:rounded-md">
        <table class="hover:table-auto min-w-full w-full border-collapse border border-slate-400 divide-y divide-gray-200">
            <thead>
            <tr>
                <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Year</span>
                </th>
                <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Focus</span>
                </th>
                <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Gender Issue/GAD Mandate</span>
                </th>
                <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Cause of Gender Issue</span>
                </th>
                <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">GAD Result Statement/ GAD Objective</span>
                </th>
                <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Relevant Organization MFO/PAP or PPA</span>
                </th>
                <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">GAD Activity</span>
                </th>
                <th class="border border-slate-300 px-2 py-2 bg-gray-50">
                    <span class="text-sm font-medium leading-4 tracking-wider text-left text-gray-700 uppercase">Actions</span>
                </th>
            </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <template v-for="item in planbudgets" :key="item.id">
                <tr class="align-text-top bg-white odd:bg-white even:bg-slate-50">
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.year }}</span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span style="text-transform: capitalize;">{{ item.focus }}</span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span>{{ item.gender_issue_mandate }}</span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span>{{ item.cause_gender_issue }}</span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span>{{ item.gad_objective }}</span>
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span>{{ item.relevant_org }}</span>
                    </td>
                    <td class="border border-slate-300 px-5 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <span v-if="item.gad_activities.length==0" class="text-red-500">No activity/ies added yet</span>
                        <ol class="list-decimal">
                            <template v-for="item_ga in item.gad_activities">
                                <li>
                                    <router-link :to="{ name: 'activitydetails.index', params: { ga_id: item_ga.id } }" title="VIEW DETAILS"><span>{{ item_ga.main_activity }}</span></router-link>
                                </li>
                            </template>
                        </ol>
                        <br>
                        <!-- <router-link :to="{ name: 'gadactivities.create', params: { planbudget_id: item.id } }" class="inline-flex items-center mr-2 px-1 py-0 text-lg font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25"><span title="Add Activity">+</span></router-link> -->
                        <button @click="openModal(), putId($event)"
                        class="inline-flex items-center mr-2 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 float-end" :value="item.id">
                        Add</button> 
                    </td>
                    <td class="border border-slate-300 px-2 py-2 text-md leading-5 text-gray-900 whitespace-no-wrap">
                        <router-link :to="{ name: 'planbudgets.edit', params: { id: item.id } }" class="inline-flex items-center mr-2 px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-gray-300 disabled:opacity-25">Edit</router-link> 
                        <button @click="deletePlanBudget(item.id)"
                        class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                        Delete</button>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>

    <BaseModal :isOpen="isModalOpened" @modal-close="closeModal" name="first-modal">
        <template #header><h4 class="text-lg">Add GAD Activity</h4></template>
        <template #content>
            <div class="py-4 px-4 rounded-md shadow-md">
                <form class="space-y-6" @submit.prevent="saveActivity">
                    <div class="pb-1 col-span-2">
                        <label for="main_activity" class="block text-md font-medium text-gray-700">GAD Activity</label>
                        <div class="mt-1">
                            <textarea name="main_activity" id="main_activity"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="form.main_activity" rows="5"></textarea>
                            <span class="text-sm text-red-600" v-if="errors?.main_activity">{{ errors.main_activity[0] }}</span>
                        </div>
                    </div>
                    <div class="pb-9">
                        <div class="float-right">
                            <input type="hidden" name="plan_budget_id" id="plan_budget_id" v-model="form.plan_budget_id" />
                            <button type="button" class="inline-flex items-center px-4 py-2 ml-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md ring-red-300 hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring disabled:opacity-25" @click="closeModal">Cancel</button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 ml-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-800 border border-transparent rounded-md ring-blue-300 hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring disabled:opacity-25">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </template>
    </BaseModal>
</template>

<script setup>
// Here we're using a Composable file, its code is above
import usePlanBudgets from '@/composables/planbudgets'
import useGadActivities from '@/composables/gadactivities'
import BaseModal from '@/components/modals/BaseModal.vue'

// onMounted will define what method to "fire" automatically
import { onMounted, ref, reactive } from 'vue';

// We need only two things from the useCompanies() composable
const { planbudgets, getPlanBudgets, destroyPlanBudget } = usePlanBudgets()
const { errors, planbudget_id, isModalOpened, storeGadActivity, putPlanBudgetId, openModal, closeModal } = useGadActivities()

const form = reactive({
    main_activity: '',
    plan_budget_id: planbudget_id,
})

const deletePlanBudget = async (id) => {
    if (!window.confirm('You sure you want to delete this record?')) {
        return
    }
    
    await destroyPlanBudget(id)
    await getPlanBudgets()
    // console.log(1);
}

// We get the companies immediately
onMounted(getPlanBudgets)

const saveActivity = async () => {
    await storeGadActivity({ ...form })
}

const putId = async (event) => {
    let pb_id = event.target.value;
    // console.log(pb_id)
    putPlanBudgetId(pb_id)
}
</script>