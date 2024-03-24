<script>

export default {
    methods: {
        goToTeamsPage() {
            this.$router.push('/teams');
        },
        goToFixturesPage() {
            this.$router.push('/fixture');
        },
        getCurrentFixture() {
            try {
                fetch(this.hostUrl + '/fixtures/show')
                    .then((response) => {
                        if (response.ok) {
                            this.goToFixturesPage();
                        } else {
                            if (response.status === 404) {
                                this.goToTeamsPage();
                            }
                        }
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
        this.getCurrentFixture();
    },
}

</script>

<template>
    <div>Loading</div>
</template>
