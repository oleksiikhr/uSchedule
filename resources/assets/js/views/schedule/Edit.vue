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

                    <div :class="'week week-'+week" v-for="week in 2">
                        <div :class="'day day-'+day" v-for="day in 6">
                            <h3>{{ weeks[day - 1] }}</h3>
                            <draggable v-model="scheduleDays" :options="{group:'subjects'}">
                                <div v-if="schedule.week == week && schedule.day == day"
                                     v-for="schedule in scheduleDays" :key="schedule.id">
                                    {{ schedule }}
                                </div>
                            </draggable>
                        </div>
                    </div>

                </div>
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
            this.schedule = JSON.parse(this.inSchedule);
            this.subjects = JSON.parse(this.inSubjects);
            this.teachers = JSON.parse(this.inTeachers);
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
            }
        },

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
                // TODO: Temporary
                console.log(el);
                console.log(this.scheduleDays);

                // Worked!
                // Нужно узнать индекс элемента..
                this.scheduleDays[0].subject = el;

//                return {
//                    title: el.title,
//                    type: 1,
//                    teacher: el.teacher,
//                    cabinet: ''
//                };
            },
            addRoom(el) {
                el.cabinet = prompt('Введіть номер кабінету');
            },
            removeSubject(list, index) {
                list.splice(index, 1);
            },
            fullNameTeacher(teacher) {
                return teacher.last_name + ' ' + teacher.first_name + ' ' + teacher.middle_name;
            },
        },
    }
</script>
