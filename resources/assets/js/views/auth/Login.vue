<template>
    <md-whiteframe id="login_form" md-elevation="2">
        <h2>Авторизація</h2>

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
    </md-whiteframe>
</template>

<script>
    export default {
        props: [
            'errors', 'csrf', 'oldEmail', 'oldRemember',
        ],

        data () {
            return {
                remember: this.oldRemember,
            }
        },

        created () {
            // TODO: show errors below the field or..
            // http://vuematerial.io/#/components/snackbar
            console.log(JSON.parse(this.errors));
        },

        // TODO: autofocus on the password if the user has errors
    }
</script>
