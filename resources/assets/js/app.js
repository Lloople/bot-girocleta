window.Vue = require('vue');

import {TinkerComponent} from 'botman-tinker';

Vue.component('botman-tinker', TinkerComponent);

const app = new Vue({
    el: '#app'
});
