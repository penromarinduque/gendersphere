<template>
    <App />
    <h1 class="text-2xl font-extrabold">Office List</h1>
    <div class="grid justify-items-end mb-3 ">
        <Button asChild label="Create" icon="pi pi-plus" class="p-button-success" v-slot="props" size="small">
            <router-link :to="{ name: 'offices.create' }" :class="props.class"><i class="pi pi-plus"></i> Create Office</router-link>
        </Button>
    </div>
    
    <DataTable :value="offices" responsiveLayout="scroll" showGridlines :loading="loading">
        <Column field="office_name" header="Office Name"></Column>
        <Column field="office_type" header="Office Type" >
            <template #body="slotProps" class="text-center">
                <Tag :severity="slotProps.data.office_type.toUpperCase() == 'REGION' ? 'success' : 'warning'" :value="slotProps.data.office_type.toUpperCase()"></Tag>
            </template>
        </Column>
        <Column field="region.region_name" header="Region">
            <template #body="slotProps" class="text-center">
                {{ slotProps.data.region ? slotProps.data.region.region_name : 'N/A' }}
            </template>
        </Column>    
        <Column field="parent.office_name" header="Parent Office">
            <template #body="slotProps" class="text-center">
                {{ slotProps.data.parent ? slotProps.data.parent.office_name : 'N/A' }}
            </template>
        </Column>
        <Column field="parent.barangay_id" header="Address">
            <template #body="slotProps" class="text-center">
                {{ `${slotProps.data.barangay.barangay_name}, ${slotProps.data.barangay.municipality.municipality_name}, ${slotProps.data.barangay.municipality.province.province_name}` }}
            </template>
        </Column>
        <Column field="id"  header="Actions" >
            <template #body="slotProps" >
                <Button asChild v-slot="props" size="small"  variant="outlined" :loading="loading">
                    <router-link :class="props.class" :to="{ name: 'offices.edit', params: { id: slotProps.data.id } }" ><i class="pi pi-pencil"></i> Edit</router-link>
                </Button>
                &nbsp;
                <Button :loading="loading" size="small" label="Delete" icon="pi pi-trash" severity="danger" variant="outlined" @click="onDelete($event, slotProps.data.id)"></Button>
            </template>
        </Column>
    </DataTable>
</template>

<script setup>
    import Button from "primevue/button";
    import DataTable from 'primevue/datatable';
    import Column from 'primevue/column';
    import ColumnGroup from 'primevue/columngroup';   // optional
    import Row from 'primevue/row';                   // optional
    import Tag from 'primevue/tag';
    import ConfirmPopup from "primevue/confirmpopup";
    import { useConfirm } from "primevue/useconfirm";
    import { useToast } from 'primevue/usetoast';


    import { onMounted, ref } from "vue";
    import useOffices from "../../composables/offices";

    const toast = useToast();
    const { offices, getAllOffices, deleteOffice } = useOffices();
    const loading = ref(false);
    const confirm = useConfirm();

    onMounted(async () => {
        loading.value = true;
        await getAllOffices();
        loading.value = false;
    });

    const onDelete = (event, id) => {
        confirm.require({
            target: event.currentTarget,
            message: 'Are you sure you want to delete this office?',
            icon: 'pi pi-exclamation-triangle',
            rejectProps: {
                label: 'Cancel',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Save'
            },
            accept: async () => {
                loading.value = true;
                await deleteOffice(id);
                loading.value = false;
            }
        });
    }



</script>