import { createApp } from 'vue'
import {createRouter, createWebHistory} from "vue-router";
import Fixture from "@/views/Fixture.vue";
import Teams from "@/views/Teams.vue";
import Landing from "@/views/Landing.vue";
import App from "@/views/App.vue";
import Simulation from "@/views/Simulation.vue";

const app = createApp(App)
app.config.globalProperties.hostUrl = 'http://localhost:8000/api';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "landing",
            component: Landing,
        },
        {
            path: "/teams",
            name: "teams",
            component: Teams,
        },
        {
            path: "/fixture",
            name: "fixture",
            component: Fixture,
        },
        {
            path: "/simulation",
            name: "simulation",
            component: Simulation,
        }
    ],
});

app.use(router);
app.mount('#app')
