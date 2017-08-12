<template>
    <md-layout class="edit-template">
        <md-layout md-flex="25" class="left-column">
            <div class="left-list phone-viewport">
                <draggable :options="{group: {name: ['subjects', 'teachers']}}" class="delete-choose" v-if="isMoving">
                    <md-icon :class="'md-size-4x delete' + (isDelete ? ' deleted' : '')">
                        {{ isDelete ? 'delete_forever' : 'delete' }}
                    </md-icon>
                </draggable>

                <md-tabs md-fixed>
                    <md-tab md-icon="book">
                        <form novalidate @submit.stop.prevent="submit">
                            <md-input-container>
                                <label>Пошук предмету</label>
                                <md-input v-model="searchSubject"></md-input>
                            </md-input-container>
                        </form>
                        <draggable :list="filterSubjects" element="md-list" :clone="cloneSubject" :move="moveSubject" @end="endSubject"
                                   :options="{group: {name: 'subjects', pull: 'clone', put: false}, sort: false}">
                            <md-list-item :title="subject.title" class="subject-block"
                                          v-for="subject in filterSubjects" :key="subject.id">
                                {{ subject.title }}
                            </md-list-item>
                        </draggable>
                    </md-tab>

                    <md-tab md-icon="people">
                        <form novalidate @submit.stop.prevent="submit">
                            <md-input-container>
                                <label>Пошук викладача</label>
                                <md-input v-model="searchTeacher"></md-input>
                            </md-input-container>
                        </form>
                        <draggable :list="filterTeachers" element="md-list" :clone="cloneTeacher" :move="moveTeacher" @end="endTeacher"
                                   :options="{group: {name: 'teachers', pull: 'clone', put: false}, sort: false}">
                            <md-list-item :title="fullNameTeacher(teacher)" class="teacher-block"
                                          v-for="teacher in filterTeachers" :key="teacher.id">
                                <span>{{ fullNameTeacher(teacher) }}</span>
                                <span v-if="teacher.academic_title">[{{ teacher.academic_title}}]</span>
                            </md-list-item>
                        </draggable>
                    </md-tab>
                </md-tabs>
            </div>
        </md-layout>

        <md-layout md-flex="75" class="right-column">
            <div class="schedule">
                <div class="week week-1">
                    <div class="schedule-column" v-for="(day, dayNum) in days" :key="dayNum">
                        <h3>{{ daysWeek[dayNum] }}</h3>
                        <draggable :list="days[dayNum]" class="dragArea" :options="{group: 'subjects', draggable: '.draggable'}">
                            <md-card md-with-hover v-for="(element, index) in day" :key="element.id" class="draggable">
                                <md-card-header>
                                    <md-card-header-text>
                                        <div class="md-title">{{ element.subject.title }}</div>
                                        <div v-if="element.subject.teacher.id" :title="fullNameTeacher(element.subject.teacher)" class="md-subhead">
                                            {{ shortNameTeacher(element.subject.teacher) }}
                                        </div>
                                    </md-card-header-text>

                                    <md-button class="md-icon-button" @click="openDialog('dialog6')">
                                        <span v-if="element.room">{{ element.room }}</span>
                                        <md-icon v-else>business</md-icon>
                                    </md-button>
                                </md-card-header>

                                <!--<md-card-content>-->

                                <!--</md-card-content>-->

                                <md-card-actions>
                                    <div class="time">
                                        <md-icon>schedule</md-icon>
                                        <span v-if="time[index]">{{ time[index][0] + ' - ' + time[index][1] }}</span>
                                        <span v-else>Час відсутній</span>
                                    </div>
                                    <span style="flex: 1"></span>
                                    <md-switch></md-switch>
                                </md-card-actions>

                                <!--<draggable v-if="isMoving" :options="{group: 'teachers'}">-->
                                    <!--<span :index="index" :day="dayNum">For Teachers - {{ dayNum + ' ' + index }}</span> &lt;!&ndash; Temporary &ndash;&gt;-->
                                <!--</draggable>-->

                                <!--<md-card-actions>-->
                                    <!--<md-button class="md-icon-button md-accent" @click="removeSubject(days[dayNum], index)">-->
                                        <!--<md-icon>delete</md-icon>-->
                                    <!--</md-button>-->
                                <!--</md-card-actions>-->
                            </md-card>

                            <!--<md-button slot="footer" class="md-accent" @click="addEmptySubject">-->
                                <!--Додати порожню пару-->
                            <!--</md-button>-->
                        </draggable>
                    </div>
                </div>
            </div>
        </md-layout>

        <md-dialog-prompt
                :md-title="prompt.title"
                :md-ok-text="prompt.ok"
                :md-cancel-text="prompt.cancel"
                v-model="prompt.value"
                ref="dialog6">
        </md-dialog-prompt>
    </md-layout>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable,
        },

        props: [
            'inSchedule', 'inScheduleDays', 'inSubjects', 'inTeachers', 'inTime'
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
                scheduleDays: [],
                schedule: [],
                subjects: [],
                teachers: [],

                searchSubject: '',
                searchTeacher: '',

                fromTeacher: null,
                toElement: null,
                isMoving: false,
                isDelete: true,

                days: [[],[],[],[],[],[]],
                time: [],
                daysWeek: ['Понеділок', 'Вівторок', 'Середа', 'Четверг', 'П\'ятниця', 'Субота'],

                prompt: {
                    title: 'What\'s your name?',
                    ok: 'Done',
                    cancel: 'Cancel',
                    id: 'name',
                    name: 'name',
                    placeholder: 'Type your name...',
                    maxlength: 4,
                    value: ''
                }
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
            openDialog(ref) {
                this.$refs[ref].open();
            },
            addRoom(el) {
                el.room = prompt('Введіть номер кабінету');
            },

            // Subject
            cloneSubject(el) {
                this.isMoving = true;

                return {
                    id: el.id,
                    room: '',
                    subject: {
                        id: el.id,
                        title: el.title,
                        course: el.course,
                        faculty_id: el.faculty_id,
                        teacher: [],
                    },
                };
            },
            moveSubject(evt, originalEvent) {
                this.isDelete = !evt.relatedContext.list;
            },
            endSubject(el) {
                this.isMoving = false;
            },
            removeSubject(list, index) {
                list.splice(index, 1);
            },
            addEmptySubject() {
                return 1;
            },

            // Teachers
            cloneTeacher(el) {
                this.isMoving = true;
                this.toElement = null;
                this.fromTeacher = el;
            },
            moveTeacher(evt, originalEvent) {
                if (! evt.related.className) {
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
                    this.days[this.toElement.day.value][this.toElement.index.value].subject.teacher = this.fromTeacher;
                    this.days[this.toElement.day.value][this.toElement.index.value].subject.teacher_id = this.fromTeacher.id;
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
