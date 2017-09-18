<template>
    <md-theme>
        <md-toolbar class="md-dense">
            <md-button class="md-icon-button" @click="toggleLeftSidenav">
                <md-icon>menu</md-icon>
            </md-button>

            <md-button href="/">Розклад КНТЕУ</md-button>
            <span style="flex: 1"></span>

            <template v-if="!u">
                <md-button href="/login">Увійти</md-button>
                <md-button href="/register" class="md-raised">Реєстрація</md-button>
            </template>
            <template v-else>
                <md-button v-if="u.group_id" class="md-raised" :href="'/group/' + u.group_id">
                    Розклад
                </md-button>
            </template>
        </md-toolbar>

        <md-theme>
            <md-sidenav class="md-left" ref="leftSidenav">
                <md-toolbar>
                    <div class="md-toolbar-container">
                        <h3 class="md-title">Профіль</h3>
                    </div>
                </md-toolbar>

                <md-list>
                    <md-list-item href="/">
                        <md-icon>home</md-icon> <span>Головна сторінка</span>
                    </md-list-item>
                    <md-list-item v-if="u && u.group_id" :href="'/group/' + u.group_id">
                        <md-icon>schedule</md-icon> <span>Розклад групи</span>
                    </md-list-item>
                    <md-list-item href="/news">
                        <md-icon>description</md-icon> <span>Новини</span>
                    </md-list-item>
                    <md-list-item v-if="u" href="/settings">
                        <md-icon>settings</md-icon> <span>Налаштування</span>
                    </md-list-item>

                    <template v-if="u">
                        <br>

                        <!--TODO: isCan-->
                        <md-list-item href="/news/create">
                            <md-icon>add</md-icon> <span>Написати новину</span>
                        </md-list-item>

                        <!--TODO: isCan-->
                        <md-list-item v-if="u.group_id" :href="'/schedule/' + u.group_id + '/edit'">
                            <md-icon>edit</md-icon> <span>Відредагувати розклад</span>
                        </md-list-item>
                    </template>
                </md-list>

                <md-toolbar>
                    <div class="md-toolbar-container">
                        <h3 class="md-title">Дзвінки</h3>
                    </div>
                </md-toolbar>

                <md-table v-if="time">
                    <md-table-header>
                        <md-table-row>
                            <md-table-head>Пара</md-table-head>
                            <md-table-head>Початок</md-table-head>
                            <md-table-head>Кінець</md-table-head>
                        </md-table-row>
                    </md-table-header>
                    <md-table-body>
                        <md-table-row v-for="(item, i) in time.length" :key="i">
                            <md-table-cell>{{ i + 1 }}</md-table-cell>
                            <md-table-cell>{{ time[i][0] }}</md-table-cell>
                            <md-table-cell>{{ time[i][1] }}</md-table-cell>
                        </md-table-row>
                    </md-table-body>
                </md-table>
            </md-sidenav>
        </md-theme>
    </md-theme>
</template>

<script>
//    TODO: add Moment.js for time (color*)

    export default {
        props: [
            'user', 'time',
        ],

        data () {
            return {
                u: this.user,
            }
        },

        methods: {
            toggleLeftSidenav() {
                this.$refs.leftSidenav.toggle();
            },
        },
    }
</script>
