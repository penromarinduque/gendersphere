<template>
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
        <Column  header="Actions">
            
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


    import { onMounted, ref } from "vue";
    import useOffices from "../../composables/offices";

    const { offices, getAllOffices } = useOffices();
    const loading = ref(false);

    onMounted(async () => {
        loading.value = true;
        await getAllOffices();
        loading.value = false;
    });



</script>