<template>
    <md-layout md-align="center">
        <md-layout md-flex="50" class="home-block">
            <div class="main-select">
                <md-input-container>
                    <label for="faculty">Факультет</label>
                    <md-select name="faculty" id="faculty" v-model="faculty">
                        <md-option value="fight_club">Fight Club</md-option>
                        <md-option value="godfather">Godfather</md-option>
                        <md-option value="godfather_ii">Godfather II</md-option>
                        <md-option value="godfather_iii">Godfather III</md-option>
                        <md-option value="godfellas">Godfellas</md-option>
                        <md-option value="pulp_fiction">Pulp Fiction</md-option>
                        <md-option value="scarface">Scarface</md-option>
                    </md-select>
                </md-input-container>

                <md-input-container>
                    <label for="cours">Курс</label>
                    <md-select name="cours" id="cours" v-model="cours">
                        <md-option value="australia">Australia</md-option>
                        <md-option value="brazil">Brazil</md-option>
                        <md-option value="japan">Japan</md-option>
                        <md-option value="united_states">United States</md-option>
                    </md-select>
                </md-input-container>

                <md-input-container>
                    <label for="group">Група</label>
                    <md-select name="group" id="group" v-model="gruop">
                        <md-option value="arial">Arial</md-option>
                        <md-option value="calibri">Calibri</md-option>
                        <md-option value="cambria">Cambria</md-option>
                        <md-option value="comic_sans" :disabled="true">Comic Sans</md-option>
                        <md-option value="consolas">Consolas</md-option>
                        <md-option value="courier">Courier</md-option>
                        <md-option value="droid_sans">Droid Sans</md-option>
                        <md-option value="georgia">Georgia</md-option>
                        <md-option value="helvetica">Helvetica</md-option>
                        <md-option value="impact">Impact</md-option>
                        <md-option value="roboto">Roboto</md-option>
                        <md-option value="segoe_ui">Segoe UI</md-option>
                        <md-option value="times_new_roman">Times New Roman</md-option>
                        <md-option value="ubuntu">Ubuntu</md-option>
                        <md-option value="verdana" :disabled="isDisabled">Verdana</md-option>
                    </md-select>
                </md-input-container>
                <div class="button-container">
                    <md-button class="md-raised md-primary main-btn" @click="someAction">Шукати</md-button>
                </div>
            </div>

        </md-layout>
    </md-layout>
</template>

<script>
    export default{

    }
</script>