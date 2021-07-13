import { createApp } from 'vue';

import App from './App.vue';
import Router from './Router';

require('normalize.css');

createApp(App).use(Router)
    .mount('#app');