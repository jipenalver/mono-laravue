import "./bootstrap";
import "../sass/app.scss";
import "../css/app.css";
import "../css/custom/styles.css";
import { createApp, markRaw } from "vue";
import { createPinia } from "pinia";
import router from "./router/index";

// Main Component
import AppComponent from "./components/App.vue";

const pinia = createPinia();

pinia.use(({ store }) => {
    store.router = markRaw(router);
});

createApp({})
    .component("app-component", AppComponent)
    .use(pinia)
    .use(router)
    .mount("#app");
