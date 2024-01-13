import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.js'
import './assets/main.css'
import 'sweetalert2/dist/sweetalert2.min.css';

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import VueSweetalert2 from 'vue-sweetalert2';
import Swal from 'sweetalert2';

window.Swal = Swal;
const app = createApp(App)

app.config.globalProperties = {
  apiUrl: "http://127.0.0.1:8000/api/",
  baseUrl: "http://127.0.0.1:8000/",
}
app.use(VueSweetalert2);
app.use(router)

app.mount('#app')


