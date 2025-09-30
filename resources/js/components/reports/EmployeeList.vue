<template>
    <div class="mx-5">
        <Card>
            <template #content>
                
                <Tabs value="0">
                    <TabList>
                        <Tab value="0">Employee List</Tab>
                        <Tab value="1">Visualization</Tab>
                    </TabList>
                    <TabPanels>
                        <TabPanel value="0" >
                            <div class="flex justify-end mb-2 gap-3">
                                <Select 
                                    @change="onEmployeeTypeChange" 
                                    size="small"  
                                    :options="[{name: 'All', value: 'all'},{name: 'COS', value: 'cos'}, {name: 'Permanent', value: 'permanent'}]" 
                                    optionLabel="name" 
                                    optionValue="value"
                                    placeholder="Filter Employee" 
                                    class="w-full md:w-56"
                                    v-model="selectedEmploymentType"
                                />
                               <DatePicker
                                    v-model="dateRange"
                                    selectionMode="range"
                                    dateFormat="yy-mm-dd"
                                    placeholder="Select Date Range"
                                    class="w-full md:w-72"
                                    @update:modelValue="onDateRangeChange"
                                    showIcon
                                />
                                <Button
                                    icon="pi pi-times"
                                    label="Clear Range"
                                    severity="secondary"
                                    size="small"
                                    class="p-button-outlined"
                                    @click="clearDateRange"
                                    :disabled="!dateRange">
                                </Button>
                                <Button
                                    icon="pi pi-print"
                                    label="Print"
                                    class="p-button-success mb-4"
                                    size="small"
                                    @click="printPage"
                                />
                            </div>
                            <div id="print-section">
                            <p class="text-sm text-gray-500 mt-1">{{selectedEmploymentTypeLabel }} {{ formattedDateRange }}</p>
                            <DataTable
                                class="mb-4"
                                :value="employees"
                                tableStyle="min-width: 50rem"
                                showGridlines>                                   
                                <Column header="Name">
                                        <template #body="{ data }">
                                            {{ data.lastname }}, {{ data.firstname }} {{ data.middlename }} 
                                        </template>
                                    </Column>
                                    <Column field="position" header="Position"></Column>
                                    <Column field="education_level" header="Education Level">
                                        <template #body="{ data }">
                                            {{ data.education_level.toUpperCase().replace(/_/g, ' ') }}
                                        </template>
                                    </Column>
                                    <Column field="civil_status" header="Civil Status">
                                        <template #body="{ data }">
                                            {{ data.civil_status.toUpperCase() }}
                                        </template>
                                    </Column>
                                    <Column field="employment_type" header="Employee Type">
                                        <template #body="{ data }">
                                            {{ data.employment_type.toUpperCase() }}
                                        </template>
                                    </Column>
                                    <Column field="employment_status" header="Employee Status">
                                        <template #body="{ data }">
                                            {{ data.employment_status.toUpperCase() }}
                                        </template>
                                    </Column>
                                    <Column header="Gender">
                                        <template #body="{ data }">
                                            {{ data.gender.toUpperCase() }}
                                        </template>
                                    </Column>
                                    <Column header="Address">
                                        <template #body="{ data }">
                                            {{ data.municipality_name }}
                                        </template>
                                    </Column>
                                    <Column header="Age">
                                        <template #body="{ data }">{{ computeAge(data.birthdate) }}</template>
                                    </Column>
                                    <template #empty>
                                        <div class="w-full flex justify-center items-center text-gray-500 text-lg">
                                            No records found.
                                        </div>
                                    </template>
                                </DataTable>
                            <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4 print:grid-cols-4">
                                <Panel header="Employees by Gender">
                                    <ul>
                                        <li v-for="item in genderSummary" :key="item.name">
                                            {{ capitalizeFirstLetter(item.name) }}: {{ item.total }}
                                        </li>
                                         <li class="font-semibold">
                                            Total: {{ genderSummary.reduce((sum, item) => sum + item.total, 0) }}
                                        </li>
                                    </ul>
                                </Panel>
                                <Panel header="Employees by Employment Status">
                                    <ul>
                                        <li v-for="item in empTypeSummary" :key="item.name">
                                            {{ capitalizeFirstLetter(item.name) }}: {{ item.total }}
                                        </li>
                                         <li class="font-semibold">
                                            Total: {{ empTypeSummary.reduce((sum, item) => sum + item.total, 0) }}
                                        </li>
                                    </ul>
                                </Panel>
                                <Panel header="Permanent Employees by Gender">
                                    <ul>
                                        <li v-for="item in permanentGenderSummary" :key="item.name">
                                            {{ capitalizeFirstLetter(item.name) }}: {{ item.total }}
                                        </li>
                                         <li class="font-semibold">
                                            Total: {{ permanentGenderSummary.reduce((sum, item) => sum + item.total, 0) }}
                                        </li>
                                    </ul>
                                </Panel>

                                <Panel header="COS Employees by Gender">
                                    <ul>
                                        <li v-for="item in cosGenderSummary" :key="item.name">
                                            {{ capitalizeFirstLetter(item.name) }}: {{ item.total }}
                                        </li>
                                         <li class="font-semibold">
                                            Total: {{ cosGenderSummary.reduce((sum, item) => sum + item.total, 0) }}
                                        </li>
                                    </ul>
                                </Panel>
                            </div>
                            </div>
                        </TabPanel>
                        <TabPanel value="1">
                            <div class="grid grid-cols-5 gap-4">
                                <Panel header="Employees by Gender">
                                    <Chart type="pie" :data="empByGenderData" :options="chartOptions" class="w-full " />
                                </Panel>
                                <Panel header="Employees by Employment Status">
                                    <Chart type="pie" :data="empByEmpTypeData" :options="chartOptions" class="w-full " />
                                </Panel>
                                <Panel header="Permanent Employees by Gender">
                                    <Chart type="pie" :data="permanentByGenderData" :options="chartOptions" class="w-full " />
                                </Panel>
                                <Panel header="COS Employees by Gender">
                                    <Chart type="pie" :data="cosByGenderData" :options="chartOptions" class="w-full " />
                                </Panel>
                            </div>  
                        </TabPanel>
                    </TabPanels>
                </Tabs>
            </template>
        </Card>
    </div>
</template>

<script setup>
    import { onMounted, ref, computed } from 'vue';
    import usePersonInfos from '../../composables/personinfos';
    import Tabs from 'primevue/tabs';
    import TabList from 'primevue/tablist';
    import Tab from 'primevue/tab';
    import TabPanels from 'primevue/tabpanels';
    import TabPanel from 'primevue/tabpanel';
    import Card from 'primevue/card';
    import DataTable from 'primevue/datatable';
    import Column from 'primevue/column';
    import Select from 'primevue/select';
    import Chart from 'primevue/chart';
    import Panel from 'primevue/panel';
    import DatePicker from 'primevue/DatePicker';
    import Button from 'primevue/button';
    import { useCommonUtils } from '@/composables/commonutils';

    const { capitalizeFirstLetter } = useCommonUtils();
    const { employees, getEmployees, personInfoChartData, getPersonInfoChartData, computeAge } = usePersonInfos();
    const selectedEmploymentType = ref(null);
    onMounted(() => {
        initialize();
        
    });

    const empByGenderData = ref();
    const empByEmpTypeData = ref();
    const permanentByGenderData = ref();
    const cosByGenderData = ref();
    const chartOptions = ref();
    const genderSummary = ref([]);
    const permanentGenderSummary = ref([]);
    const cosGenderSummary = ref([]);
    const empTypeSummary = ref([]);

    const setPieChartData = (data) => {
        const documentStyle = getComputedStyle(document.body);
        const colorKeys = [
            '--p-purple-500',
            '--p-purple-400',
            '--p-purple-300',
            '--p-purple-200',
            '--p-purple-100'
        ];

        const getColorValues = (keys) => keys.map(key => documentStyle.getPropertyValue(key));

        const backgroundColors = getColorValues(colorKeys.slice(0, data.length));
        const hoverColors = getColorValues(colorKeys.slice(1, data.length + 1));

        return {
            labels: data.map(item => item.name),
            datasets: [
                {
                    data: data.map(item => item.total),
                    backgroundColor: backgroundColors,
                    hoverBackgroundColor: hoverColors
                }
            ]
        };
    };

    const setChartOptions = () => {
        const documentStyle = getComputedStyle(document.documentElement);
        const textColor = documentStyle.getPropertyValue('--p-text-color');

        return {
            plugins: {
                legend: {
                    labels: {
                        usePointStyle: true,
                        color: textColor
                    }
                }
            }
        };
    };
   
    async function initialize() {
        await fetchFilteredEmployees();
        chartOptions.value = setChartOptions();
    }

    function onEmployeeTypeChange() {
        fetchFilteredEmployees();
    }
    
    function onDateRangeChange() {
        const [start, end] = dateRange.value || [];
        if (start && end) {
            fetchFilteredEmployees();
        }
    }


    const dateRange = ref(null);
    async function fetchFilteredEmployees() {
        const [start, end] = dateRange.value || [];
        const formattedStart = start ? formatLocalDate(start) : null;
        const formattedEnd = end ? formatLocalDate(end) : null;
        const employmentType = selectedEmploymentType.value === 'all' ? null : selectedEmploymentType.value;
        console.log({ employmentType, formattedStart, formattedEnd });
        await getEmployees(employmentType, formattedStart, formattedEnd);

        const chartData = await getPersonInfoChartData(employmentType, formattedStart, formattedEnd);

        // Clear all summaries initially
        permanentGenderSummary.value = [];
        cosGenderSummary.value = [];
        genderSummary.value = [];
        empTypeSummary.value = [];

        // Helper to zero out gender summary (dynamic gender types)
        const zeroGenderSummary = (base = []) => base.map(g => ({ name: g.name, total: 0 }));

        if (employmentType === 'cos') {
            cosGenderSummary.value = chartData.cos_by_gender || [];
            genderSummary.value = chartData.cos_by_gender || [];
            empTypeSummary.value = [{ name: 'COS', total: cosGenderSummary.value.reduce((sum, g) => sum + g.total, 0) }];
            permanentGenderSummary.value = zeroGenderSummary(cosGenderSummary.value);
        } else if (employmentType === 'permanent') {
            permanentGenderSummary.value = chartData.permanent_by_gender || [];
            genderSummary.value = chartData.permanent_by_gender || [];
            empTypeSummary.value = [{ name: 'Permanent', total: permanentGenderSummary.value.reduce((sum, g) => sum + g.total, 0) }];
            cosGenderSummary.value = zeroGenderSummary(permanentGenderSummary.value);
        } else {
            permanentGenderSummary.value = chartData.permanent_by_gender || [];
            cosGenderSummary.value = chartData.cos_by_gender || [];
            genderSummary.value = chartData.employees_by_gender || [];
            empTypeSummary.value = chartData.employees_by_emp_type || [];
        }

        // Update pie charts to reflect active summary data
        empByGenderData.value = setPieChartData(genderSummary.value);
        empByEmpTypeData.value = setPieChartData(empTypeSummary.value);
        permanentByGenderData.value = setPieChartData(permanentGenderSummary.value);
        cosByGenderData.value = setPieChartData(cosGenderSummary.value);

    }

    function formatLocalDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function clearDateRange() {
        dateRange.value = null;
        fetchFilteredEmployees();
    }

    function printPage() {
        window.print();
    }

    const formattedDateRange = computed(() => {
        const [start, end] = dateRange.value || [];
        if (!start || !end) return '';
        return ` ${formatLocalDate(start)} to ${formatLocalDate(end)}`;
    });

    const selectedEmploymentTypeLabel = computed(() => {
        const map = {
            all: '',
            cos: 'COS',
            permanent: 'Permanent',
        };

        const value = selectedEmploymentType.value ?? ''; // fallback to 'all' if null
        return map[value] || '';
    });


</script>

<style>
@media print {
    @page {
        size: landscape;
        margin: 1cm; /* Optional: Adjust margins */
    }

    body * {
        visibility: hidden;
    }

    #print-section, #print-section * {
        visibility: visible;
    }

    #print-section {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .no-print {
        display: none !important;
    }
}
</style>

