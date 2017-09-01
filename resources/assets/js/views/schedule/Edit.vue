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

                        <draggable class="week-schedule" :list="days[0][day - 1]" element="table" @start="startSubjectRight"
                                   :move="moveSubject" @end="endSubject" :options="{group: 'subjects'}" :week="0" :day="day - 1">
                            <tr v-for="(schedule, index) in days[0][day - 1]" :key="schedule.id">
                                <td class="element">
                                    <div class="left">
                                        <span class="title">{{ schedule.subject.title }}</span>
                                        <!--TODO: config teacher draggable-->
                                        <draggable class="teacher" :options="{group: 'teachers', draggable: '.item'}">
                                            <span v-if="schedule.subject.teacher_id > 0" :week="0" :day="day - 1" :index="index"
                                                  :title="fullNameTeacher(schedule.subject.teacher)" :class="isMoving ? 'item' : ''">
                                                {{ shortNameTeacher(schedule.subject.teacher) }}
                                            </span>
                                            <span v-else :week="0" :day="day - 1" :index="index" :class="isMoving ? 'item no' : 'no'">
                                                Викладача не вказано
                                            </span>
                                        </draggable>
                                    </div>

                                    <div class="right">
                                        <!--TODO: styles-->
                                        <div class="cabinet">
                                            <!--<a @click="editRoom(0, day - 1, index)">-->
                                                <!--<span v-if="schedule.room">{{ schedule.room }}</span>-->
                                                <!--<md-icon v-else>business</md-icon>-->
                                            <!--</a>-->
                                        </div>

                                        <!--TODO: create type-->
                                        <div class="type">

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </draggable>

                        <!--Temporary-->
                        <draggable :list="days[1][day - 1]" element="table" :options="{group: 'subjects'}">
                            <tr v-for="(schedule, index) in days[1][day - 1]" :key="schedule.id">
                                <td>
                                    {{ schedule.subject.title }} - Don't touch!
                                </td>
                            </tr>
                        </draggable>
                    </tr>
                    </tbody>
                </table>


                <!--<md-button class="md-raised md-primary" @click="saveSchedule">Сохранить</md-button>-->
                <!--<div class="schedule">-->
                    <!--<div :class="'week week-' + (weekNum + 1)" v-for="(week, weekNum) in days" :key="weekNum">-->
                        <!--&lt;!&ndash;<h2 class="week-title">{{ weekNum + 1 }} неділя</h2>&ndash;&gt;-->
                        <!--<div class="schedule-column" v-for="(day, dayNum) in week" :key="dayNum">-->
                            <!--<h3>{{ daysWeek[dayNum] }}</h3>-->
                            <!--<draggable :list="week[dayNum]" class="dragArea" :options="{group: 'subjects', draggable: '.draggable'}">-->
                                <!--<md-card md-with-hover v-for="(element, index) in day" :key="element.id" class="draggable">-->
                                    <!--<template v-if="element.id > 0">-->
                                        <!--<md-card-header>-->
                                            <!--<md-card-header-text>-->
                                                <!--<div class="md-title">{{ element.subject.title }}</div>-->
                                                <!--<div v-if="element.subject.teacher" :title="fullNameTeacher(element.subject.teacher)" class="md-subhead">-->
                                                    <!--<span v-if="element.subject.teacher.length > 0">{{ shortNameTeacher(element.subject.teacher) }}</span>-->
                                                <!--</div>-->
                                            <!--</md-card-header-text>-->

                                            <!--<md-button class="md-icon-button" @click="editRoom(weekNum, dayNum, index)">-->
                                                <!--<span v-if="element.room">{{ element.room }}</span>-->
                                                <!--<md-icon v-else>business</md-icon>-->
                                            <!--</md-button>-->
                                        <!--</md-card-header>-->

                                        <!--&lt;!&ndash;<md-card-content>&ndash;&gt;-->

                                        <!--&lt;!&ndash;</md-card-content>&ndash;&gt;-->

                                        <!--<md-card-actions>-->
                                            <!--<div class="time">-->
                                                <!--<md-icon>schedule</md-icon>-->
                                                <!--<span v-if="time[index]">{{ time[index][0] + ' - ' + time[index][1] }}</span>-->
                                                <!--<span v-else>Час відсутній</span>-->
                                            <!--</div>-->
                                            <!--<span style="flex: 1"></span>-->
                                            <!--<md-switch></md-switch>-->
                                        <!--</md-card-actions>-->

                                        <!--&lt;!&ndash;<draggable v-if="isMoving" :options="{group: 'teachers'}">&ndash;&gt;-->
                                            <!--&lt;!&ndash;<span :index="index" :day="dayNum">For Teachers - {{ dayNum + ' ' + index }}</span> &lt;!&ndash; Temporary &ndash;&gt;&ndash;&gt;-->
                                        <!--&lt;!&ndash;</draggable>&ndash;&gt;-->

                                        <!--&lt;!&ndash;<md-card-actions>&ndash;&gt;-->
                                            <!--&lt;!&ndash;<md-button class="md-icon-button md-accent" @click="removeSubject(days[dayNum], index)">&ndash;&gt;-->
                                                <!--&lt;!&ndash;<md-icon>delete</md-icon>&ndash;&gt;-->
                                            <!--&lt;!&ndash;</md-button>&ndash;&gt;-->
                                        <!--&lt;!&ndash;</md-card-actions>&ndash;&gt;-->
                                    <!--</template>-->

                                    <!--<template v-else>-->
                                        <!--<div class="no-pair">-->
                                            <!--<div class="time">-->
                                                <!--<md-icon>schedule</md-icon>-->
                                                <!--<span v-if="time[index]">{{ time[index][0] + ' - ' + time[index][1] }}</span>-->
                                                <!--<span v-else>Час відсутній</span>-->
                                            <!--</div>-->
                                        <!--</div>-->
                                    <!--</template>-->
                                <!--</md-card>-->
                            <!--</draggable>-->

                            <!--<md-button v-if="days[weekNum][dayNum].length < 7" slot="footer" class="footer-btn"-->
                                        <!--title="Пара відсутня" @click="addEmptySubject(weekNum, dayNum)">-->
                                <!--<md-icon>add</md-icon>-->
                            <!--</md-button>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
            </md-layout>

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
        </md-layout>
    </md-theme>
</template>

<script>
    import pnotify from 'pnotify'
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable,
            pnotify,
        },

        props: [
            'inSchedule', 'inScheduleDays', 'inSubjects', 'inTeachers', 'inTime',
        ],

        created() {
            this.scheduleDays = JSON.parse(this.inScheduleDays);
            this.schedule = JSON.parse(this.inSchedule);
            this.subjects = JSON.parse(this.inSubjects);
            this.teachers = JSON.parse(this.inTeachers);
            this.time = JSON.parse(this.inTime);
        },

        data() {
            return {
                // Props
                scheduleDays: [],
                schedule: [],
                subjects: [],
                teachers: [],

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
                time: [],
                days: [ [[],[],[],[],[],[]], [[],[],[],[],[],[]] ],
                daysWeek: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],

                errors: {},
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
                    .then(this.onSuccess)
                    .catch(error => this.errors = error.response);
            },
            onSuccess(response) {
                new pnotify({
                    title: 'Розклад збережено',
                    text: false,
                    icon: true,
                    type: 'success',
                    styling: 'brighttheme',
                    buttons: {
                        closer: true
                    }
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
                    subject: {
                        id: el.id,
                        title: el.title,
                        course: el.course,
                        faculty_id: el.faculty_id,
                        teacher: [],
                        teacher_id: -1,
                    },
                };
            },
            moveSubject(evt, originalEvent) {
                this.isDelete = !evt.relatedContext.list;

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
                        .subject.teacher = this.fromTeacher;
                    this.days[this.toElement.week.value][this.toElement.day.value][this.toElement.index.value]
                        .subject.teacher_id = this.fromTeacher.id;
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
