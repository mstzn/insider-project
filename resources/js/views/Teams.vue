<script>

export default {
    data() {
        return {
            teams: [],
        };
    },
    methods: {
        getTeams() {
            try {
                fetch(this.hostUrl + '/teams')
                    .then((response) => {
                        response.json().then((data) => {
                            this.teams = data['data'];
                        });
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            } catch (error) {
                console.error(error);
            }
        },
        generateFixtures() {
            try {
                fetch(this.hostUrl + '/fixtures/generate')
                    .then((response) => {
                        response.json().then((data) => {
                            this.$router.push({name: 'fixture'});
                        });
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            } catch (error) {
                console.error(error);
            }
        }
    },
    async mounted() {
        this.getTeams();
    },
}

</script>

<template>
    <h2>Tournament Teams</h2>
    <table>
        <thead>
        <th>Emblem</th>
        <th>Name</th>
        <th>Short Name</th>
        </thead>
        <tbody>
        <tr v-for='(team, index) in this.teams'>
            <td><img width="15" v-bind:src="team.emblem"> </td>
            <td>{{ team.name }}</td>
            <td>{{ team.short_name }}</td>
        </tr>
        </tbody>

    </table>
    <br><br>
    <button @click="this.generateFixtures">
        Generate Fixtures
    </button>
</template>
