Nova.booting((Vue, router) => {
    Vue.component('detail-dynamic-field', require('./components/DetailField'));
    Vue.component('form-dynamic-field', require('./components/FormField'));
})
