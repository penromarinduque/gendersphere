<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>Add New Committee Position</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'committeepositions.index' }" class="text-sm font-medium">Cancel</router-link>
            </button>
        </div>
    </div>
    <hr>
    <div class="py-4 px-4 mb-5 rounded-md shadow-md">
        <form class="space-y-6" @submit.prevent="saveCommitteePosition">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
                <div class="pb-1">
                    <label for="position_title " class="block text-md font-medium text-gray-700">Position Title</label>
                    <div class="mt-1">
                        <input type="text" name="position_title " id="position_title "
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.position_title ">
                        <span class="text-sm text-red-600" v-if="errors?.position_title ">{{ errors.position_title[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 pt-8">
                    <button type="submit" class="inline-flex items-center px-4 py-2 ml-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-800 border border-transparent rounded-md ring-blue-300 hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring disabled:opacity-25">
                    SAVE
                </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script setup>
import useCommitteePositions from '../../composables/committeepositions'
import { reactive, onMounted } from 'vue'

const form = reactive({
    position_title: '',
})

const { errors, storeCommitteePosition } = useCommitteePositions()

const saveCommitteePosition  = async () => {
    await storeCommitteePosition({ ...form })
}
</script>