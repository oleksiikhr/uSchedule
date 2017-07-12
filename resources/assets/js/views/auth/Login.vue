<template>
    <md-whiteframe id="auth_form" md-elevation="2">
        <h1>Авторизація</h1>

        <form action="/login" method="POST">
            <input type="hidden" name="_token" :value="csrf">

            <md-input-container class="in_email">
                <md-icon>perm_identity</md-icon>
                <label>Email</label>
                <md-input name="email" :value="oldEmail" autofocus required></md-input>
            </md-input-container>

            <md-input-container class="in_pass">
                <md-icon>lock_outline</md-icon>
                <label>Пароль</label>
                <md-input type="password" name="password" required></md-input>
            </md-input-container>

            <md-checkbox name="remember" class="md-primary" v-model="remember">Запам'ятати мене</md-checkbox>

            <md-button class="md-raised md-primary" type="submit">Увійти</md-button>
        </form>

        <md-snackbar :md-position="'top right'" ref="snackbar" :md-duration="5000">
            <span>Email або пароль невірний.</span>
            <md-button @click="$refs.snackbar.close()">Сховати</md-button>
        </md-snackbar>
    </md-whiteframe>
</template>

<script>
    export default {
        props: [
            'csrf', 'hasError', 'oldEmail', 'oldRemember',
        ],

        data () {
            return {
                remember: this.oldRemember,
            }
        },

        mounted () {
            if (this.hasError) {
                this.$nextTick(() => {
                    this.$refs.snackbar.open();
                });
            }
        },
    }
</script>
