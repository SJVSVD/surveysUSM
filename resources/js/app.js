import './bootstrap';
import { createApp, defineAsyncComponent } from 'vue';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';


const app = createApp({});
app.use(Toast, {
  transition: 'Vue-Toastification__bounce',
  maxToasts: 20,
  newestOnTop: true,
});

const surveyComponent = defineAsyncComponent(() => import('./components/surveyComponent.vue'));
const questionComponent = defineAsyncComponent(() => import('./components/questionComponent.vue'));

app.component('survey-component', surveyComponent);
app.mount('#survey-component');

app.component('question-component', questionComponent);
app.mount('#question-component');