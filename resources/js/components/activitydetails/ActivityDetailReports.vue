

<template>
    <Drawer v-model:visible="movDialogVisible" position="right"  class="!w-full md:!w-80 lg:!w-[40rem]" header="Activity Report" @hide="onHide, $emit('close')">
       <Card title="Upload Report" class="mb-4">
        <template #title><h6>Upload Report</h6></template>
            <template #content>
                <span class="text-sm text-red-600" v-if="errors?.activity_detail_id">{{ errors.activity_detail_id[0] }}</span>
               <div class="mb-3">
                    <label for="">Select Report</label>
                    <InputText size="small" type="file" @change="reportChanged($event)" accept="application/pdf" class="w-full"  />
                    <span class="text-sm text-red-600" v-if="errors?.report">{{ errors.report[0] }}</span>
               </div>
               <div class="mb-3 flex justify-end">
                    <Button size="small" label="Upload" icon="pi pi-upload" class="p-button-primary" :loading="loading" @click="saveReport"></Button>
               </div>
            </template> 
       </Card>    

       <div class="">
        <DataView :value="activityDetailReports" class="p-2">
            <template #list="slotProps" class="p-2">
                <div v-for="(item, index) in slotProps.items" :key="index">
                    <div class="col-12 p-2">
                        <div class="p-2 border border-gray-200 flex justify-between align-items-center" >
                            <div class="self-center">
                                {{ item.file }}
                            </div>
                            <div class="flex gap-2">
                                <Button size="small"  label="Delete" variant="outlined" class="float-right self-start" :loading="loading">
                                    <a :href="`/api/activitydetailreports/${ item.id }`" target="_blank">View</a>
                                </Button>
                                <Button size="small" severity="danger" label="Delete" variant="outlined" class="float-right self-start" @click="confirmDelete(item.id)" :loading="loading"></Button>
                            </div>
                        </div>  
                    </div>
                </div>
            </template>
            <template #empty>
                <div class="p-3">No Reports found</div>
            </template>
        </DataView>
       </div>
    </Drawer>
</template>

<script setup>
    import { onMounted, reactive, ref, watch } from 'vue';
    import Drawer from 'primevue/drawer';
    import Card from 'primevue/card';
    import Button from 'primevue/button';
    import InputText from 'primevue/inputtext';
    import DataView from 'primevue/dataview';
    import useActivityDetailReports from '../../composables/activitydetailreports';
    import { useConfirm } from 'primevue';
    import { event } from 'jquery';

    const confirm = useConfirm();
    const { activityDetailReports, getActivityDetailReports, deleteActivityDetailReport, storeActivityDetailReport, errors } = useActivityDetailReports();
    const movDialogVisible = ref(false);
    const loading = ref(false);
    const addForm = reactive({
        activity_detail_id: '',
        report: ''
    });

    const confirmDelete = (id) => {
        confirm.require({
            message: 'Are you sure you want to delete this report?',
            header: 'Delete Report',
            icon: 'pi pi-info-circle',
            accept: async () => {
                // destroyActivityDetailReport(event);
                loading.value = true;
                const success = await deleteActivityDetailReport(id);
                loading.value = false;
            },
        });
    }
    const getReports = async () => {
        await getActivityDetailReports({activity_detail_id: props.activity_id});
    }
    const reportChanged = (e) => {
        addForm.report = e.target.files[0]; 
    }
    const saveReport = async () => {
        loading.value = true;
        const res = await storeActivityDetailReport(addForm);
        loading.value = false;
        getReports();
        if(res) {
            addForm.report = '';
        }
    }
    const props = defineProps({
        visible: {
            type: Boolean,
            default: false
        },
        activity_id: {
            type: Number,
            required: true
        }
    });
    watch(() => props.visible, (newVal) => {
        movDialogVisible.value = newVal;
    });
    watch(() => props.activity_id, (newVal) => {
        getReports();
        addForm.activity_detail_id = newVal;
    });
    function onHide() {
        movDialogVisible.value = false;
    }

</script>