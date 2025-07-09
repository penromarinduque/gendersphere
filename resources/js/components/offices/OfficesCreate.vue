<template>
    <div class="grid grid-cols-4 gap-5">
        <div class="mb-2">
            <label for="">Office Name</label><br>
            <InputText name="office_name" placeholder="Office Name" class="w-full" />
        </div>
        
        <div class="mb-2">
            <label for="">Location</label><br>
            <Select name="region_id" placeholder="Select Region" :options="regions" optionLabel="region_name" optionValue="id" class="w-full" filter></Select>
        </div>
        <div class="mb-2">
            <label for="">Region</label><br>
            <Select name="region_id" placeholder="Select Region" :options="regions" optionLabel="region_name" optionValue="id" class="w-full" filter></Select>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-5">
        <div class="">
            <label for="">Office Type</label><br>
            <Select name="office_type" placeholder="Office Type" :options="[
                {name: 'Region', value: 'region'},
                {name: 'PENRO', value: 'penro'},
                {name: 'CENRO', value: 'cenro'},
            ]" optionLabel="name" optionValue="value" class="w-full" filter></Select>
        </div>
        <div class="">
            <label for="">Region</label><br>
            <Select name="region_id" placeholder="Select Region" :options="regions" optionLabel="region_name" optionValue="id" class="w-full" filter></Select>
        </div>
        <div class="">
            <label for="">Location</label><br>
            <Autocomplete :suggestions="barangays" 
            name="barangay_id" 
            :optionLabel="(s) => {
                return `${s.barangay_name}, ${s.municipality.municipality_name}, ${s.municipality.province.province_name}`
            }" 
            placeholder="Select Barangay" 
            class="w-full !important" 
            inputClass="w-full"
            @complete="_searchBarangays" ></Autocomplete>
        </div>
    </div>

</template>

<script setup>
    // import { Form } from '@primevue/forms';
    import InputText from 'primevue/inputtext';
    import Select from 'primevue/select';
    import Autocomplete from 'primevue/autocomplete';
    import { onMounted } from 'vue';

    import useRegions  from '../../composables/regions';
    import useBarangays from '../../composables/barangays';

    const { regions, getAllRegions } = useRegions();
    const { barangays, getAllBarangays, searchBarangays } = useBarangays();

    onMounted(async () => {
        await getAllRegions();
    });

    const _searchBarangays = (event) => {
        searchBarangays(event.query);
    }
   
</script>