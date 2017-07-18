<template>
    <md-whiteframe id="auth_form" md-elevation="2">
        <h1>Відновлення паролю</h1>

        <form :action="link" method="POST">
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="token" :value="token">

            <md-input-container class="in_email">
                <md-icon>perm_identity</md-icon>
                <label>Email</label>
                <md-input type="email" name="email" :value="oldEmail" autofocus required></md-input>
            </md-input-container>

            <md-input-container class="in_pass">
                <md-icon>lock_outline</md-icon>
                <label>Пароль</label>
                <md-input type="password" name="password" required></md-input>
            </md-input-container>

            <md-input-container class="in_repeat_pass">
                <md-icon>repeat</md-icon>
                <label>Повторити пароль</label>
                <md-input type="password" name="password_confirmation" required></md-input>
            </md-input-container>

            <md-button class="md-raised md-primary" type="submit">Змінити пароль</md-button>
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
            'csrf', 'oldEmail', 'error', 'link', 'status', 'token',
        ],

        data () {
            return {
                text: '',
            }
        },

        mounted () {
            if (this.error || this.status) {
                this.text = this.error ? this.error : this.status;

                this.$nextTick(() => {
                    this.$refs.snackbar.open();
                });
            }
        }
    }
</script>
