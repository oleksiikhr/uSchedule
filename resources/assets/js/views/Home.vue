<template>
    <v-container fluid>
        <v-layout row wrap>
            <v-flex md8 xs12 xs12>
                <v-layout class="schedule-find" row wrap>
                    <!-- TODO: Get data from Config DB -->
                    <v-flex md4 sm12 xs12 class="pr-2 pl-2">
                        <v-select :items="degree_data" v-model="degree" clearable
                                  label="Освітній ступінь"
                        ></v-select>
                    </v-flex>
                    <v-flex md4 sm12 xs12 class="pr-2 pl-2">
                        <v-select :items="trainingForm_data" v-model="trainingForm" clearable
                                  label="Форма навчання" :disabled="!degree"
                        ></v-select>
                    </v-flex>
                    <v-flex md4 sm12 xs12 class="pr-2 pl-2">
                        <v-select :items="faculty_data" v-model="faculty" clearable
                                  label="Факультет" :disabled="!trainingForm"
                        ></v-select>
                    </v-flex>
                </v-layout>

                <v-layout class="schedile-list" row wrap>

                </v-layout>
                <!-- TODO: all blocks schedule* -->
            </v-flex>
            <v-flex md4 sm12 xs12>
                <!--TODO: news-->
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                degree: null,
                trainingForm: null,
                faculty: null,

//                TODO: Get data from Config DB
                degree_data: ['Бакалавр', 'Магістр'],
                trainingForm_data: ['Денна', 'Вечірня'],
                faculty_data: ['ФОАІС', 'ФЕМП', 'ФТМ', 'ФРГТБ', 'ФФБС', 'ФМТП'],
            }
        },
        watch: {
            degree() {
                this.trainingForm = null;
                this.faculty = null;
                this.course = null;
                this.groups = null;
            },
            trainingForm() {
                this.faculty = null;
                this.course = null;
                this.groups = null;
            },
            faculty() {
                this.course = null;
                this.groups = null;
            },
            course() {
                this.groups = null;
            },
        }
    }
</script>
