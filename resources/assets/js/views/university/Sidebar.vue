<template>
    <md-theme md-name="default">
        <md-layout class="edit-template">
            <md-layout md-flex="20" class="left-column university">
                <div class="left-list phone-viewport">
                    <md-list>
                        <md-list-item>
                            <router-link to="/subjects" exact><md-icon>book</md-icon> <span>Прдемети</span></router-link>
                        </md-list-item>
                        <md-list-item>
                            <router-link to="/teachers"><md-icon>people</md-icon> <span>Викладачі</span></router-link>
                        </md-list-item>
                        <md-list-item>
                            <router-link to="/schedules"><md-icon>move_to_inbox</md-icon> <span>Розклад</span></router-link>
                        </md-list-item>
                    </md-list>
                </div>
            </md-layout>

            <md-layout md-flex="80" class="right-column">
                <router-view></router-view>
            </md-layout>
        </md-layout>
    </md-theme>
</template>

<script>
    export default{

    }
</script>