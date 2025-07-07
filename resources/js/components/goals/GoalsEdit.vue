<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>Edit GAD Goal</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'goals.index' }" class="text-sm font-medium">Cancel</router-link>
            </button>
        </div>
    </div>
    <hr>
    <div class="py-4 px-4 mb-5 rounded-md shadow-md">
        <form class="space-y-6" @submit.prevent="editGoal">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-5 gap-4">
                <div class="pb-1">
                    <label for="goal_no" class="block text-md font-medium text-gray-700">Goal No. <span class="text-red-500">*</span><</label>
                    <div class="mt-1">
                        <input type="number" name="goal_no " id="goal_no "
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="goal.goal_no ">
                        <span class="text-sm text-red-600" v-if="errors?.goal_no ">{{ errors.goal_no[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-3">
                    <label for="gad_goal" class="block text-md font-medium text-gray-700">GAD Goal <span class="text-red-500">*</span><</label>
                    <div class="mt-1">
                        <textarea name="gad_goal" id="gad_goal" rows="4" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="goal.gad_goal"></textarea>
                        <span class="text-sm text-red-600" v-if="errors?.gad_goal">{{ errors.gad_goal[0] }}</span>
                    </div>
                </div>
                <div class="pb-1">
                    <label for="is_active_goal" class="block text-md font-medium text-gray-700">Status</label>
                    <div class="mt-1">
                        <select name="is_active_goal" id="is_active_goal" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        v-model="goal.is_active_goal">
                            <option value="">-Select Status-</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        <span class="text-sm text-red-600" v-if="errors?.is_active_goal">{{ errors.is_active_goal[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="py-4">
                <div class="pb-5 pt-0">
                    <button type="submit" class="inline-flex items-center px-4 py-2 ml-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-800 border border-transparent rounded-md ring-blue-300 hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring disabled:opacity-25 float-right">
                    SAVE CHANGES
                </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import useGoals from '../../composables/goals'
import { onMounted } from 'vue'

const { errors, goal, getGoal, updateGoal } = useGoals()

const props = defineProps({
    id: {
        required: true,
        type: String
    }
})

onMounted(() => getGoal(props.id))

const editGoal = async () => {
    await updateGoal(props.id)
}
</script>