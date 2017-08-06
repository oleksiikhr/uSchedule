<template>
    <!--TODO: оформление не трогать, я обновлю-->
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
                        <draggable :list="subjects" :clone="clone" class="draggable"
                                   :options="{group:{ name:'days', pull:'clone', put:false }}">
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
                        <draggable :list="teachers" class="draggable" :options="{group: 'teachers'}">
                            <div :title="teacher.first_name + ' ' + teacher.middle_name + ' ' + teacher.last_name"
                                 class="teacher-block" v-for="teacher in filterTeachers" :key="teacher.id">
                                <span>{{ teacher.first_name + ' ' + teacher.middle_name + ' ' + teacher.last_name }}</span>
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
                    <draggable :list="day1" class="dragArea" :options="{ group:'days' }">
                        <div v-for="(element, index) in day1" :key="element.id" class="subject-block list-subject-item">
                            <div>
                                <span>
                                    {{ index + 1 }}
                                    {{ element.title + ' ' + element.cabinet }}<br>
                                    {{ element.teacher.middle_name +
                                    element.teacher.first_name + ' ' +
                                    element.teacher.last_name }}
                                    <a @click="removeSubject(day1, index)">
                                        <md-icon class="text-danger">delete</md-icon>
                                    </a>
                                    <a @click="addCabinet(element)">
                                        <md-icon class="md-primary">domain</md-icon>
                                    </a>
                                </span>
                            </div>
                            <div class="switcher-block">
                                <md-radio v-model="element.type" md-value="1" class="md-primary">Лекція</md-radio>
                                <md-radio v-model="element.type" md-value="2" class="md-primary">Практика</md-radio>
                            </div>
                            <draggable :options="{ group: 'teachers' }">
                                <!--TODO: For teachers-->
                            </draggable>

                            <!--TODO: Add footer btn - empty block-->
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
            'faculty', 'course',
        ],

        data() {
            return {
                subjects: [],
                teachers: [],
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
                }, {
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
                }],
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

                teachers = teachers.filter(function(item) {
                    if ((item.first_name + ' ' + item.middle_name + ' ' + item.last_name).toLowerCase().indexOf(search) !== -1) {
                        return item;
                    }
                });

                return teachers;
            },
        },

        methods: {
            click(item) {
                item.name="IT GETS CLONED";
            },
            add() {
                this.list.push({
                    name: 'Juan'
                });
            },
            clone(el) {
                return {
                    title: el.title,
                    type: 1,
                    teacher: el.teacher,
                    cabinet: ''
                };
            },
            addCabinet(el){
                let cabinet = prompt('Введіть номер кабінету');
                el.cabinet = cabinet;
            },
            replace() {
                this.list = [{
                    name: 'Edgard'
                }]
            },
            removeSubject(list, index) {
                list.splice(index, 1);
            },
        },
    }
</script>
