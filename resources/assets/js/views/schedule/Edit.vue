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
                                   :options="{group: {name: 'subjects', pull: 'clone'}, sort: false}">
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
                <div class="schedule-column">
                    <h3>Понеділок</h3>
                    <draggable v-model="day1" class="dragArea" :options="{group: 'subjects'}">
                        <div v-for="(subject, index) in day1" :key="subject.id" class="subject-block">
                            <div>
                                <span>
                                    {{ subject.title + ' ' + subject.cabinet }}
                                    <a @click="removeSubject(day1, index)">
                                        <md-icon class="text-danger">delete</md-icon>
                                    </a>
                                    <a @click="addRoom(subject)">
                                        <md-icon class="md-primary">domain</md-icon>
                                    </a>
                                </span>
                            </div>
                            <div class="switcher-block">
                                <md-radio v-model="subject.type" md-value="1" class="md-primary">Лекція</md-radio>
                                <md-radio v-model="subject.type" md-value="2" class="md-primary">Практика</md-radio>
                            </div>

                            <!--TODO: Add footer btn - empty block-->
                        </div>
                    </draggable>
                </div>

            <!--TODO list -> day2, day3, day4, day5, day6, day7-->
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
            }
        },

        mounted() {
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
                    title: el.title,
                    type: 1,
                    teacher: el.teacher,
                    cabinet: ''
                };
            },
            addRoom(el) {
                el.cabinet = prompt('Введіть номер кабінету');
            },
            removeSubject(list, index) {
                list.splice(index, 1);
            },
            fullNameTeacher(teacher) {
                return teacher.first_name + ' ' + teacher.middle_name + ' ' + teacher.last_name;
            },
        },
    }
</script>
