<template>
    <div class="flex mb-4 place-content-end">
        <Button asChild label="Create"  v-slot="props" size="small">
            <router-link :to="{ name: 'users.create' }" :class="props.class">Create New User</router-link>
        </Button>
    </div>

    <DataTable
        :value="users"
        responsiveLayout="scroll" 
        showGridlines 
        :loading="loading">
        <Column field="name" header="Name"></Column>
        <Column field="email" header="Email"></Column>
        <Column field="role" header="Role"></Column>
        <Column field="status" header="Status"></Column>
        <Column field="id" header="Actions">
            <template #body="slotProps">
                <Button asChild v-slot="props" size="small"  variant="outlined" :loading="loading">
                    <router-link  :to="{ name: 'users.edit', params: { id: slotProps.data.id } }" :class="props.class">Edit</router-link> 
                </Button>&nbsp;
                <Button size="small" severity="danger"  variant="outlined" :loading="loading" label="Delete" @click="deleteUser($event,slotProps.data.id)"></Button>&nbsp;
                <Button size="small" severity="contrast"  variant="outlined" :loading="loading" label="Roles" @click="viewRolesVisible = true"></Button>
            </template>
        </Column>
        <template #empty> No Users found. </template>
    </DataTable>

    <AddRoleDialog :visible="addRoleVisible" @close="addRoleVisible = false"/>
    <ViewRolesDrawer :visible="viewRolesVisible" />
</template>

<script setup>
    import DataTable from 'primevue/datatable';
    import Button from 'primevue/button';
    import Column from 'primevue/column';
    import useUsers from '@/composables/users'
    import { onMounted, reactive, ref } from 'vue';
    import { useConfirm } from "primevue/useconfirm";
    import useOffices from '../../composables/offices';
    import AddRoleDialog from './AddRoleDialog.vue';
import ViewRolesDrawer from './ViewRolesDrawer.vue';

    const { users, user, getUsers, destroyUser } = useUsers();
    const { offices, getAllOffices } = useOffices();

    const addRoleVisible = ref(false);
    const viewRolesVisible = ref(false);
    const loading = ref(false);
    const confirm = useConfirm();

    const deleteUser = async (event, id) => {
        confirm.require({
            target: event.currentTarget,
            message: 'Are you sure you want to delete this user?',
            icon: 'pi pi-exclamation-triangle',
            rejectProps: {
                label: 'Cancel',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Continue'
            },
            accept: async () => {
                loading.value = true;
                await destroyUser(id);
                await getUsers()
                loading.value = false;
            }
        })
    }

    // We get the companies immediately
    onMounted(async () => {
        await getUsers();
        getAllOffices();
        console.log(users.value)
    })


</script>