<template>
    <md-layout class="edit-template">
        <md-theme md-name="block">
            <md-layout class="left-column">
                <div class="subjects phone-viewport">
                    <md-tabs md-fixed>
                        <md-tab md-icon="book">
                            <md-list class="md-dense">
                                <!--TODO: Skip block-->
                                <draggable :list="subjects" :clone="clone" :options="{group:{ name:'days', pull:'clone', put:false }}">
                                    <md-list-item class="subject-block" v-for="(element, index) in subjects" :key="index">
                                        <span>{{element.title}}</span>
                                    </md-list-item>
                                </draggable>
                            </md-list>
                        </md-tab>

                        <md-tab md-icon="people">
                            <p style="color: rgba(255, 255, 255, .87);">Преподователь1</p>
                            <p style="color: rgba(255, 255, 255, .87);">Преподователь2</p>
                        </md-tab>
                    </md-tabs>
                </div>
            </md-layout>
        </md-theme>

        <md-layout md-flex="75" class="right-column">
            <div class="schedule">

                <div class="schedule-column">
                    <h3>Понеділок</h3>

                    <span>Пара</span>
                    <span>Предмет</span>
                    <span>Викладач</span>
                    <span>Видалення</span>

                    <!--TODO: if empty => not working-->
                    <draggable :list="day1" class="dragArea" :options="{group:'days'}">
                        <div v-for="(element, index) in day1" :key="index" class="subject-block list-subject-item">
                            {{index + 1}}
                            {{ element.title }}
                            <a @click="removeSubject(day1, index)">
                                <md-icon class="text-danger">delete</md-icon>
                            </a>
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
    import MdList from "../../../../../node_modules/vue-material/src/components/mdList/mdList.vue";

    export default{
        components: {
            MdList,
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
