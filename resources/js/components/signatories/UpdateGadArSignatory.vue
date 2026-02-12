<template>
    <h6 class="text-sm font-bold leading-4 tracking-wider text-left text-gray-700 uppercase">GAD Plan & Budget Signatories</h6>

    <form action="" v-on:submit.prevent="handleSubmit()">
        <div class="mb-2">
            <label for="">Prepared By</label>
            <Select v-model="form.prepared_by" :options="committeepositions" optionValue="id" optionLabel="position_title" filter  class="w-full" placeholder="Select GAD Position" ></Select>
            <span class="text-sm text-red-600" v-if="errors?.prepared_by">{{ errors.prepared_by[0] }}</span>
        </div>
        <div class="mb-2">
            <label for="">Approved By</label>
            <Select v-model="form.approved_by" :options="committeepositions" optionValue="id" optionLabel="position_title" filter  class="w-full" placeholder="Select GAD Position" ></Select>
            <span class="text-sm text-red-600" v-if="errors?.approved_by">{{ errors.approved_by[0] }}</span>
        </div>
        <div class="flex justify-end">
            <Button label="Save" icon="pi pi-save" size="small" type="submit" :loading="loading" ></Button>
        </div>
    </form>
</template>
<script setup>
import { 
    Select,
    Button
} from 'primevue';
import { onMounted, ref } from 'vue';
import useSignatories from '../../composables/signatories';
import useCommitteePositions from '../../composables/committeepositions';

const { storeSignatories, errors, getSignatories, signatories } = useSignatories();
const { getCommitteePositions, committeepositions } = useCommitteePositions();
const loading = ref(false);
const form = ref({
    "approved_by": "",
    "prepared_by": "",
});

const handleSubmit = async () => {
    loading.value = true;
    const success = await storeSignatories(form.value);
    loading.value = false;
    await fetchSignatories();
}

const fetchSignatories = async () => {
    form.value = {
        "approved_by": "",
        "prepared_by": "",
    }
    await getSignatories();
    console.log(signatories.value);
    const approvedBy = signatories.value.find(signatory => signatory.label == "Approved By" && signatory.report == "gpb");
    const preparedBy = signatories.value.find(signatory => signatory.label == "Prepared By" && signatory.report == "gpb");
    form.value = {
        "approved_by": approvedBy ? parseInt(approvedBy.signatory) : "",
        "prepared_by": preparedBy ? parseInt(preparedBy.signatory) : ""
    }
    console.log(form.value);
}

onMounted(async () => {
    await getCommitteePositions();
    await fetchSignatories();
});



</script>