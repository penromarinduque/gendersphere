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
                                    <Chart type="pie" :data="chartData" :options="chartOptions" class="w-full " />
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

    const chartData = ref();
    const chartOptions = ref();

    const setChartData = () => {
        const documentStyle = getComputedStyle(document.body);

        return {
            labels: personInfoChartData.value?.employees_by_gender.map((data) => data.gender),
            datasets: [
                {
                    data: personInfoChartData.value?.employees_by_gender.map((data) => data.total),
                    backgroundColor: [documentStyle.getPropertyValue('--p-cyan-500'), documentStyle.getPropertyValue('--p-orange-500'), documentStyle.getPropertyValue('--p-gray-500')],
                    hoverBackgroundColor: [documentStyle.getPropertyValue('--p-cyan-400'), documentStyle.getPropertyValue('--p-orange-400'), documentStyle.getPropertyValue('--p-gray-400')]
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
        chartData.value = setChartData();
        chartOptions.value = setChartOptions();
    }

    function onEmployeeTypeChange(value) {
        getEmployees(value.value.value);
    }


</script>

