<template>
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
<<<<<<< HEAD
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
=======
                <div class="schedule-column">

                    <div :class="'week week-'+week" v-for="week in 2">
                        <div :class="'day day-'+day" v-for="day in 6">
                            <h3>{{ weeks[day - 1] }}</h3>
                            <draggable v-model="scheduleDays" :options="{group:'subjects'}">
                                <div v-if="schedule.week == week && schedule.day == day"
                                     v-for="schedule in scheduleDays" :key="schedule.id">
                                    {{ schedule }}
                                </div>
                            </draggable>
>>>>>>> 79871f8992390eb4dd04ff69cb466bd66c6502ce
                        </div>
                    </div>

<<<<<<< HEAD
                <!--TODO list -> day2, day3, day4, day5, day6-->
=======
                </div>
>>>>>>> 79871f8992390eb4dd04ff69cb466bd66c6502ce
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
            'inSchedule', 'inScheduleDays', 'inTeachers', 'inSubjects',
        ],

        created() {
            this.scheduleDays = JSON.parse(this.inScheduleDays);
<<<<<<< HEAD
            console.log(this.scheduleDays);
=======
            this.schedule = JSON.parse(this.inSchedule);
            this.subjects = JSON.parse(this.inSubjects);
            this.teachers = JSON.parse(this.inTeachers);
>>>>>>> 79871f8992390eb4dd04ff69cb466bd66c6502ce
        },

        data() {
            return {
                schedule: [],
                scheduleDays: [],
                subjects: [],
                teachers: [],

                weeks: ['Понеділок', 'Вівторок', 'Середа', 'Четверг', 'П\'ятниця', 'Субота'],

                searchSubject: '',
                searchTeacher: '',
<<<<<<< HEAD
                configArr: [{
                    days: ['day1', 'day2', 'day3', 'day4', 'day5', 'day6',],
                    dayName: ['Понеділок', 'Вівторок', 'Середа', 'Четверг', 'Пятниця', 'Субота']
                }],
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

=======
            }
        },

>>>>>>> 79871f8992390eb4dd04ff69cb466bd66c6502ce
        computed: {
            filterSubjects() {
                let subjects = this.subjects,
                    search = this.searchSubject;

                if (! search) {
                    return subjects;
                }

                search = search.toLowerCase();

                subjects = subjects.filter(subject => {
                    if (subject.title.toLowerCase().indexOf(search) !== -1) {
                        return subject;
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

                teachers = teachers.filter(teacher => {
                    if (this.fullNameTeacher(teacher).toLowerCase().indexOf(search) !== -1) {
                        return teacher;
                    }
                });

                return teachers;
            },
        },

        methods: {
            clone(el) {
<<<<<<< HEAD
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
=======
                // TODO: Temporary
                console.log(el);
                console.log(this.scheduleDays);

                // Worked!
                // Нужно узнать индекс элемента..
                this.scheduleDays[0].subject = el;

>>>>>>> 79871f8992390eb4dd04ff69cb466bd66c6502ce
//                return {
//                    title: el.title,
//                    type: 1,
//                    teacher: el.teacher,
//                    cabinet: ''
//                };
            },
            addRoom(el) {
                el.room = prompt('Введіть номер кабінету');
            },
            removeSubject(list, index) {
                list.splice(index, 1);
            },
            fullNameTeacher(teacher) {
                return teacher.last_name + ' ' + teacher.first_name + ' ' + teacher.middle_name;
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
