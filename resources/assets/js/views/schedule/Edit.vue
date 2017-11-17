<template>
    <div>Edit page</div>
</template>

<script>
    import { post, get } from '../../helpers/api'

    export default {
        created () {
            // {id: {num}}
            console.log(this.$route.params)
        },

        data() {
            return {
                subjects: [],
                schedule: [],
            }
        },

        mounted() {
            this.subjects = this.getSubjects();
        },

        methods: {
            getSubjects() {
                get('/api/subjects?faculty=1&course=1')
                    .then(res => {
                        return res;
                    });
            },
            getSchedule() {
                get('/api/schedule?id=' + this.$route.params)
                    .then(res => {
                        return res;
                    });
            }
        }


    }
</script>
