<template>
    <Drawer v-model:visible="isVisible" header="Roles" position="right" class="!w-full md:!w-80 lg:!w-[30rem]" @hide="$emit('close')">
        <div class="flex justify-end">
            <Button label="Add Role" @click="addRoleVisible = true" size="small"></Button>
        </div>
        <h5 class="mb-2 text-lg font-bold">{{ props.user.name }}</h5>
        <DataView :value="props.user.roles">
            <template #list="slotProps">
                <div class="flex flex-col p-2">
                    <div v-for="(item, index) in slotProps.items" :key="index">
                        <div class="p-2 border border-gray-200 flex justify-between align-items-center" >
                            <div class="">
                                <Tag severity="secondary" :value="item.role_type.toUpperCase()"></Tag>-<Tag severity="secondary" :value="item.office.office_name"></Tag>
                            </div>
                            <Button size="small" severity="danger" label="Delete" variant="outlined" class="float-right" @click="_deleteRole(item.id)" :loading="loading"></Button>
                        </div>  
                    </div>
                </div>
            </template>
            <template #empty>
                <div class="p-2">No roles found</div>
            </template>
        </DataView>
    </Drawer>

    <AddRoleDialog :visible="addRoleVisible" @close="addRoleVisible = false" :user="props.user" @saved="roleAdded()" :loading="loading" />

</template>

<script setup>
    import Drawer from 'primevue/drawer';
    import { ref, watch, watchEffect } from 'vue';
    import AddRoleDialog from './AddRoleDialog.vue';
    import Button from "primevue/button";
    import DataView from "primevue/dataview";
    import Tag from 'primevue/tag';
    import Card from "primevue/card";
    import { useConfirm } from "primevue/useconfirm";
import useRoles from '../../composables/roles';

    const { deleteRole } = useRoles();
    const loading = ref(false);
    const confirm = useConfirm();
    const props  = defineProps({
        visible: Boolean,
        user : Object
    });
    const isVisible = ref(false);
    const addRoleVisible = ref(false);

    watchEffect(() => {
        console.log(props.user);
    })

    watch(() => props.visible, (newVal) => {
        isVisible.value = newVal;
        console.log('visible changed:', newVal);
    });

    const _deleteRole = (id) => {
        confirm.require({
            message: 'Are you sure you want to delete this role?',
            header: 'Delete Role',
            icon: 'pi pi-exclamation-triangle',
            rejectProps: {
                label: 'Cancel',
                severity: 'secondary',
                outlined: true
            },
            acceptProps: {
                label: 'Continue',
                severity: 'danger'
            },
            accept: async () => {
                loading.value = true;
                const result = await deleteRole(id);
                if(result) {
                    location.reload();
                }
                loading.value = false;
                //callback to execute when user confirms deletion
            }   
        });
    }

</script>