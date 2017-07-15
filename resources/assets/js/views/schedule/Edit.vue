<template>
    <md-layout>
        <md-layout md-flex="100" class="subjects" md-gutter="24">
            <md-layout md-flex="100">
                <h1>Предмети</h1>
            </md-layout>
            <draggable :list="subjects" class="md-layout" :clone="clone" :options="{group:{ name:'days',  pull:'clone', put:false }}">
                <md-layout md-flex="10"
                           md-flex-xsmall="100"
                           md-flex-medium="20"
                           md-align="center"
                           md-vertical-align="center"
                           class="subject-block"
                           v-for="(element, index) in subjects" :key="index">
                    <span>{{element.name}}</span>
                </md-layout>
            </draggable>
        </md-layout>
        <md-layout md-flex="100" class="schedule">
            <md-layout md-flex="20"
                       md-flex-xsmall="100"
                       md-flex-small="50"
                       md-flex-medium="33"
                       md-align="center">
                <h2>Понеділок</h2>
                <draggable :list="day1" class="dragArea md-flex-100" :options="{group:'days'}">
                    <div v-for="(element, index) in day1" :key="index" @click="click(element)" class="subject-block">{{element.name}}</div>
                </draggable>
            </md-layout>
            <md-layout md-flex="20"
                       md-flex-xsmall="100"
                       md-flex-small="50"
                       md-flex-medium="33"
                       md-align="center">
                <h2>Вівторок</h2>
                <draggable :list="day2" class="dragArea md-flex-100" :options="{group:'days'}">
                    <div v-for="(element, index) in day2" :key="index" @click="click(element)" class="subject-block">{{element.name}}</div>
                </draggable>
            </md-layout>
            <md-layout md-flex="20"
                       md-flex-xsmall="100"
                       md-flex-small="50"
                       md-flex-medium="33"
                       md-align="center">
                <h2>Середа</h2>
                <draggable :list="day3" class="dragArea md-flex-100" :options="{group:'days'}">
                    <div v-for="(element, index) in day3" :key="index" @click="click(element)" class="subject-block">{{element.name}}</div>
                </draggable>
            </md-layout>
            <md-layout md-flex="20"
                       md-flex-xsmall="100"
                       md-flex-small="50"
                       md-flex-medium="33"
                       md-align="center">
                <h2>Четверг</h2>
                <draggable :list="day4" class="dragArea md-flex-100" :options="{group:'days'}">
                    <div v-for="(element, index) in day4" :key="index" @click="click(element)" class="subject-block">{{element.name}}</div>
                </draggable>
            </md-layout>
            <md-layout md-flex="20"
                       md-flex-xsmall="100"
                       md-flex-small="50"
                       md-flex-medium="33"
                       md-align="center">
                <h2>Пятниця</h2>
                <draggable :list="day5" class="dragArea md-flex-100" :options="{group:'days'}">
                    <div v-for="(element, index) in day5" :key="index" @click="click(element)" class="subject-block">{{element.name}}</div>
                </draggable>
            </md-layout>
        </md-layout>

        <div class="normal">
            <h2>Пример вывода для студентов</h2>
            <div>
                <div v-for="element in day1">{{element.name}}</div>
            </div>
        </div>
    </md-layout>
</template>

<script>
    import draggable from 'vuedraggable'

    export default{
        components: {
            draggable,
        },
        data() {
            return {
                subjects: [{
                    name: "Об'єктно орієнтоване програмування"
                }, {
                    name: "Операційні системи"
                }, {
                    name: "Веб дизайн"
                },{
                    name: "-"
                }],
                day1: [{
                    name: "Об'єктно орієнтоване програмування"
                }, {
                    name: "Операційні системи"
                }, {
                    name: "Веб дизайн"
                }],
                day2: [{
                    name: "Об'єктно орієнтоване програмування"
                }, {
                    name: "Операційні системи"
                }, {
                    name: "Веб дизайн"
                }],
                day3: [{
                    name: "Об'єктно орієнтоване програмування"
                }, {
                    name: "Операційні системи"
                }, {
                    name: "Веб дизайн"
                }],
                day4: [{
                    name: "Об'єктно орієнтоване програмування"
                }, {
                    name: "Операційні системи"
                }, {
                    name: "Веб дизайн"
                }],
                day5: [{
                    name: "Об'єктно орієнтоване програмування"
                }, {
                    name: "Операційні системи"
                }, {
                    name: "Веб дизайн"
                }],
            }
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
                    name: el.name
                };
            },
            replace: function() {
                this.list = [{
                    name: 'Edgard'
                }]
            }
        }
    }
</script>