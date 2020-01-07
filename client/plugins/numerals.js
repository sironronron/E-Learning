import Vue from 'vue';
import VueNumeralFilter from 'vue-numeral-filter';

if (process.client) {
    Vue.use(VueNumeralFilter);
}