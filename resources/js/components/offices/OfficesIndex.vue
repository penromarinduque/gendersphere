<template>
    <div class="grid justify-items-end">
        <Button asChild label="Create" icon="pi pi-plus" class="p-button-success" v-slot="props" size="small">
            <router-link :to="{ name: 'offices.create' }" :class="props.class">Create Office</router-link>
        </Button>
    </div>
    asd
</template>

<script setup>
    import Button from "primevue/button";


</script>