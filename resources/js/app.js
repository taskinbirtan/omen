import "./bootstrap";
import "bootstrap";

import { createApp } from 'vue/dist/vue.esm-bundler';


import TournamentTeams from "./components/TournamentTeams.vue";
import Fixtures from "./components/Fixtures.vue";
import Pots from "./components/Pots.vue";

const app = createApp({});

app.component("tournament-teams", TournamentTeams);
app.component("fixtures", Fixtures);
app.component("pots", Pots);

const mountedApp = app.mount("#app");
