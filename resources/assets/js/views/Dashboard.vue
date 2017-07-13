<template>
    <md-layout md-align="center">
        <md-layout md-flex="50" class="home-block">

            <md-whiteframe class="main-select" md-elevation="2">
                <h2 class="text-center">Пошук розкладу</h2>
                <div class="main-select-block">
                    <md-input-container>
                        <label for="faculty">Освітній ступінь</label>
                        <md-select name="faculty" id="degree" v-model="degree" @change="changeGroups">
                            <md-option value="bachelor">Бакалавр</md-option>
                            <md-option value="master">Магістр</md-option>
                        </md-select>
                    </md-input-container>

                    <md-input-container>
                        <label for="faculty">Форма навчання</label>
                        <md-select name="faculty" id="training-form" v-model="trainingForm">
                            <md-option value="daytime">Денна</md-option>
                            <md-option value="nighttime">Вечірня</md-option>
                        </md-select>
                    </md-input-container>
                </div>

                <div class="main-select-block">
                    <md-input-container>
                        <label for="faculty">Факультет</label>
                        <md-select name="faculty" id="faculty" v-model="faculty">
                            <md-option value="fight_club">ФОАІС</md-option>
                            <md-option value="godfather">ФЕМП</md-option>
                            <md-option value="godfather_ii">ФТМ</md-option>
                            <md-option value="godfather_iii">ФРГТБ</md-option>
                            <md-option value="godfellas">ФФБС</md-option>
                            <md-option value="pulp_fiction">ФМТП</md-option>
                        </md-select>
                    </md-input-container>

                    <md-input-container>
                        <label for="course">Курс</label>
                        <md-select name="course" id="course" v-model="course">
                            <md-option v-for="course in countCourses" :value="course" :key="course">{{ course }}</md-option>
                        </md-select>
                    </md-input-container>

                    <md-input-container>
                        <label for="groups">Група</label>
                        <md-select name="group" id="groups" v-model="groups">
                            <md-option v-for="group in countGroups" :value="group" :key="group">{{ group }}</md-option>
                        </md-select>
                    </md-input-container>
                </div>
                <div class="button-container text-center">
                    <md-button class="md-raised md-primary main-btn">Відкрити</md-button>
                </div>

            </md-whiteframe>
        </md-layout>
    </md-layout>
</template>

<script>
    export default{
        data(){
           return {
               degree: '',
               trainingForm: '',
               faculty: '',
               course: '',
               groups: '',
               countGroups: 10,
               countCourses: 4,
           }
        },

        methods:{
            changeGroups(){
                if (this.degree == 'master'){
                    this.countCourses = 2;
                }else{
                    this.countCourses = 4;
                }
            }
        }

    }
</script>