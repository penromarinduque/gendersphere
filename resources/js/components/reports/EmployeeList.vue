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
                        <TabPanel value="0">
                            <div class="flex justify-end mb-2">
                                <Select @change="onEmployeeTypeChange" size="small" v-model="selectedCity" :options="[{name: 'All', value: 'all'},{name: 'COS', value: 'cos'}, {name: 'Permanent', value: 'permanent'}]" optionLabel="name" placeholder="Filter Employee" class="w-full md:w-56" />
                            </div>
                            <DataTable :value="employees" tableStyle="min-width: 50rem" showGridlines >
                                <Column header="Name">
                                    <template #body="{ data }">
                                        {{ data.lastname }}, {{ data.firstname }} {{ data.middlename }} 
                                    </template>
                                </Column>
                                <Column field="position" header="Position"></Column>
                                <Column header="Gender">
                                    <template #body="{ data }">
                                        {{ data.gender.toUpperCase() }}
                                    </template>
                                </Column>
                                <Column header="Address">
                                    <template #body="{ data }">
                                        {{ data.barangay_name }}, {{ data.municipality_name }}, {{ data.province_name }}
                                    </template>
                                </Column>
                                <Column field="age" header="Age"></Column>
                                <Column header="Birthdate">
                                    <template #body="{ data }"> {{ new Date(data.birthdate).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }) }}</template>
                                </Column>
                            </DataTable>
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
    import { onMounted, ref } from 'vue';
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

    const { employees, getEmployees, personInfoChartData, getPersonInfoChartData } = usePersonInfos();

    onMounted(() => {
        initialize();
        
    });

    const empByGenderData = ref();
    const empByEmpTypeData = ref();
    const permanentByGenderData = ref();
    const cosByGenderData = ref();
    const chartOptions = ref();

    const setPieChartData = (data) => {
        const documentStyle = getComputedStyle(document.body);

        return {
            labels: data.map((data) => data.name),
            datasets: [
                {
                    data: data.map((data) => data.total),
                    backgroundColor: [
                        documentStyle.getPropertyValue('--p-purple-500'),
                        documentStyle.getPropertyValue('--p-purple-400'),
                        documentStyle.getPropertyValue('--p-purple-300')
                    ],
                    hoverBackgroundColor: [
                        documentStyle.getPropertyValue('--p-purple-400'),
                        documentStyle.getPropertyValue('--p-purple-300'),
                        documentStyle.getPropertyValue('--p-purple-200')
                    ]
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
        await getEmployees(null);
        await getPersonInfoChartData();
        empByGenderData.value = setPieChartData(personInfoChartData.value?.employees_by_gender);
        empByEmpTypeData.value = setPieChartData(personInfoChartData.value?.employees_by_emp_type);
        permanentByGenderData.value = setPieChartData(personInfoChartData.value?.permanent_by_gender);
        cosByGenderData.value = setPieChartData(personInfoChartData.value?.cos_by_gender);
        chartOptions.value = setChartOptions();
    }

    function onEmployeeTypeChange(value) {
        getEmployees(value.value.value);
    }


</script>

