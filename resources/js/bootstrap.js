import axios from 'axios';

window.axios = axios;

// Cấu hình axios mặc định
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';