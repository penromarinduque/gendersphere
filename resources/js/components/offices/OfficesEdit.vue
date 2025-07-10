<template>
    <!-- <App /> -->

    <!-- <Toast /> -->
     <div class="grid justify-items-end">
        <Button asChild v-slot="props" size="small" severity="secondary">
            <router-link :to="{ name: 'offices.index' }" :class="props.class"><i class="pi pi-arrow-left"></i> Back</router-link>
        </Button> 
    </div>

    <form class="space-y-6" @submit.prevent="_updateOffice">
        <h1 class="text-2xl font-extrabold">Update Office</h1>
        <div class="grid grid-cols-2 gap-5">
            <div class="mb-3">
                <label for="">Office Name <span class="text-red-500">*</span></label><br>
                <InputText 
                name="office_name" 
                placeholder="Office Name" 
                class="w-full"
                v-model="form.office_name" />
                <span class="text-sm text-red-600" v-if="errors?.office_name">{{ errors.office_name[0] }}</span>
            </div>
            
            <div class="mb-3">
                <label for="">Location <span class="text-red-500">*</span></label><br>
                <Autocomplete 
                :suggestions="barangays" 
                name="barangay_id" 
                :optionLabel="(s) => {
                    return `${s.barangay_name}, ${s.municipality.municipality_name}, ${s.municipality.province.province_name}`
                }" 
                placeholder="Select Barangay" 
                class="w-full !important" 
                inputClass="w-full"
                @complete="_searchBarangays" 
                @update:modelValue="onSelectBarangay"
                v-model="form.selected_barangay_label"></Autocomplete>
                <span class="text-sm text-red-600" v-if="errors?.barangay_id">{{ errors.barangay_id[0] }}</span>
            </div>
        </div>
    
        <div class="grid grid-cols-2 gap-5">
            <div class="mb-3">
                <label for="">Office Type <span class="text-red-500">*</span></label><br>
                <Select name="office_type" placeholder="Office Type" :options="[
                    {name: 'Region', value: 'region'},
                    {name: 'PENRO', value: 'penro'},
                    {name: 'CENRO', value: 'cenro'},
                ]" optionLabel="name" optionValue="value" class="w-full" filter
                v-model="form.office_type"></Select>
                <span class="text-sm text-red-600" v-if="errors?.office_type">{{ errors.office_type[0] }}</span>
            </div>
            <div class="mb-3" v-if="form.office_type == 'region'">
                <label for="">Region <span class="text-red-500">*</span></label><br>
                <Select 
                    name="region_id" 
                    placeholder="Select Region" 
                    :options="regions" 
                    optionLabel="region_name" 
                    optionValue="id" 
                    class="w-full" 
                    filter
                    v-model="form.region_id">
                </Select>
                <span class="text-sm text-red-600" v-if="errors?.region_id">{{ errors.region_id[0] }}</span>
            </div>
            <div class="mb-3" v-if="form.office_type != 'region'">
                <label for="">Parent Office <span class="text-red-500">*</span></label><br>
                <Select 
                    name="parent_id" 
                    placeholder="Select Parent Office" 
                    :options="offices" 
                    optionLabel="office_name" 
                    optionValue="id" 
                    class="w-full" 
                    filter
                    v-model="form.parent_id">
                </Select>
                <span class="text-sm text-red-600" v-if="errors?.parent_id">{{ errors.parent_id[0] }}</span>
            </div>
    
    
        </div>
    
        <div class="grid justify-items-end">
            <Button label="Save" icon="pi pi-save" size="small" type="submit" :loading="loading"></Button> 
        </div>
    </form>

</template>

<script setup>
    // import { Form } from '@primevue/forms';
    import InputText from 'primevue/inputtext';
    import Select from 'primevue/select';
    import Button from "primevue/button";
    import Autocomplete from 'primevue/autocomplete';
    import Toast from 'primevue/toast';
    import { onMounted, reactive, ref } from 'vue';

    import useRegions  from '../../composables/regions';
    import useBarangays from '../../composables/barangays';
    import useOffices from '../../composables/offices';
    import { useRoute } from 'vue-router';

    const { regions, getAllRegions } = useRegions();
    const { barangays, getAllBarangays, searchBarangays } = useBarangays();
    const { errors, updateOffice, getAllOffices, offices, office, findOfficeById } = useOffices();

    const loading = ref(false);
    const route = useRoute();

    const form = reactive({
        'selected_barangay': null,
        'office_name': '',
        'office_type': '',
        'region_id': '',
        'barangay_id': '',
        'parent_id': '',
        'selected_barangay_label': '',
        'id': route.params.id
    })

    onMounted(async (props) => {
        await findOfficeById(route.params.id);
        await getAllRegions();
        await getAllOffices();
        console.log(office.value)
        form.office_name = office.value.office_name;
        form.barangay_id = office.value.barangay_id;
        form.selected_barangay = office.value.barangay;
        form.selected_barangay_label = `${office.value.barangay.barangay_name}, ${office.value.barangay.municipality.municipality_name}, ${office.value.barangay.municipality.province.province_name}`;
        form.office_type = office.value.office_type;
        form.parent_id = office.value.office_type == "region" ? null : office.value.parent_id;
        form.region_id = office.value.office_type == "region" ? office.value.region_id : '';
        console.log(form.office_type)
    });

    const onSelectBarangay = (val) => {
        form.selected_barangay = val;
        form.barangay_id = val?.id || null;
    };

    const _searchBarangays = (event) => {
        searchBarangays(event.query);
    }

    const _updateOffice = async () => {
        errors.value = null;
        loading.value = true;
        await updateOffice({...form});
        loading.value = false;
    }
   
</script>