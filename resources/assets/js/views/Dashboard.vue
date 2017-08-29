<template>
    <md-layout md-align="center">
        <md-layout md-flex="30" class="home-block">
            <md-whiteframe class="home-select" md-elevation="2">
                <h2>Пошук розкладу</h2>
                <div class="home-select-block">
                    <md-input-container>
                        <label for="degree">Освітній ступінь</label>
                        <md-select name="degree" id="degree" v-model="degree" @change="changeGroups" md-menu-class="home-select">
                            <md-option value="bachelor">Бакалавр</md-option>
                            <md-option value="master">Магістр</md-option>
                        </md-select>
                    </md-input-container>

                    <md-input-container>
                        <label for="training-form">Форма навчання</label>
                        <md-select name="training-form" id="training-form" v-model="trainingForm" md-menu-class="home-select">
                            <md-option value="daytime">Денна</md-option>
                            <md-option value="nighttime">Вечірня</md-option>
                        </md-select>
                    </md-input-container>
                </div>

                <div class="home-select-block">
                    <md-input-container>
                        <label for="faculty">Факультет</label>
                        <md-select name="faculty" id="faculty" v-model="faculty" md-menu-class="home-select">
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
                        <md-select name="course" id="course" v-model="course" md-menu-class="home-select">
                            <md-option v-for="course in countCourses" :value="course" :key="course">{{ course }}</md-option>
                        </md-select>
                    </md-input-container>

                    <md-input-container>
                        <label for="groups">Група</label>
                        <md-select name="group" id="groups" v-model="groups" md-menu-class="home-select">
                            <md-option v-for="group in countGroups" :value="group" :key="group">{{ group }}</md-option>
                        </md-select>
                    </md-input-container>
                </div>
                <div class="button-container text-center">
                    <md-button class="md-raised md-primary home-btn" @click="showSchedule">Відкрити</md-button>
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
    import pnotify from 'pnotify'

    export default {
        components: {
            pnotify,
        },
        data() {
           return {
               degree: 'bachelor',
               trainingForm: 'daytime',
               faculty: 'foais',
               course: 1,
               groups: 1,
               countGroups: 15,
               countCourses: 5,
           }
        },

        methods: {
            changeGroups() {
                if (this.degree == 'master') {
                    this.countCourses = 2;
                    this.course = (this.course > 2) ? 1 : this.course;
                } else {
                    this.countCourses = 5;
                }
            },
            showSchedule(){
                let data = {
                    degree: this.degree,
                    daytime: this.trainingForm,
                    faculty: this.faculty,
                    course: this.course,
                    groups: this.groups,
                };

                axios.post('/dashboard/find', data)
                    .then(this.onSuccess)
                    .catch(this.onError);
            },
            onSuccess(response){
                window.location.href = '/schedule/' + response.data;
            },
            onError(response){
                new pnotify({
                    title: 'Розклад не знайдено',
                    text: 'Перевірте параметри пошуку',
                    icon: true,
                    type: 'error',
                    styling: 'brighttheme',
                    buttons: {
                        closer: true
                    }
                });
            }
        },

    }
</script>