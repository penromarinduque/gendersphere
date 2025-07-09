<template>
    <form class="space-y-6" @submit.prevent="editActivityDetail">
        <div class="space-y-4 rounded-md">
            <h3><b>Edit ACTIVITY DETAIL - GAD Activity: <u>{{ activitydetail.main_activity }}</u></b></h3>
            <hr>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 xl:grid-cols-6 gap-4">
                <div class="pb-1 col-span-2">
                    <label for="sub_activity" class="block text-md font-medium text-gray-700">Sub Activity (Optional - If available only)</label>
                    <div class="mt-1">
                        <!-- <textarea name="sub_activity" id="sub_activity" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="activitydetail.sub_activity"></textarea> -->
                        <Editor v-model="activitydetail.sub_activity" :init="{promotion: false, branding: false, license_key: 'gpl', height: '200px', skin: 'oxide', skin_url: 'default', menubar: false }" ></Editor>
                        <span class="text-sm text-red-600" v-if="errors?.sub_activity">{{ errors.sub_activity[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="targets" class="block text-md font-medium text-gray-700">Targets<span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <!-- <textarea name="targets" id="targets" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="activitydetail.targets"></textarea> -->
                        <Editor v-model="activitydetail.targets" :init="{promotion: false, branding: false, license_key: 'gpl', height: '200px', skin: 'oxide', skin_url: 'default', menubar: false }" ></Editor>
                        <span class="text-sm text-red-600" v-if="errors?.targets">{{ errors.targets[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-1">
                    <label for="target_men" class="block text-md font-medium text-gray-700">Target Men <small>(Put zero (0) if not available)</small> <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="target_men" id="target_men" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="activitydetail.target_men">
                        <span class="text-sm text-red-600" v-if="errors?.target_men">{{ errors.target_men[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-1">
                    <label for="target_women" class="block text-md font-medium text-gray-700">Target Women <small>(Put zero (0) if not available)</small> <span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="target_women" id="target_women" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="activitydetail.target_women">
                        <span class="text-sm text-red-600" v-if="errors?.target_women">{{ errors.target_women[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <div class="pb-1 col-span-1">
                    <label for="gad_budget" class="block text-md font-medium text-gray-700">GAD Budget<span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="gad_budget" id="gad_budget" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="activitydetail.gad_budget">
                        <span class="text-sm text-red-600" v-if="errors?.gad_budget">{{ errors.gad_budget[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="responsible_unit" class="block text-md font-medium text-gray-700">Responsible Unit/Office<span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="responsible_unit" id="responsible_unit" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="activitydetail.responsible_unit">
                        <span class="text-sm text-red-600" v-if="errors?.responsible_unit">{{ errors.responsible_unit[0] }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-6 gap-4">

            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

            </div>
        </div>
        <div class="float-right py-4">
            <button type="button" class="inline-flex items-center px-4 py-2 mr-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                <router-link :to="{ name: 'activitydetails.index', params: { ga_id: props.ga_id } }" class="text-sm font-medium">Cancel</router-link>
            </button>
            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md ring-indigo-300 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring disabled:opacity-25">
                SAVE CHANGES
            </button>
        </div>
        
    </form>
</template>

<script setup>
import tinymce from 'tinymce';
import "tinymce/icons/default/icons.min.js";
import "tinymce/themes/silver/theme.min.js";
import "tinymce/models/dom/model.min.js";
import "tinymce/skins/ui/oxide/skin.js";
import "tinymce/skins/ui/oxide/content.js";
import "tinymce/skins/content/default/content.js";
import "tinymce/skins/ui/oxide/content.js";
import Editor from "@tinymce/tinymce-vue";

import useActivityDetails from '../../composables/activitydetails'
import { reactive, onMounted } from 'vue'

const { errors, activitydetail, getActivityDetail, updateActivityDetail } = useActivityDetails()

const props = defineProps({
    id: {
        required: true,
        type: String
    },
    ga_id: {
        required: true,
        type: String
    }
})

onMounted(() => getActivityDetail(props.id))

const editActivityDetail = async () => {
    await updateActivityDetail(props.id)
}

</script>