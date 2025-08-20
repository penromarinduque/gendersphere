<template>
    <!-- RSO PANEL -->
     
    <Dialog class="bg-slate-700" header="Committee RSO" v-model:visible="isVisible" modal :style="{ maxWidth: '700px', width: '100%' }" @hide="$emit('close')"> 
        <div class="mb-2">
            <label for="">Select Year</label>
            <Select class="w-full" v-model="uploadRsoForm.year"  :options="yearlist" option-label="year" option-value="year" placeholder="Select Year" ></Select>
            <span class="text-sm text-red-600" v-if="errors?.year">{{ errors.year[0] }}</span>
        </div>
        <div class="card ">
            <Tabs value="0" class="mb-4 ">
                <TabList>
                    <Tab value="0">View RSO</Tab>
                    <Tab value="1">Upload RSO</Tab>
                </TabList>
                <TabPanels>
                    <TabPanel value="0">
                        <div class="" v-if="uploadRsoForm.year">
                            <Button class="mx-auto" variant="link">
                                <a  :href="`./api/committee_rso_attachments/view/${ uploadRsoForm.year }`" target="_blank"><i class="pi pi-external-link me-2"></i> View RSO for {{ uploadRsoForm.year }}</a>
                            </Button>
                        </div>
                        <p v-if="!uploadRsoForm.year" class="text-sm text-muted-color text-center">Please select a year</p>
                    </TabPanel>
                    <TabPanel value="1">
                        <div class="mb-3">
                            <label for="">Select RSO</label>
                            <InputText type="file" accept="application/pdf" class="w-full mb-2" placeholder="Upload RSO Document" @change="rsoChanged($event)" />
                            <span class="text-sm text-red-600" v-if="errors?.rso">{{ errors.rso[0] }}</span>
                        </div>
                        <div class="flex justify-end">
                            <Button label="Upload" icon="pi pi-upload" class="p-button-success" @click="uploadRso" :loading="loading" ></Button>   
                        </div>
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </div>
    </Dialog>

</template>

<script setup>
import { reactive, ref, watch } from 'vue';
import Panel from 'primevue/panel';
import Dialog from 'primevue/dialog';
import Select from 'primevue/select';
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';
import FileUpload from 'primevue/fileupload';
import { InputText } from 'primevue';
import Button from 'primevue/button';
import useCommittees from '../../composables/committees';

const props = defineProps({
    yearlist: {
        type: Array,
        required: true
    },
    rsoDialogVisible: {
        type: Boolean,
        default: false
    }
});
const { errors, uploadRso : uploadRsoApi, loading } = useCommittees(); 
const isVisible = ref(false);
const uploadRsoForm = reactive({
    rso : null,
    year : null
});
watch(() => props.rsoDialogVisible, (newVal) => {
    console.log("RSO Dialog visibility changed: ", newVal);
    isVisible.value = newVal;
});



const uploadRso = async() => {
    await uploadRsoApi(uploadRsoForm);
    if (!errors.value) {
        isVisible.value = false;
    }
};

const setYear = (event) => {
    uploadRsoForm.year = event.value;
};

const rsoChanged = (event) => {
    const file = event.target.files[0];
    console.log("Selected file: ", file);
    if (file) {
        uploadRsoForm.rso = file;
    } else {
        uploadRsoForm.rso = null;
    }
};

</script>