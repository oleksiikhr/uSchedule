<template>
    <!--TODO: оформление не трогать-->
    <md-layout class="edit-template">
        <md-layout md-flex="25" class="left-column">
            <div class="subjects phone-viewport">
                <md-tabs md-fixed>
                    <md-tab md-icon="book">
                        <form novalidate @submit.stop.prevent="submit">
                            <md-input-container>
                                <label>Пошук предмету</label>
                                <md-input v-model="searchSubject"></md-input>
                            </md-input-container>
                        </form>
                        <draggable v-model="subjects" :clone="clone" class="draggable"
                                   :options="{group: {name: 'days', pull: 'clone', put: false}, sort: false}">
                            <div :title="subject.title" class="subject-block"
                                 v-for="subject in filterSubjects" :key="subject.id">
                                <span>{{ subject.title }}</span>
                            </div>
                        </draggable>
                    </md-tab>

                    <md-tab md-icon="people">
                        <form novalidate @submit.stop.prevent="submit">
                            <md-input-container>
                                <label>Пошук викладача</label>
                                <md-input v-model="searchTeacher"></md-input>
                            </md-input-container>
                        </form>
                        <draggable v-model="teachers" class="draggable" :options="{group: 'teachers', sort: false}">
                            <div :title="fullNameTeacher(teacher)" class="teacher-block"
                                 v-for="teacher in filterTeachers" :key="teacher.id">
                                <span>{{ fullNameTeacher(teacher) }}</span>
                            </div>
                        </draggable>
                    </md-tab>
                </md-tabs>
            </div>
        </md-layout>

        <md-layout md-flex="75" class="right-column">
            <div class="schedule">
                <div class="schedule-column" v-for="(day, dayNum) in days" :key="dayNum">
                    <h3>{{ getDayByIndex(dayNum) }}</h3>
                    <draggable  :list="days[dayNum]" class="dragArea" :options="{group:'days'}">
                        <div v-for="(element, index) in day" :key="index" class="subject-block list-subject-item">
                            <div>
                                <span>
                                    {{ index + 1 }}
                                    {{ element.subject.title + ' ' + element.room}}<br>
                                    <a @click="removeSubject(days[dayNum], index)">
                                        <md-icon class="text-danger">delete</md-icon>
                                    </a>
                                    <a @click="addRoom(element)">
                                        <md-icon class="md-primary">domain</md-icon>
                                    </a>
                                </span>
                            </div>
                            <!--<div class="switcher-block">-->
                            <!--<md-radio v-model="element.type" md-value="1" class="md-primary">Лекція</md-radio>-->
                            <!--<md-radio v-model="element.type" md-value="2" class="md-primary">Практика</md-radio>-->
                            <!--</div>-->
                        </div>
                    </draggable>
                </div>

                <!--TODO list -> day2, day3, day4, day5, day6-->
            </div>
        </md-layout>
    </md-layout>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable,
        },

        props: [
            'faculty', 'course', 'inScheduleDays',
        ],

        created() {
            this.scheduleDays = JSON.parse(this.inScheduleDays);
            console.log(this.scheduleDays);
        },

        data() {
            return {
                subjects: [],
                teachers: [],
                scheduleDays: [],
                searchSubject: '',
                searchTeacher: '',
                /*
                 *
                 * Types:
                 * 1 - лекция
                 * 2 - практика
                 *
                 * */
                day1: [{
                    title: "Об'єктно-орієнтоване програмування",
                    type: 1,
                    cabinet: '',
                    teacher: {
                        middle_name: 'Ms.',
                        first_name: 'Daenerys',
                        last_name: 'Targaryen'
                    }
                }, /*{
                 title: "Операційні системи",
                 type: 2,
                 cabinet: '',
                 teacher: {
                 middle_name: 'Mr.',
                 first_name: 'John',
                 last_name: 'Snow'
                 }
                 }, {
                 title: "Веб-дизайн",
                 type: 1,
                 cabinet: '',
                 teacher: {
                 middle_name: 'Ms.',
                 first_name: 'Sansa',
                 last_name: 'Stark'
                 }
                 }*/],
                days: [[],[],[],[],[],[]]
            }
        },

        mounted() {
            for(let i = 0; i < this.scheduleDays.length; i++){
                for(let day = 0; day < 6; day++) {
                    if (this.scheduleDays[i].day === day) {
                        this.days[day].push(this.scheduleDays[i]);
                    }
                }
            }

            for(let a = 0; a < this.days.length; a++){
                for(let j = 0; j < this.days[a].length; j++){
                    console.log(this.days[a][j].day);
                }
            }
            //console.log(this.days);

            // Temporary! For tests get all data.
            axios.get('/api/teachers.get', {
                params: {

                }
            })
                .then(response => this.teachers = response.data)
                .catch(error => console.log('Error: ' + this.error));

            axios.get('/api/subjects.get', {
                params: {
                    faculty: this.faculty,
                    course: this.course
                }
            })
                .then(response => this.subjects = response.data)
                .catch(error => console.log('Error: ' + this.error));
        },

        computed: {
            filterSubjects() {
                let subjects = this.subjects,
                    search = this.searchSubject;

                if (! search) {
                    return subjects;
                }

                search = search.toLowerCase();

                subjects = subjects.filter(function(item) {
                    if (item.title.toLowerCase().indexOf(search) !== -1) {
                        return item;
                    }
                });

                return subjects;
            },
            filterTeachers() {
                let teachers = this.teachers,
                    search = this.searchTeacher;

                if (! search) {
                    return teachers;
                }

                search = search.toLowerCase();

                teachers = teachers.filter(item => {
                    if ((item.first_name + ' ' + item.middle_name + ' ' + item.last_name).toLowerCase().indexOf(search) !== -1) {
                        return item;
                    }
                });

                return teachers;
            },
        },

        methods: {
            clone(el) {
                return {
                    id: el.id,
                    room: '',
                    subject:{
                        course: el.course,
                        faculty_id: el.faculty_id,
                        id: el.id,
                        teacher_id: el.teacher_id,
                        title: el.title,
                    }
                };
            },
            addRoom(el) {
                el.room = prompt('Введіть номер кабінету');
            },
            removeSubject(list, index) {
                list.splice(index, 1);
            },
            fullNameTeacher(teacher) {
                return teacher.first_name + ' ' + teacher.middle_name + ' ' + teacher.last_name;
            },
            getDayByIndex(index){
                switch (index) {
                    case 0:
                        return 'Понеділок';
                        break;
                    case 1:
                        return 'Вівторок';
                        break;
                    case 2:
                        return 'Середа';
                        break;
                    case 3:
                        return 'Четверг';
                        break;
                    case 4:
                        return 'П\'ятниця';
                        break;
                    case 5:
                        return 'Субота';
                        break;
                }
            }
        },
    }
</script>
