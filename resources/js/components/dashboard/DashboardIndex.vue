<template>

    <div class="flex justify-center" v-if="loading">
        <ProgressSpinner style="width: 50px; height: 50px" strokeWidth="4" 
        animationDuration=".5s" aria-label="Custom ProgressSpinner" />
    </div>
    
    <h2 class="text-3xl font-bold">Dashboard</h2>
    <h5 class="text-lg">Welcome back <span class="text-primary font-bold">{{ authUser.name }}</span>.</h5>

    <div class="flex justify-end  mb-2">
        <Select size="small" @change="fetchSummary" v-model="selectedYear" :options="yearlist" optionLabel="year" optionValue="year"  placeholder="Year"  class="w-fit md:w-56 mb-2 me-2" ></Select>   
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-4">
        <Card>
            <template #content>
                <h1 class="text-3xl font-extrabold">{{ summary && summary.totals.users }}</h1>
                <h5>Users</h5>
            </template>
        </Card>
        <Card>
            <template #content>
                <h1 class="text-3xl font-extrabold">{{ summary && summary.totals.personnels }}</h1>
                <h5>Personnels</h5>
            </template>
        </Card>
        <Card>
            <template #content>
                <h1 class="text-3xl font-extrabold">{{ summary && summary.totals.committees }}</h1>
                <h5>Committees</h5>
            </template>
        </Card>
        <Card>
            <template #content>
                <h1 class="text-3xl font-extrabold">{{ summary && summary.totals.frontlineServices }}</h1>
                <h5>Frontline Services</h5>
            </template>
        </Card>
    </div>
</template>

<script setup>
    import Card from 'primevue/card';
    import Select from 'primevue/select';
    import { onMounted, ref } from 'vue';
    import useUser from '@/composables/users';
    import useDashboard from '@/composables/dashboard';
    import ProgressSpinner from 'primevue/progressspinner';

    const loading = ref(false);

    let curr_year = new Date().getFullYear();
    console.log(curr_year);
    const selectedYear = ref(curr_year);

    const { authUser, getAuthenticatedUser, yearlist, getYearlist } = useUser();
    const { summary, getSummary } = useDashboard();

    onMounted(async () => {
        getAuthenticatedUser();
        await getYearlist();
        await fetchSummary();
    });

    const fetchSummary = async () => {
        loading.value = true;
        await getSummary(selectedYear.value);
        loading.value = false;
    }

</script>