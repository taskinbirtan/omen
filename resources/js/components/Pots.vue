<template>
    <div class="container">
        <h2>Pots</h2>
        <div class="row">
            <div class="col-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">
                            <button @click="fetchSimulateWeekly" class="btn btn-warning">Simulate</button>
                        </h5>
                    </div>
                </div>
            </div>
            <div v-for="pot in pots" :key="pot.id" class="col-4">
                <div v-if="pot.type !== 'knockout'" class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">
                            <button @click="openModal(pot)" class="btn btn-primary">{{ pot.name }} Fixture</button>
                            <button @click="openModal2(pot)" class="btn btn-primary">{{ pot.name }} Group - Fixture
                            </button>
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li v-for="team in pot.teams" :key="team.id" class="list-group-item">
                                {{ team.team.name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal" v-if="showModal">
            <div class="modal-content">
                <span class="close" @click="closeModal">&times;</span>
                <h3> - Match Schedule</h3>
                <table class="match-schedule">
                    <thead>
                    <tr>
                        <th>Week</th>
                        <th>Home Team</th>
                        <th>Away Team</th>
                        <th>Result</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="fixture in selectedFixture" :key="fixture.id">
                        <td>{{ fixture.week }}</td>
                        <td>{{ fixture.home_team.name }}</td>
                        <td>{{ fixture.away_team.name }}</td>
                        <td>{{
                                fixture.fixture_result ? fixture.fixture_result.map(function (item) {
                                    if (item.week == fixture.week) {
                                        return item.home_team_score + " - " + item.away_team_score;
                                    }
                                }) : '-'
                            }}
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal" v-if="showModal2">
            <div class="modal-content">
                <span class="close" @click="closeModal2">&times;</span>
                <h3> Points </h3>
                <table class="match-schedule">
                    <thead>
                    <tr>
                        <th>Team Name</th>
                        <th>Point</th>
                        <th>Win</th>
                        <th>Goals</th>
                        <th>Played</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="team in potsTeam" :key="team.id">
                        <td>{{ team.team.name }}</td>
                        <td>{{ team.team.points.points ? team.team.points.points : '0' }}</td>
                        <td>{{ team.team.points.win ? team.team.points.win : '0' }}</td>
                        <td>{{ team.team.points.goals ? team.team.points.goals : '0' }}</td>
                        <td>{{ team.team.points.played ? team.team.points.played : '0' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            pots: [],
            showModal: false,
            showModal2: false,
            selectedPot: null,
            selectedFixture: null,
            potsTeam: null,
        };
    },
    mounted() {
        this.fetchPots();
    },
    methods: {
        openModal(pot) {
            this.selectedPot = pot;
            this.fetchPotsWeeklyFixture(pot);
        },
        openModal2(pot) {
            this.selectedPot = pot;
            this.fetchPotsById(pot);
        },
        simulateWeek(pot) {
            this.selectedPot = pot;
            this.fetchPotsWeeklyFixture(pot);
        },
        closeModal() {
            this.selectedPot = null;
            this.showModal = false;
            this.selectedFixture = null;
            this.showModal2 = false;
        },
        closeModal2() {
            this.selectedPot = null;
            this.showModal2 = false;
            this.selectedFixture = null;
        },

        fetchPots() {
            // Pot ve PotTeam verilerini API'den almak için burada gerekli isteği yapabilirsiniz
            // Örneğin:

            fetch("http://sirserie.com/omen/api/pots")
                .then(response => response.json())
                .then(response => {
                    this.pots = response.data;
                });
        },
        fetchPotsById(pot) {
            // Pot ve PotTeam verilerini API'den almak için burada gerekli isteği yapabilirsiniz
            // Örneğin:

            fetch("http://sirserie.com/omen/api/pots/" + pot.id)
                .then(response => response.json())
                .then(response => {
                    this.potsTeam = response.data.teams;
                });
            this.showModal2 = true;
        },
        fetchPotsWeeklyFixture(pot) {
            // Pot ve PotTeam verilerini API'den almak için burada gerekli isteği yapabilirsiniz
            if (!this.fixture) {
                this.fixture = [];
            }
            if (this.fixture[pot.id] === undefined) {
                return fetch("http://sirserie.com/omen/api/pots/weekly/" + pot.id)
                    .then(response => response.json())
                    .then(response => {
                        this.fixture[pot.id] = response.data;
                        this.selectedFixture = this.fixture[pot.id];
                    }).then(() => {
                        this.showModal = true;
                    });
            }
            this.selectedFixture = this.fixture[pot.id];

            this.showModal = true;
        },
        fetchSimulateWeekly() {
            return fetch("http://sirserie.com/omen/api/fixtures/simulate/week")
                .then(response => response.json())
                .then(response => {
                    this.fixture[pot.id] = response.data;
                    this.selectedFixture = this.fixture[pot.id];
                }).then(() => {
                    this.showModal = true;
                });
        },
        fetchPotsPoint(pot) {
            return fetch("http://sirserie.com/omen/api/fixtures/simulate/week")
                .then(response => response.json())
                .then(response => {
                    this.fixture[pot.id] = response.data;
                    this.selectedFixture = this.fixture[pot.id];
                }).then(() => {
                    this.showModal = true;
                });
        },
    }
};
</script>

<style>
.pot-group {
    margin-bottom: 20px;
}

.team-item {
    display: inline-block;
    margin-right: 10px;
    padding: 10px;
    background-color: #f2f2f2;
    border-radius: 5px;
}

.modal {
    display: block; /* Modalı görünür yapmak için */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

h2 {
    margin-top: 0;
}

.match-schedule {
    width: 100%;
    border-collapse: collapse;
}

.match-schedule th,
.match-schedule td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.match-schedule th {
    background-color: #f2f2f2;
}
</style>
