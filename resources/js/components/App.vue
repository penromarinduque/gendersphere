<template>
    <Toast />
    <ConfirmPopup></ConfirmPopup>
    <router-view></router-view>
</template>
<script setup>
    import Toast from 'primevue/toast';
    import 'primeicons/primeicons.css';
    import ConfirmPopup from 'primevue/confirmpopup';
</script>