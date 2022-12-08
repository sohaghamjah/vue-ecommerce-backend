import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import router from './routes'

import User from './Helpers/User'
window.User = User;

import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });

window.Toast = Toast;

createApp(App).use(router).mount('#app');

