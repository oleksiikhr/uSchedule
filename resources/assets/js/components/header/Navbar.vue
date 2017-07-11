<template>
    <div>
        <md-toolbar class="md-white">
            <md-button class="md-icon-button" @click="toggleLeftSidenav">
                <md-icon>menu</md-icon>
            </md-button>

            <h2 class="md-title" style="flex: 1">Vue Material</h2>

            <md-button class="md-raised">Add</md-button>
            <md-button class="md-raised md-warn">Remove</md-button>
        </md-toolbar>

        <md-sidenav class="md-left" ref="leftSidenav" @open="open('Left')" @close="close('Left')">
            <md-toolbar class="md-large">
                <div class="md-toolbar-container">
                    <h3 class="md-title">Sidenav content</h3>
                </div>
            </md-toolbar>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi cupiditate esse necessitatibus beatae nobis, deserunt ut est fugit, tempora deleniti, eligendi commodi doloribus. Nemo, assumenda possimus, impedit inventore perferendis iusto!</p>
        </md-sidenav>

    </div>
</template>

<script>
    export default {
        props: [
            'user',
        ],

        data () {
            return {
                u: null,
                empty: false,
            }
        },

        created () {
            if (this.user === 'empty') {
                this.empty = true;
                return;
            }

            this.u = JSON.parse(this.user);

            console.log(this.u);
        },

        methods: {
            toggleLeftSidenav() {
                this.$refs.leftSidenav.toggle();
            },
            open(ref) {
                console.log('Opened: ' + ref);
            },
            close(ref) {
                console.log('Closed: ' + ref);
            }
        },
    }
</script>
