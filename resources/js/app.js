import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue';
import router from './router';

import PersonInfosIndex from './components/personinfos/PersonInfosIndex.vue';

createApp({
    components: {
        PersonInfosIndex
    }
}).use(router).mount('#app');