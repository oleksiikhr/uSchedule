<template>
    <md-layout md-align="center">
        <md-layout md-flex="30" class="home-block">
            <md-whiteframe class="home-select" md-elevation="2">
                <h2>Пошук розкладу</h2>
                <div class="home-select-block">
                    <md-input-container>
                        <label for="degree">Освітній ступінь</label>
                        <md-select name="degree" id="degree" v-model="degree" @change="changeGroups">
                            <md-option value="bachelor">Бакалавр</md-option>
                            <md-option value="master">Магістр</md-option>
                        </md-select>
                    </md-input-container>

                    <md-input-container>
                        <label for="training-form">Форма навчання</label>
                        <md-select name="training-form" id="training-form" v-model="trainingForm">
                            <md-option value="daytime">Денна</md-option>
                            <md-option value="nighttime">Вечірня</md-option>
                        </md-select>
                    </md-input-container>
                </div>

                <div class="home-select-block">
                    <md-input-container>
                        <label for="faculty">Факультет</label>
                        <md-select name="faculty" id="faculty" v-model="faculty">
                            <md-option value="foais">ФОАІС</md-option>
                            <md-option value="femp">ФЕМП</md-option>
                            <md-option value="ftm">ФТМ</md-option>
                            <md-option value="frgbt">ФРГТБ</md-option>
                            <md-option value="ffbc">ФФБС</md-option>
                            <md-option value="fmtp">ФМТП</md-option>
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
                    <md-button class="md-raised md-primary home-btn">Відкрити</md-button>
                </div>
            </md-whiteframe>
        </md-layout>

        <md-layout md-flex="70" class="home-block">
            <md-whiteframe class="home-news" md-elevation="2">
                <h2>Новини</h2>
            </md-whiteframe>
        </md-layout>
    </md-layout>
</template>

<script>
    export default {
        data() {
           return {
               degree: 'bachelor',
               trainingForm: 'daytime',
               faculty: 'foais',
               course: 1,
               groups: 1,
               countGroups: 10,
               countCourses: 4,

           }
        },

        methods: {
            changeGroups() {
                if (this.degree == 'master') {
                    this.countCourses = 2;
                    this.course = (this.course > 2) ? 1 : this.course;
                } else {
                    this.countCourses = 4;
                }
            }
        },

    }
</script>