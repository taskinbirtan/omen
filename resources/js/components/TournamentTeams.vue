<template>
    <div class="tournament-teams">
        <h2>The Teams</h2>
        <a href="/omen/pots" class="custom-button primary">Generate Fixtures</a>
        <div v-for="(group, index) in groupedTeams" :key="index" class="team-group">
            <h3></h3>
            <ul>
                <li v-for="team in group" :key="team.id" class="team-item">
                    {{ team.name }}
                </li>
            </ul>
        </div>
    </div>
</template>

<style>
.custom-button {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.primary {
    background-color: #3498db;
    color: #fff;
}

.primary:hover {
    background-color: #2980b9;
}
.tournament-teams {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

.team-group {
    margin-bottom: 20px;
}

.team-group h3 {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.team-item {
    background-color: #f2f2f2;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 6px;
}

.team-item:hover {
    background-color: #e0e0e0;
}
</style>





<script>
export default {
    data() {
        return {
            teams: [], // Turnuva takımlarını içeren dizi
        };
    },
    computed: {
        groupedTeams() {
            // Takımları altışar gruplara ayırma işlemi
            const grouped = [];
            const groupSize = 4; // Grup boyutu

            for (let i = 0; i < this.teams.length; i += groupSize) {
                grouped.push(this.teams.slice(i, i + groupSize));
            }

            return grouped;
        },
    },
    mounted() {
        fetch('http://sirserie.com/omen/api/teams')
            .then(response => response.json())
            .then(response => {
                this.teams = response.data;
            });
        return {
            teams: this.teams
        }
    },
};
</script>


