<template>
    <md-theme md-name="edit">
        <md-layout class="edit-template">
            <md-layout md-flex="20" class="left-column">
                <div class="left-list phone-viewport">
                    <draggable :options="{group: {name: ['subjects', 'teachers']}}" class="delete-choose" v-if="isMoving">
                        <md-icon :class="'md-size-4x delete' + (isDelete ? ' deleted' : '')">
                            {{ isDelete ? 'delete_forever' : 'delete' }}
                        </md-icon>
                    </draggable>

                    <md-tabs md-fixed>
                        <md-tab md-icon="book">
                            <form class="left-search" novalidate @submit.stop.prevent="submit">
                                <md-input-container md-inline md-clearable>
                                    <md-icon>search</md-icon>
                                    <label>Предмет</label>
                                    <md-input v-model="searchSubject"></md-input>
                                </md-input-container>
                            </form>
                            <draggable :list="filterSubjects" element="md-list" :clone="cloneSubject" :move="moveSubject" @end="endSubject"
                                       :options="{group: {name: 'subjects', pull: 'clone', put: false}, sort: false}">
                                <md-list-item :title="subject.title" class="subject-block left-block card-ripple"
                                              v-for="subject in filterSubjects" :key="subject.id">
                                    <span class="name">{{ subject.title }}</span>
                                </md-list-item>
                            </draggable>
                        </md-tab>

                        <md-tab md-icon="people">
                            <form class="left-search" novalidate @submit.stop.prevent="submit">
                                <md-input-container md-inline md-clearable>
                                    <md-icon>search</md-icon>
                                    <label>Викладач</label>
                                    <md-input v-model="searchTeacher"></md-input>
                                </md-input-container>
                            </form>
                            <draggable :list="filterTeachers" element="md-list" :clone="cloneTeacher" :move="moveTeacher" @end="endTeacher"
                                       :options="{group: {name: 'teachers', pull: 'clone', put: false}, sort: false}">
                                <md-list-item :title="fullNameTeacher(teacher)" class="teacher-block left-block"
                                              v-for="teacher in filterTeachers" :key="teacher.id">
                                    <span class="name">{{ fullNameTeacher(teacher) }}</span>
                                    <span class="extra" v-if="teacher.academic_title">{{ teacher.academic_title}}</span>
                                </md-list-item>
                            </draggable>
                        </md-tab>
                    </md-tabs>
                </div>
            </md-layout>

            <md-layout md-flex="80" class="right-column">
                <md-button class="md-raised md-primary" @click="saveSchedule">Зберегти розклад</md-button>
                <table class="schedule">
                    <thead>
                    <tr>
                        <td class="color min"></td>
                        <td class="color min"></td>
                        <td class="color">1 тиждень</td>
                        <td class="color">2 тиждень</td>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="day in time.length - 1" :key="day">
                        <td class="week-day color"><span>{{ daysWeek[day - 1] }}</span></td>

                        <table class="week-lesson color">
                            <tr v-for="lesson in Math.max(days[0][day - 1].length, days[1][day - 1].length)" :key="lesson"
                                :title="time[lesson - 1][0] + ' - ' + time[lesson - 1][1]" v-if="time[lesson - 1]">
                                <td>{{ lesson }}</td>
                            </tr>
                        </table>

                        <template v-for="week in 2">
                            <draggable :class="'week-schedule' + (isMoving && days[week - 1][day - 1].length < time.length ? ' draggable' : '')"
                                       :list="days[week - 1][day - 1]" element="table" @start="startSubjectRight" :move="moveSubject"
                                       @end="endSubject" :options="{group: 'subjects', draggable: '.item'}" :week="week - 1" :day="day - 1">
                                <tr class="item" v-for="(schedule, index) in days[week - 1][day - 1]" :key="index">
                                    <td class="element" v-if="schedule.is_empty === 0">
                                        <div class="type" :title="types[schedule.type][1]" @click="changeType(week - 1, day - 1, index)">
                                            <span>{{ types[schedule.type][0] }}</span>
                                        </div>

                                        <div class="right">
                                            <div class="info">
                                                <span class="title">{{ schedule.subject.title }}</span>
                                                <!--TODO: support array teachers-->
                                                <draggable class="teacher" :options="{group: 'teachers', draggable: '.teacher-item'}">
                                                    <span v-if="schedule.teachers.length < 1" :week="week - 1" :day="day - 1" :index="index" class="teacher-item no">
                                                        Викладача не вказано
                                                    </span>
                                                    <span v-else v-for="teacher in schedule.teachers" :week="week - 1" :day="day - 1" :index="index"
                                                          :title="fullNameTeacher(teacher.teacher)" class="teacher-item">
                                                        {{ shortNameTeacher(teacher.teacher) }}
                                                    </span>
                                                </draggable>
                                            </div>

                                            <div class="additionally">
                                                <div v-if="schedule.teachers.length > 1" class="more-teachers">
                                                    <span title="Кількість підгруп">{{ schedule.teachers.length }}</span>
                                                </div>

                                                <a class="cabinet" @click="editRoom(week - 1, day - 1, index)">
                                                    <span v-if="schedule.room">{{ schedule.room }}</span>
                                                    <md-icon v-else>business</md-icon>
                                                </a>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="element no-pair" v-else></td>
                                </tr>

                                <md-button v-if="days[week - 1][day - 1].length < 7 && !isMoving" class="footer-btn"
                                           title="Додати порожню пару" @click="addEmptySubject(week - 1, day - 1)">
                                    <md-icon>add</md-icon>
                                </md-button>
                            </draggable>
                        </template>
                    </tr>
                    </tbody>
                </table>
            </md-layout>

            <!--TODO: replace inline method-->
            <md-dialog ref="room">
                <md-dialog-title>Номер аудиторії</md-dialog-title>

                <md-dialog-content>
                    <form novalidate @submit.stop.prevent="submit">
                        <md-input-container>
                            <md-input v-model="dialogRoom"></md-input>
                        </md-input-container>
                    </form>
                </md-dialog-content>

                <md-dialog-actions>
                    <md-button class="md-primary" @click="closeRoom()">Відмінити</md-button>
                    <md-button class="md-primary" @click="saveRoom()">Зберегти</md-button>
                </md-dialog-actions>
            </md-dialog>
            <md-snackbar :md-position="'top right'" ref="snackbar" :md-duration="5000">
                <span v-text="message"></span>
                <md-button @click="$refs.snackbar.close()">Сховати</md-button>
            </md-snackbar>
        </md-layout>
    </md-theme>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable,
        },

        props: {
            'schedule': {
                type: Object,
                required: true,
            },
            'scheduleDays': {
                type: Array,
                required: true,
            },
            'subjects': {
                type: Array,
                required: true,
            },
            'teachers': {
                type: Array,
                required: true,
            },
            'time': {
                type: Array,
                required: true,
            },
            'daysWeek': {
                type: Array,
                required: true,
            },
            'types': {
                type: Array,
                required: true,
            }
        },

        data() {
            return {
                // Search
                searchSubject: '',
                searchTeacher: '',

                // Draggable
                fromTeacher: null,
                toElement: null,
                isMoving: false,
                isDelete: true,
                deleteSubject: null,

                // Dialog
                openedWeekIndex: null,
                openedDayIndex: null,
                openedIndex: null,
                dialogRoom: null,

                // Other
                days: [[[], [], [], [], [], []], [[], [], [], [], [], []]],

                message: '',
                response: null,
            }
        },

        mounted() {
            let count = this.scheduleDays.length;

            for (let week = 0; week < 2; week++) {
                for (let i = 0; i < count; i++) {
                    for (let day = 0; day < 6; day++) {
                        if (this.scheduleDays[i].week === week && this.scheduleDays[i].day === day) {
                            this.days[week][day].push(this.scheduleDays[i]);
                        }
                    }
                }
            }

            console.log(this.days);
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
            // Type
            changeType(week, day, index) {
                this.days[week][day][index].type = (this.days[week][day][index].type + 1) % this.types.length;
            },

            // Room
            addRoom(el) {
                el.room = prompt('Введіть номер кабінету');
            },
            editRoom(week, day, index) {
                this.$refs['room'].open();

                this.openedWeekIndex = week;
                this.openedDayIndex = day;
                this.openedIndex = index;

                this.dialogRoom = this.days[week][day][index].room;
            },
            saveRoom() {
                this.days[this.openedWeekIndex][this.openedDayIndex][this.openedIndex].room = this.dialogRoom;

                this.closeRoom();
            },
            closeRoom() {
                this.$refs['room'].close();
            },

            // Save schedule
            saveSchedule() {
                axios.post('/schedule', this.days)
                    .then(res => {
                        this.message = 'Розклад збережено';

                        this.$nextTick(() => {
                            this.$refs.snackbar.open();
                        });
                    })
                    .catch(error => {
                        this.message = error.response.data.message;

                        this.$nextTick(() => {
                            this.$refs.snackbar.open();
                        });
                    });
            },

            // Subject
            cloneSubject(el) {
                this.isMoving = true;
                this.isDelete = true;

                return {
                    id: el.id,
                    room: '',
                    schedule_id: this.schedule.id,
                    type: 0,
                    is_empty: 0,
                    teachers: [],
                    subject: {
                        id: el.id,
                        title: el.title,
                        course: el.course,
                        faculty_id: el.faculty_id,
                    },
                };
            },
            moveSubject(evt, originalEvent) {
                this.isDelete = !evt.relatedContext.list;

                // TODO: Protect draggable after "+", but can't return back
                if (evt.to == evt.from && evt.relatedContext.list.length == 1) {
                    return false;
                }

                if (evt.to != evt.from) {
                    this.deleteSubject = evt.relatedContext.list && evt.relatedContext.list.length > this.time.length - 1
                        ? evt.to.attributes
                        : null;
                } else {
                    this.deleteSubject = null;
                }
            },
            endSubject(el) {
                this.isMoving = false;

                if (this.deleteSubject) {
                    this.days[this.deleteSubject.week.value][this.deleteSubject.day.value]
                        .splice(this.days[this.deleteSubject.week.value][this.deleteSubject.day.value].length - 1, 1);
                    this.deleteSubject = null;
                }
            },
            removeSubject(list, index) {
                list.splice(index, 1);
            },
            addEmptySubject(week, day) {
                this.days[week][day].push({
                    id: -1,
                    room: 0,
                    schedule_id: this.schedule.id,
                    type: 0,
                    is_empty: 1,
                    teachers: [],
                    subject: {
                        id: 0,
                        title: '',
                        course: 0,
                        faculty_id: 0,
                    },
                });
            },
            startSubjectRight() {
                this.isMoving = true;
                this.isDelete = false;
            },

            // Teachers
            cloneTeacher(el) {
                this.isMoving = true;
                this.isDelete = true;
                this.toElement = null;
                this.fromTeacher = el;
            },
            moveTeacher(evt, originalEvent) {
                if (evt.related.attributes.week) {
                    this.isDelete = false;
                    this.toElement = evt.related.attributes;
                } else {
                    this.isDelete = true;
                    this.toElement = null;
                }
            },
            endTeacher(el) {
                this.isMoving = false;

                if (this.toElement) {
                    this.days[this.toElement.week.value][this.toElement.day.value][this.toElement.index.value]
                        .teachers.push({
                        teacher: {
                            academic_title: this.fromTeacher.academic_title,
                            first_name: this.fromTeacher.first_name,
                            id: this.fromTeacher.id,
                            last_name: this.fromTeacher.last_name,
                            middle_name: this.fromTeacher.middle_name
                        }
                        });
                    this.days[this.toElement.week.value][this.toElement.day.value][this.toElement.index.value]
                        .teacher_id = this.fromTeacher.id;
                }
            },
            fullNameTeacher(teacher) {
                return teacher.last_name + ' ' + teacher.first_name + ' ' + teacher.middle_name;
            },
            shortNameTeacher(teacher) {
                return teacher.last_name + ' ' + teacher.first_name.charAt(0) + '. '
                    + teacher.middle_name.charAt(0) + '.';
            },
        },
    }
</script>
