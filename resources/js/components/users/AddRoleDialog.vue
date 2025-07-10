<template>
    <Dialog :visible="visible" modal header="Update Role" @hide="closeUpdateRoleDialog" :style="{ width: '25rem' }"> 
        <form class="min-w-md">
           <div class="mb-2">
               <label for="username" class="font-semibold">Role</label><br>
               <Select 
                    class="w-full min-w-md"
                    v-model="form.role" 
                    :options="[{name: 'Encoder', value: 'encoder'}, {name: 'Viewer', value: 'viewer'}, {name: 'Admin', value: 'admin'}]"
                    optionLabel="name"
                    optionValue="value"
                    placeholder="Select Role">
                </Select>
           </div>
           <div class="mb-2">
               <label for="username" class="font-semibold">Office</label><br>
               <Select 
                    class="w-full"
                    v-model="form.office_id" 
                    :options="offices"
                    optionLabel="office_name"
                    optionValue="id"
                    placeholder="Select Office"
                    filter>
                </Select>
           </div>
           <div class="flex justify-end gap-2">
               <Button type="button" size="small" label="Cancel" severity="secondary" @click="$emit('close')" variant="outlined"></Button>
               <Button type="button" size="small" label="Remove" @click="saveRole" severity="danger" variant="outlined"></Button>
               <Button type="button" size="small" label="Save" @click="saveRole"></Button>
           </div>
        </form>
    </Dialog>
</template>

<script setup>
    import Dialog from 'primevue/dialog';
    import Button from "primevue/button";
    import Select from 'primevue/select';

    import useUsers from '@/composables/users';
    import { defineProps, onMounted, reactive, ref, watch, watchEffect } from 'vue';
    import useOffices from '../../composables/offices';

    onMounted(() => {
        getAllOffices();
    });
    
    const { offices, getAllOffices } = useOffices();
    const { user } = useUsers();
    const { visible } = defineProps({
        visible: Boolean
    });
    const form = reactive({
        role: '',
        office_id: '',
        user_id: ''
    });
    const loading = ref(false);

    watch(user, () => {
        form.user_id = user.value.id;
    });

</script>