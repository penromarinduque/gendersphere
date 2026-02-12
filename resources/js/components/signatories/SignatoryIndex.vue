<template>
    <div class="flex items-center gap-2">
        <label for="">Select Report</label>
        <Select v-model="selectedReport" :options="reports" option-label="label" option-value="value" placeholder="Select Report" ></Select>
    </div>

    <template v-if="selectedReport == 'gad_plan_and_budget_annual_report'">
        <div class="mt-4">
            <UpdateGadArSignatory />
        </div>
    </template> 
</template>

<script setup>
import { 
    Select 
} from 'primevue';
import { ref } from 'vue';
import UpdateGadArSignatory from './UpdateGadArSignatory.vue';

const reports = ref([
    {
        label: 'GAD Plan and Budget Annual Report',
        value: 'gad_plan_and_budget_annual_report'
    }
]);
const selectedReport = ref('gad_plan_and_budget_annual_report');
</script>