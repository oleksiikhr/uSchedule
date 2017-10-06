<template>
    <v-app>
        <v-navigation-drawer persistent enable-resize-watcher disable-route-watcher clipped app
                             :mini-variant.sync="mini" v-model="drawer">
            <v-toolbar flat>
                <v-list class="pa-0">
                    <v-list-tile>
                        <v-list-tile-avatar>
                            <img src="/img/logo_200.png" alt="КНТЕУ">
                        </v-list-tile-avatar>
                        <v-list-tile-content>
                            <v-list-tile-title class="h-title">Розклад КНТЕУ</v-list-tile-title>
                        </v-list-tile-content>
                        <v-list-tile-action>
                            <v-btn icon @click.native.stop="mini = !mini">
                                <v-icon>chevron_left</v-icon>
                            </v-btn>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list>
            </v-toolbar>

            <v-list class="pt-0">
                <template v-for="(item, i) in items">
                    <v-divider v-if="item.divider" dark class="my-4" :key="i"></v-divider>

                    <v-list-tile v-else :to="item.to">
                        <v-list-tile-action >
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>{{ item.text }}</v-list-tile-title>
                        </v-list-tile-content>
                        <v-list-tile-action>
                            <v-tooltip bottom v-if="item.subIcon">
                                <v-btn icon ripple slot="activator" :to="item.subTo">
                                    <v-icon>{{ item.subIcon }}</v-icon>
                                </v-btn>
                                <span v-if="item.subText">{{ item.subText }}</span>
                            </v-tooltip>
                        </v-list-tile-action>
                    </v-list-tile>
                </template>
            </v-list>
        </v-navigation-drawer>

        <v-toolbar class="light-blue darken-2" flat dark app>
            <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                {{ title }}
            </v-toolbar-title>
            <v-text-field solo prepend-icon="search" placeholder="Пошук"></v-text-field>
            <v-spacer></v-spacer>
            <v-btn icon> <!-- TODO: ..-->
                <v-icon>notifications</v-icon>
            </v-btn>
        </v-toolbar>
        <main>
            <v-content>
                <router-view></router-view>
            </v-content>
        </main>
    </v-app>
</template>

<script>
    import Auth from './store/auth'
    import { post } from './helpers/api'

    export default {
        data() {
            return {
                authState: Auth.state,

                title: 'Головна сторінка',
                drawer: true,
                mini: true,
                items: [
                    {
                        icon: 'home', text: 'Головна сторінка', to: 'home'
                    },
                    {
                        icon: 'account_circle', text: 'Профіль', to: 'profile',
                        subIcon: 'edit', subText: 'Налаштування', subTo: 'edit'
                    },
                    {
                        icon: 'description', text: 'Новини', to: 'news',
                        subIcon: 'add', subText: 'Додати новину', subTo: 'news-create'
                    },
                ]
            }
        },
        computed: {
            auth() {
                return !!this.authState.token;
            },
            guest() {
                return !this.auth;
            },
        },
        methods: {
            logout() {
                post('/api/logout')
                    .then(res => {
                        console.log(res);
                    })
            }
        },
    }
</script>
