<template>
    <form class="space-y-6" @submit.prevent="editActivityDetailAccom">
        <div class="space-y-4 rounded-md">
            <h3><b>UPDATE GAD Activity Accomplishment: <u>{{ activitydetail.main_activity }}</u></b></h3>
            <hr>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 xl:grid-cols-6 gap-4">
                <div class="pb-1 col-span-3">
                    <label for="actual_result" class="block text-md font-medium text-gray-700">Actual Result<span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <!-- <textarea name="actual_result" id="actual_result" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="activitydetail.actual_result"></textarea> -->
                        <Editor v-model="activitydetail.actual_result" :init="{promotion: false, branding: false, license_key: 'gpl', height: '200px', skin: 'oxide', skin_url: 'default', menubar: false }" ></Editor>
                        <span class="text-sm text-red-600" v-if="errors?.actual_result">{{ errors.actual_result[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-1">
                    <label for="actual_men" class="block text-md font-medium text-gray-700">Actual Accomplished Men <small>(Put zero (0) if not available)</small></label>
                    <div class="mt-1">
                        <input type="text" name="actual_men" id="actual_men" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="activitydetail.actual_men">
                        <span class="text-sm text-red-600" v-if="errors?.actual_men">{{ errors.actual_men[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-1">
                    <label for="actual_women" class="block text-md font-medium text-gray-700">Actual Accomplished Women <small>(Put zero (0) if not available)</small></label>
                    <div class="mt-1">
                        <input type="text" name="actual_women" id="actual_women" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="activitydetail.actual_women">
                        <span class="text-sm text-red-600" v-if="errors?.actual_women">{{ errors.actual_women[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-1">
                    <label for="actual_lgbtq" class="block text-md font-medium text-gray-700">Actual Accomplished LGBTQ <small>(Put zero (0) if not available)</small></label>
                    <div class="mt-1">
                        <input type="text" name="actual_lgbtq" id="actual_lgbtq" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="activitydetail.actual_lgbtq">
                        <span class="text-sm text-red-600" v-if="errors?.actual_lgbtq">{{ errors.actual_lgbtq[0] }}</span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <div class="pb-1 col-span-1">
                    <label for="actual_cost" class="block text-md font-medium text-gray-700">Actual Cost<span class="text-red-500">*</span></label>
                    <div class="mt-1">
                        <input type="text" name="actual_cost" id="actual_cost" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" v-model="activitydetail.actual_cost">
                        <span class="text-sm text-red-600" v-if="errors?.actual_cost">{{ errors.actual_cost[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <label for="remarks" class="block text-md font-medium text-gray-700">Remarks</label>
                    <div class="mt-1">
                        <!-- <textarea name="remarks" id="remarks"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="activitydetail.remarks"></textarea> -->
                        <Editor v-model="activitydetail.remarks" :init="{promotion: false, branding: false, license_key: 'gpl', height: '200px', skin: 'oxide', skin_url: 'default', menubar: false }" ></Editor>
                        <span class="text-sm text-red-600" v-if="errors?.remarks">{{ errors.remarks[0] }}</span>
                    </div>
                </div>
                <div class="pb-1 col-span-2">
                    <!-- <label for="mov_file" class="block text-md font-medium text-gray-700">MOV File</label>
                    <div class="mt-1">
                        <input type="file" name="mov_file" id="mov_file" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" accept="image/*" ref="photo" v-onchange="activitydetail.mov_file">
                        <span class="text-sm text-red-600" v-if="errors?.mov_file">{{ errors.mov_file[0] }}</span>
                    </div> -->
                </div>
            </div>

            <!-- <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-6 gap-4">

            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

            </div> -->
        </div>
        <div class="float-right py-4">
            <button type="button" class="inline-flex items-center px-4 py-2 mr-5 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
                <router-link :to="{ name: 'activitydetails.index', params: { ga_id: props.ga_id } }" class="text-sm font-medium">Cancel</router-link>
            </button>
            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-800 border border-transparent rounded-md ring-indigo-300 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring disabled:opacity-25">
                UPDATE
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

const { errors, activitydetail, getActivityDetail, updateActivityDetailAccom } = useActivityDetails()

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

const editActivityDetailAccom = async () => {
    await updateActivityDetailAccom(props.id)
}

</script>