<template>
    <div>
        Hello from navbar
    </div>
</template>

<script>
    export default {
        props: [
            'user',
        ],

        data () {
            return {
                u: null,
                empty: false,
            }
        },

        created () {
            if (this.user === 'empty') {
                this.empty = true;
                return;
            }

            this.u = JSON.parse(this.user);

            console.log(this.u);
        },
    }
</script>
