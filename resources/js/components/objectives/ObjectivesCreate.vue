<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>Add GAD Objective</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'objectives.index' }" class="text-sm font-medium">Cancel</router-link>
            </button>
        </div>
    </div>
    <hr>
    <div class="py-4 px-4 mb-5 rounded-md shadow-md">
        <form class="space-y-6" @submit.prevent="saveObjective">
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 gap-4">
                <div class="pb-1">
                    <label for="gad_objective" class="block text-md font-medium text-gray-700">GAD Result Statement/ GAD Objective</label>
                    <div class="mt-1">
                        <textarea name="cause" id="cause" rows="4" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.gad_objective"></textarea>
                        <span class="text-sm text-red-600" v-if="errors?.gad_objective">{{ errors.gad_objective[0] }}</span>
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
import useObjectives from '../../composables/objectives'
import { reactive, onMounted } from 'vue'

const form = reactive({
    gad_objective: '',
})

const { errors, storeObjective } = useObjectives()

const saveObjective  = async () => {
    await storeObjective({ ...form })
}
</script>