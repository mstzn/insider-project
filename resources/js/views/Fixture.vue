<script>

export default {
    data() {
        return {
            fixtures: [],
        };
    },
    methods: {
        goToSimulation() {
            this.$router.push('/simulation');
        },
        getFixture() {
            try {
                fetch(this.hostUrl + '/fixtures/show')
                    .then((response) => {
                        response.json().then((data) => {
                            this.fixtures = data['data']['fixture'];
                        });
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
        this.getFixture();
    },
}

</script>

<template>
    <h2>Generated Fixtures</h2>
    <div v-for='(week, index) in this.fixtures'>
        <table>
            <thead>
            <th>Week {{ week.week }}</th>
            </thead>
            <tbody>
            <tr v-for='(game, index) in week.games'>
                <td>{{ game.home_team.name }}</td>
                <td>{{ game.away_team.name }}</td>
            </tr>
            </tbody>

        </table>
    </div>
    <br><br>
    <button @click="this.goToSimulation">
        Start Simulation
    </button>
</template>
