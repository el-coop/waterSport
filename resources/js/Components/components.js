//vendors
import VModal from 'vue-js-modal';
import 'izitoast/dist/css/iziToast.css';
import VueIziToast from 'vue-izitoast';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.use(VModal);
Vue.use(VueIziToast);
Vue.component('Datatable', require('../vendor/elcoop/Datatable/Datatable').default);
Vue.component('Drawer', require('../vendor/elcoop/navbar/Drawer').default);
Vue.component('ListSection', require('../vendor/elcoop/navbar/ListSection').default);
Vue.component('Navbar', require('../vendor/elcoop/navbar/Navbar').default);
Vue.component('DatatableDeleteForm', require('./Datatable/DatatableDeleteForm').default);

// form
Vue.component('AjaxForm', require('./Form/AjaxForm').default);
Vue.component('DynamicForm', require('./Form/DynamicForm').default);
Vue.component('TextField', require('./Form/TextField').default);
Vue.component('TextareaField', require('./Form/TextareatField').default);
Vue.component('SelectField', require('./Form/SelectField').default);
Vue.component('FileField', require('./Form/FileField').default);
Vue.component('CheckboxField', require('./Form/CheckboxField').default);
Vue.component('AlternativeSubmitField', require('./Form/AlternativeSubmitField').default);
Vue.component('HelpField', require('./Form/HelpField').default);
Vue.component('MultiselectField', require('./Form/MultiselectField').default);
