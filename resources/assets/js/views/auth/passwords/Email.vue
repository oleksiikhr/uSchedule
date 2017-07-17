<template>
    <md-whiteframe id="auth_form" md-elevation="2">
        <h1>Відновлення паролю</h1>

        <form :action="link" method="POST">
            <input type="hidden" name="_token" :value="csrf">

            <md-input-container class="in_email">
                <md-icon>perm_identity</md-icon>
                <label>Email</label>
                <md-input type="email" name="email" :value="oldEmail" autofocus required></md-input>
            </md-input-container>

            <md-button class="md-raised md-primary" type="submit">Cкинути пароль</md-button>
        </form>

        <md-snackbar :md-position="'top right'" ref="snackbar" :md-duration="5000">
            <span>{{ text }}</span>
            <md-button @click="$refs.snackbar.close()">Сховати</md-button>
        </md-snackbar>
    </md-whiteframe>
</template>

<script>
    export default {
        props: [
            'csrf', 'oldEmail', 'errorEmail', 'link', 'status',
        ],

        data () {
            return {
                text: '',
            }
        },

        mounted () {
            if (this.errorEmail || this.status) {
                this.text = this.errorEmail ? this.errorEmail : this.status;

                this.$nextTick(() => {
                    this.$refs.snackbar.open();
                });
            }
        }
    }
</script>
