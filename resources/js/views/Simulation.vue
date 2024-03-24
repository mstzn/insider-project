<script>

export default {
    data() {
        return {
            week: 1,
            standings: [],
            schedule: [],
            predictions: []
        };
    },
    methods: {
        goToLanding() {
            this.$router.push('/');
        },
        getSimulationData() {
            try {
                fetch(this.hostUrl + '/simulation')
                    .then((response) => {
                        response.json().then((data) => {
                            this.week = data['data']['week'];
                            this.standings = data['data']['standings'];
                            this.schedule = data['data']['schedule'];
                            this.predictions = data['data']['predictions'];
                        });
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            } catch (error) {
                console.error(error);
            }
        },
        playAllWeeks() {
            try {
                fetch(this.hostUrl + '/simulation/play-all-weeks')
                    .then((response) => {
                        response.json().then((data) => {
                            this.week = data['data']['week'];
                            this.standings = data['data']['standings'];
                            this.schedule = data['data']['schedule'];
                            this.predictions = data['data']['predictions'];
                        });
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            } catch (error) {
                console.error(error);
            }
        },
        playNextWeek() {
            try {
                fetch(this.hostUrl + '/simulation/play-next-week')
                    .then((response) => {
                        response.json().then((data) => {
                            this.week = data['data']['week'];
                            this.standings = data['data']['standings'];
                            this.schedule = data['data']['schedule'];
                            this.predictions = data['data']['predictions'];
                        });
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            } catch (error) {
                console.error(error);
            }
        },
        resetData() {
            try {
                fetch(this.hostUrl + '/simulation/reset-data')
                    .then((response) => {
                        this.goToLanding();
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            } catch (error) {
                console.error(error);
            }
        },
    },
    async mounted() {
        this.getSimulationData();
    },
}

</script>

<template>
    <h2>Simulation</h2>
    <table width="100%">
        <td>
            <table>
                <thead>
                <th>Emblem</th>
                <th>Name</th>
                <th>P</th>
                <th>W</th>
                <th>D</th>
                <th>L</th>
                <th>GD</th>
                </thead>
                <tbody>
                <tr v-for='(team, index) in this.standings'>
                    <td><img width="15" v-bind:src="team.team.emblem"></td>
                    <td>{{ team.team.name }}</td>
                    <td>{{ team.points }}</td>
                    <td>{{ team.won }}</td>
                    <td>{{ team.drawn }}</td>
                    <td>{{ team.lost }}</td>
                    <td>{{ team.goal_difference }}</td>
                </tr>
                </tbody>

            </table>
        </td>
        <td>
            <table>
                <thead>
                <th>Week {{ this.week }}</th>
                </thead>
                <tbody>
                <tr v-for='(team, index) in this.schedule'>
                    <td><img width="15" v-bind:src="team.home_team.emblem"> {{ team.home_team.name }}</td>
                    <td>{{ team.home_team_score }} - {{ team.away_team_score }}</td>
                    <td align="right"> {{ team.away_team.name }} <img width="15" v-bind:src="team.away_team.emblem"></td>
                </tr>
                </tbody>

            </table>
        </td>
        <td>
            <table>
                <thead>
                <th>Championship Predictions</th>
                <th> % </th>
                </thead>
                <tbody>
                <tr v-for='(team, index) in this.predictions'>
                    <td><img width="15" v-bind:src="team.team.emblem"> {{ team.team.name }}</td>
                    <td>{{ team.prediction }}</td>
                </tr>
                </tbody>

            </table>
        </td>
    </table>
    <br><br>
    <table width="100%">
        <tr>
            <td>
                <button @click="this.playAllWeeks">
                    Play All Weeks
                </button>
            </td>

            <td>
                <button @click="this.playNextWeek">
                    Play Next Week
                </button>
            </td>

            <td>
                <button @click="this.resetData">
                    Reset Data
                </button>
            </td>
        </tr>
    </table>
</template>
