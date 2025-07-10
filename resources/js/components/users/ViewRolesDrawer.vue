<template>
    <Drawer v-model:visible="visible" header="Roles" position="right" class="!w-full md:!w-80 lg:!w-[30rem]" >
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </Drawer>

</template>

<script setup>
    import Drawer from 'primevue/drawer';
    import { watch } from 'vue';

    const { visible } = defineProps({
        visible: Boolean
    });
    const isVisible = ref(false);

    watch(() => visible, (newVal) => {
        isVisible.value = newVal;
        console.log('visible changed:', newVal);
    });
</script>