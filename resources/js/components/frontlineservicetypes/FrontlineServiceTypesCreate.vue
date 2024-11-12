<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
        <div>
            <h3 class="text-lg"><b>Add New Frontline Service Type</b></h3>
        </div>
        <div class="flex mb-4 place-content-end">
            <button class="inline-flex items-center px-4 py-1 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-800 border border-transparent rounded-md hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-gray-300 disabled:opacity-25">
                <router-link :to="{ name: 'frontlineservicetypes.index' }" class="text-sm font-medium">Cancel</router-link>
            </button>
        </div>
    </div>
    <hr>
    <div class="py-4 px-4 mb-5 rounded-md shadow-md">
        <form class="space-y-6" @submit.prevent="saveFrontlineServiceType">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
                <div class="pb-1">
                    <label for="service" class="block text-md font-medium text-gray-700">Service</label>
                    <div class="mt-1">
                        <input type="text" name="service" id="service"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.service ">
                        <span class="text-sm text-red-600" v-if="errors?.service ">{{ errors.service[0] }}</span>
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
import useFrontlineServiceTypes from '../../composables/frontlineservicetypes'
import { reactive, onMounted } from 'vue'

const form = reactive({
    service: '',
})

const { errors, storeFrontlineServiceType } = useFrontlineServiceTypes()

const saveFrontlineServiceType  = async () => {
    await storeFrontlineServiceType({ ...form })
}
</script>