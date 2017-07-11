<template>
    <div>
        Hello {{ m.first_name }}
    </div>
</template>

<script>
    export default {
        props: [
            'me',
        ],

        data () {
            return {
                m: null,
            }
        },

        created () {
            this.m = JSON.parse(this.me);

            console.log(this.m);
        },
    }
</script>
