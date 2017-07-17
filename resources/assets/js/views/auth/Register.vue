<template>
    <md-whiteframe id="auth_form" md-elevation="2">
        <h1>Реєстрація</h1>

        <form :action="link" method="POST">
            <input type="hidden" name="_token" :value="csrf">

            <md-input-container class="in_email">
                <md-icon>perm_identity</md-icon>
                <label>Email</label>
                <md-input type="email" name="email" autofocus required></md-input>
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

            <md-button class="md-raised md-primary" type="submit">Зареєструватися</md-button>
        </form>

        <md-snackbar :md-position="'top right'" ref="snackbar" :md-duration="5000">
            <span>{{ error }}</span>
            <md-button @click="$refs.snackbar.close()">Сховати</md-button>
        </md-snackbar>
    </md-whiteframe>
</template>

<script>
    export default {
        props: [
            'csrf', 'error', 'link',
        ],

        mounted () {
            if (this.error) {
                this.$nextTick(() => {
                    this.$refs.snackbar.open();
                });
            }
        },
    }
</script>
