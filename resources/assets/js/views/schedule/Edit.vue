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
                <div class="schedule-column" v-for="(day, dayNum) in days" :key="dayNum">
                    <h3>{{ daysWeek[dayNum] }}</h3>
                    <draggable :list="days[dayNum]" class="dragArea" :options="{group:'days'}">
                        <div v-for="(element, index) in day" :key="element.id" class="subject-block list-subject-item">
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
            'inSchedule', 'inScheduleDays', 'inSubjects', 'inTeachers'
        ],

        created() {
            this.scheduleDays = JSON.parse(this.inScheduleDays);
            this.schedule = JSON.parse(this.inSchedule);
            this.subjects = JSON.parse(this.inSubjects);
            this.teachers = JSON.parse(this.inTeachers);
        },

        data() {
            return {
                scheduleDays: [],
                schedule: [],
                subjects: [],
                teachers: [],

                searchSubject: '',
                searchTeacher: '',

                days: [[],[],[],[],[],[]],
                daysWeek: ['Понеділок', 'Вівторок', 'Середа', 'Четверг', 'П\'ятниця', 'Субота'],
            }
        },

        mounted() {
            let count = this.scheduleDays.length;

            for (let i = 0; i < count; i++) {
                for (let day = 0; day < 6; day++) {
                    if (this.scheduleDays[i].day === day) {
                        this.days[day].push(this.scheduleDays[i]);
                    }
                }
            }

            for (let i = 0; i < this.days.length; i++) {
                for (let j = 0; j < this.days[i].length; j++) {
                    console.log(this.days[i][j].day);
                }
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
                return teacher.last_name + ' ' + teacher.first_name + ' ' + teacher.middle_name;
            },
        },
    }
</script>
