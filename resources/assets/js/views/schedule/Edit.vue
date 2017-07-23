<template>
    <md-layout class="container edit-template">
        <md-theme md-name="block">
            <md-layout class="back-main">
                <div class="subjects phone-viewport">
                    <md-tabs md-fixed>
                        <md-tab md-icon="book">
                            <md-list class="md-dense">
                                <draggable :list="subjects" :clone="clone" :options="{group:{ name:'days', pull:'clone', put:false }}">
                                    <md-list-item class="subject-block" v-for="(element, index) in subjects" :key="index">
                                        <span>{{element.title}}</span>
                                    </md-list-item>
                                </draggable>
                            </md-list>
                        </md-tab>

                        <md-tab md-icon="people">
                            <p style="color:#fff;">Преподователь1</p>
                            <p style="color:#fff;">Преподователь2</p>
                        </md-tab>
                    </md-tabs>
                </div>
            </md-layout>
        </md-theme>

        <md-layout md-flex="70" class="right-column">
            <div class="schedule">
                <div class="schedule-column">
                    <h3>Понеділок</h3>
                    <draggable :list="day1" class="dragArea" :options="{group:'days'}">
                        <div v-for="(element, index) in day1" :key="index" class="subject-block list-subject-item">
                            <div class="lesson-number md-align-center md-vertical-align-center">{{index + 1}}</div>
                            <div class="subject-name md-align-center md-vertical-align-center">
                                <div class="md-flex-90">
                                    {{ element.title }}
                                </div>
                                <div class="md-flex-10" @click="removeSubject(day1, index)">
                                    <md-icon class="text-danger">delete</md-icon>
                                </div>
                            </div>
                        </div>
                    </draggable>
                </div>

                <div class="schedule-column">
                    <h3>Вівторок</h3>
                    <draggable :list="day2" class="dragArea md-flex-100" :options="{group:'days'}">
                        <div v-for="(element, index) in day2" :key="index" class="subject-block list-subject-item">
                            <div class="lesson-number md-align-center md-vertical-align-center">{{index + 1}}</div>
                            <div class="subject-name md-align-center md-vertical-align-center">
                                <div class="md-flex-90">
                                    {{ element.title }}
                                </div>
                                <div class="md-flex-10" @click="removeSubject(day2, index)">
                                    <md-icon class="text-danger">delete</md-icon>
                                </div>
                            </div>
                        </div>
                    </draggable>
                </div>

                <div class="schedule-column">
                    <h3>Середа</h3>
                    <draggable :list="day3" class="dragArea md-flex-100" :options="{group:'days'}">
                        <div v-for="(element, index) in day3" :key="index" class="subject-block list-subject-item">
                            <div class="lesson-number md-align-center md-vertical-align-center">{{index + 1}}</div>
                            <div class="subject-name md-align-center md-vertical-align-center">
                                <div class="md-flex-90">
                                    {{ element.title }}
                                </div>
                                <div class="md-flex-10" @click="removeSubject(day3, index)">
                                    <md-icon class="text-danger">delete</md-icon>
                                </div>
                            </div>
                        </div>
                    </draggable>
                </div>

                <div class="schedule-column">
                    <h3>Четверг</h3>
                    <draggable :list="day4" class="dragArea md-flex-100" :options="{group:'days'}">
                        <div v-for="(element, index) in day4" :key="index" class="subject-block list-subject-item">
                            <div class="lesson-number md-align-center md-vertical-align-center">{{index + 1}}</div>
                            <div class="subject-name md-align-center md-vertical-align-center">
                                <div class="md-flex-90">
                                    {{ element.title }}
                                </div>
                                <div class="md-flex-10" @click="removeSubject(day4, index)">
                                    <md-icon class="text-danger">delete</md-icon>
                                </div>
                            </div>
                        </div>
                    </draggable>
                </div>

                <div class="schedule-column">
                    <h3>Пятниця</h3>
                    <draggable :list="day5" class="dragArea md-flex-100" :options="{group:'days'}">
                        <div v-for="(element, index) in day5" :key="index" class="subject-block list-subject-item">
                            <div class="lesson-number md-align-center md-vertical-align-center">{{index + 1}}</div>
                            <div class="subject-name md-align-center md-vertical-align-center">
                                <div class="md-flex-90">
                                    {{ element.title }}
                                </div>
                                <div class="md-flex-10" @click="removeSubject(day5, index)">
                                    <md-icon class="text-danger">delete</md-icon>
                                </div>
                            </div>
                        </div>
                    </draggable>
                </div>
            </div>
        </md-layout>
    </md-layout>
</template>

<script>
    import draggable from 'vuedraggable'

    export default{
        components: {
            draggable,
        },

        props: [
            'faculty', 'course',
        ],

        data() {
            return {
                subjects: [],
                day1: [{
                    title: "Об'єктно-орієнтоване програмування"
                }, {
                    title: "Операційні системи"
                }, {
                    title: "Веб-дизайн"
                }],
                day2: [{
                    title: "Об'єктно-орієнтоване програмування"
                }, {
                    title: "Операційні системи"
                }, {
                    title: "Веб-дизайн"
                }],
                day3: [{
                    title: "Об'єктно-орієнтоване програмування"
                }, {
                    title: "Операційні системи"
                }, {
                    title: "Веб-дизайн"
                }],
                day4: [{
                    title: "Об'єктно-орієнтоване програмування"
                }, {
                    title: "Операційні системи"
                }, {
                    title: "Веб-дизайн"
                }],
                day5: [{
                    title: "Об'єктно-орієнтоване програмування"
                }, {
                    title: "Операційні системи"
                }, {
                    title: "Веб-дизайн"
                }],
            }
        },

        mounted() {
            axios.get('/api/subjects/faculty/' + this.faculty + '/course/' + this.course)
                .then(response => this.subjects = response.data);
        },

        methods: {
            click: function(item) {
                item.name="IT GETS CLONED";
            },
            add: function() {
                this.list.push({
                    name: 'Juan'
                });
            },
            clone: function(el){
                return {
                    title: el.title
                };
            },
            replace: function() {
                this.list = [{
                    name: 'Edgard'
                }]
            },
            removeSubject: function(list, index) {
                list.splice(index,1);
            }
        }
    }
</script>
