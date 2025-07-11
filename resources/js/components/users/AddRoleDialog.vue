<template>
    <Dialog v-model:visible="isVisible" modal header="Update Role" :style="{ width: '25rem' }" @hide="closeUpdateRoleDialog, $emit('close')"> 
        <form class="min-w-md">
           <div class="mb-2">
                <span class="text-sm text-red-600" v-if="errors?.user_id">{{ errors.user_id[0] }}</span><br>
               <label for="username" class="font-semibold">Role</label><br>
               <Select 
                    class="w-full min-w-md"
                    v-model="form.role" 
                    :options="[{name: 'Encoder', value: 'encoder'}, {name: 'Viewer', value: 'viewer'}, {name: 'Admin', value: 'admin'}]"
                    optionLabel="name"
                    optionValue="value"
                    placeholder="Select Role">
                </Select>
               <span class="text-sm text-red-600" v-if="errors?.role">{{ errors.role[0] }}</span>
           </div>
           <div class="mb-2">
               <label for="username" class="font-semibold">Office</label><br>
               <Select 
                    disabled 
                    class="w-full"
                    v-model="form.office_id" 
                    :options="offices"
                    optionLabel="office_name"
                optionValue="id"
                    placeholder="Select Office"
                    filter>
                </Select>
               <span class="text-sm text-red-600" v-if="errors?.office_id">{{ errors.office_id[0] }}</span>
           </div>
           <div class="flex justify-end gap-2">
               <Button type="button" size="small" label="Cancel" severity="secondary" @click="$emit('close')" variant="outlined"></Button>
               <Button type="button" size="small" label="Save" @click="saveRole" :loading="loading"></Button>
           </div>
        </form>
    </Dialog>
</template>

<script setup>
    import Dialog from 'primevue/dialog';
    import Button from "primevue/button";
    import Select from 'primevue/select';
    import AddRoleDialog from './AddRoleDialog.vue';

    import useUsers from '@/composables/users';
    import { defineProps, onMounted, reactive, ref, watch, watchEffect } from 'vue';
    import useOffices from '../../composables/offices';
    import useRoles from '../../composables/roles';

    onMounted(() => {
        getAllOffices();
    });
    
    const { offices, getAllOffices } = useOffices();
    const { addRole, errors } = useRoles();
    const { visible, user } = defineProps({
        visible: Boolean,
        user : Object
    });

    const form = reactive({
        role: '',
        office_id: '',
        user_id: ''
    });
    const isVisible = ref(false);

    const loading = ref(false);

    watch(() => user, (newVal) => {
        form.user_id = newVal.id;
        form.office_id = newVal.office_id;
    });

    watch(() => visible, (newVal) => {
        isVisible.value = newVal;
    });

    const closeUpdateRoleDialog = () => {
        form.office_id = '';
        form.role = '';
    }

    const saveRole = async () => {
        loading.value = true;
        if(await addRole(form)){
            location.reload();
        }
        closeUpdateRoleDialog()
        loading.value = false;
    }

</script>