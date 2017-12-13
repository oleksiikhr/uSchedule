<template>
  <v-container fluid class="schedule edit">
    <v-layout row wrap>
      <div class="left-column">
        <draggable :options="{ group:{ name: ['subjects', 'teachers'] }}" class="delete-choose" drag="delete"
                   v-if="isMoving">
          <v-icon :class="!isDelete ? 'delete_forever' : 'delete'">
            {{ isDelete ? 'delete_forever' : 'delete' }}
          </v-icon>
        </draggable>
        <v-tabs dark grow centered>
          <v-tabs-bar class="light-blue darken-2" dark>
            <v-tabs-item href="#tab-schedules">
              <v-icon>book</v-icon>
            </v-tabs-item>
            <v-tabs-item href="#tab-teachers">
              <v-icon>people</v-icon>
            </v-tabs-item>
          </v-tabs-bar>
          <v-tabs-items>
            <v-tabs-content id="tab-schedules">
              <v-card flat>
                <template v-if="!loadingSubjects">
                  <v-layout row wrap class="line-search-update">
                    <v-text-field solo label="Предмет" clearable v-model="searchSubject" single-line
                                  prepend-icon="search" />
                    <v-btn flat icon @click="fetchGetSubjects()">
                      <v-icon>refresh</v-icon>
                    </v-btn>
                  </v-layout>
                  <draggable :list="filterSubjects" element="v-list" :clone="cloneSubject" :move="moveSubject" @end="endMoveSubject"
                             :options="{ group:{ name: 'subjects', pull: 'clone', put: false }, sort: false }">
                    <v-list-tile :title="subject.title" v-for="subject in filterSubjects" :key="subject.id">
                      <v-list-tile-content class="cursor-grab">{{ subject.title }}</v-list-tile-content>
                    </v-list-tile>
                  </draggable>
                </template>
                <template v-else> <!-- Subjects is loading or error -->
                  <template v-if="errorSubjects">
                    <div class="bad-response error-left-column">
                      <v-btn outline block color="black" @click="fetchGetSubjects()">Оновити</v-btn>
                    </div>
                  </template>
                  <template v-else-if="!loadingSchedule && !errorSchedule">
                    <div class="bad-response loading-subjects">
                      <v-progress-circular indeterminate :size="50" :width="3" color="primary" />
                    </div>
                  </template>
                </template> <!-- END Subjects is loading or error -->
              </v-card>
            </v-tabs-content>
            <v-tabs-content id="tab-teachers"> <!-- TODO: After complete subjects -->
              <v-card flat>
                <template v-if="!loadingTeachers">
                  <v-layout row wrap class="line-search-update">
                    <v-text-field solo label="Викладач" clearable v-model="searchTeacher" single-line
                                  prepend-icon="search" />
                    <v-btn flat icon @click="fetchGetTeachers()">
                      <v-icon>refresh</v-icon>
                    </v-btn>
                  </v-layout>
                  <draggable :list="filterTeachers" element="v-list" :clone="cloneTeacher" :move="moveTeacher" @end="endMoveTeacher"
                             :options="{ group:{ name: 'teachers', pull: 'clone', put: false }, sort: false }">
                    <v-list-tile v-for="teacher in filterTeachers" :key="teacher.id">
                      <v-list-tile-content class="cursor-grab">{{ fullNameTeacher(teacher) }}</v-list-tile-content>
                    </v-list-tile>
                  </draggable>
                </template>
                <template v-else> <!-- Teachers is loading or error -->
                  <template v-if="errorTeachers">
                    <div class="bad-response error-left-column">
                      <v-btn outline block color="black" @click="fetchGetTeachers()">Оновити</v-btn>
                    </div>
                  </template>
                  <template v-else-if="!loadingSchedule && !errorSchedule">
                    <div class="bad-response loading-teachers">
                      <v-progress-circular indeterminate :size="50" :width="3" color="primary" />
                    </div>
                  </template>
                </template> <!-- END Teachers is loading or error -->
              </v-card>
            </v-tabs-content>
          </v-tabs-items>
        </v-tabs>
      </div>
      <div class="right-column">
        <template v-if="!loadingSchedule">
          <table> <!-- Main Left Column -->
            <thead> <!-- Columns --> <!-- TODO: NOW -->
            <draggable :list="schedule.columns" element="tr"
                       :options="{ group:{ name: 'columns', pull: 'clone', put: false }, sort: true}">
              <td class="column edit cursor-grab" v-for="(column, columnIndex) in schedule.columns" :key="column.id"
                  @click="columnIndex = columnIndex">
                {{ column.name }}
              </td>
              <td class="column add">
                <v-btn outline @click="actColumnAdd()"> <!-- TODO: delete styles -->
                  <v-icon>add</v-icon>
                </v-btn>
              </td>
            </draggable>
            </thead> <!-- EMD Columns -->
            <tbody> <!-- Rows -->

            </tbody> <!-- EMD Rows -->
          </table> <!-- END Main Left Column -->
        </template>
        <template v-else> <!-- Schedule is loading or error -->
          <template v-if="errorSchedule">
            <div class="bad-response error-schedule">
              <h2 class="light-blue darken-2 white--text">Помилка при отримані розкладу</h2>
              <v-btn outline color="black" @click="getSchedule()">Оновити</v-btn>
            </div>
          </template>
          <template v-else>
            <div class="bad-response loading-schedule">
              <v-progress-circular indeterminate :size="80" :width="5" color="primary" />
            </div>
          </template>
        </template> <!-- End Schedule is loading or error  -->
      </div>
    </v-layout>

    <!-- Dialogs -->
    <v-dialog v-model="dialogColumnEdit" max-width="400">
      <v-card>
        <v-card-title class="headline">Редагування колонки</v-card-title>
        <v-card-text> <!-- TODO: Size -->
          <v-text-field label="Назва колонки" v-model="columnOpenObj.name" />
          <v-text-field label="Опис" v-model="columnOpenObj.description" multi-line />
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" flat @click.native="actColumnDialogClose()">Закрити</v-btn>
          <v-btn color="primary" flat @click.native="actColumnDialogEditSave()">Зберегти</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
  import draggable from 'vuedraggable'
  import { get, post } from '../../helpers/api'
  import { fullNameTeacher, shortNameTeacher } from "../../helpers/teacher";

  export default {
    components: {
      draggable
    },
    data() {
      return {
        schedule: {},
        subjects: [],
        teachers: [],

        // Loading
        loadingSchedule: true,
        loadingSubjects: true,
        loadingTeachers: true,

        // Error
        errorSchedule: false,
        errorSubjects: false,
        errorTeachers: false,

        // Search
        searchSubject: '',
        searchTeacher: '',

        // Column
        dialogColumnEdit: false,
        dialogColumnDelete: false,
        columnOpenObj: {},

        // Draggable
        isMoving: false,
        isDelete: false
      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Редагування розкладу') // TODO: Name group (faculty)
      this.$store.dispatch('templateSetBodyClass', 'height100')
      this.schedule.id = parseInt(this.$route.params.id)
      this.getSchedule()
    },
    deactivated () {
      this.$store.dispatch('templateSetBodyClass', '')
    },
    computed: {
      filterSubjects () {
        let subjects = this.subjects,
            search = this.searchSubject

        if (!search) {
          return subjects
        }

        search = search.toLowerCase()

        subjects = subjects.filter(subject => {
          if (subject.title.toLowerCase().indexOf(search) !== -1) {
            return subject
          }
        })

        return subjects;
      },
      filterTeachers () {
        let teachers = this.teachers,
            search = this.searchTeacher

        if (!search) {
          return teachers
        }

        search = search.toLowerCase()

        teachers = teachers.filter(teacher => {
          if (this.fullNameTeacher(teacher).toLowerCase().indexOf(search) !== -1) {
            return teacher
          }
        })

        return teachers
      }
    },
    methods: {
      /* | ------------------------
       * | Import helpers
       * | ------------------------
       */
      fullNameTeacher,
      shortNameTeacher,

      /* | ------------------------
       * | Fetch API
       * | ------------------------
       */
      getSchedule () {
        this.loadingSchedule = true
        this.errorSchedule = false

        get('/api/schedule', {
          schedule_id: this.schedule.id
        })
            .then(res => {
              console.log('Schedule', res.data)
              this.schedule = res.data
              this.loadingSchedule = false
              this.fetchGetSubjects()
              this.fetchGetTeachers()
            })
            .catch(err => {
              this.errorSchedule = true
            })
      },
      fetchGetSubjects () {
        this.loadingSubjects = true
        this.subjects = []

        get('/api/subjects', {
          faculty_id: this.schedule.id
        })
            .then(res => {
              console.log('Subjects', res.data)
              this.subjects = res.data
              this.loadingSubjects = false
            })
      },
      fetchGetTeachers () {
        this.loadingTeachers = true
        this.teachers = []

        get('/api/teachers', {
          faculty_id: this.schedule.id
        })
            .then(res => {
              console.log('Teachers', res.data)
              this.teachers = res.data
              this.loadingTeachers = false
            })
      },

      /* | ------------------------
       * | Action
       * | ------------------------
       */
      // Column
      actColumnAdd () {
        console.log('Column add')
        this.schedule.columns.push({ days: [], name: 'Назва', description: '' })
        this.actColumnDialogEditOpen(this.schedule.columns.length - 1)
      },
      actColumnDialogEditOpen (index) {
        console.log('Column open')
        this.columnOpenObj = Object.assign(this.schedule.columns[index])
        this.dialogColumnEdit = true
      },
      actColumnDialogEditSave () {
        console.log('Column save')
        this.actColumnDialogClose()
      },
      actColumnDialogDeleteOpen () {
        console.log('Column delete')
        this.actColumnDialogClose()
      },
      actColumnDialogClose () {
        console.log('Column close')
        this.dialogColumnEdit = false
        this.dialogColumnDelete = false
        this.columnOpenObj = {}
      },

      /* | ------------------------
       * | Draggable. Left Column
       * | ------------------------
       */
      cloneSubject (el) {
        this.isMoving = true
        this.isDelete = true

        return el
      },
      moveSubject (evt, originalEvent) {
        let drag = evt.to.attributes.drag

        // TODO: *
        if (typeof drag !== 'undefined' && drag.value === 'delete') {
          this.isDelete = true
        }
      },
      endMoveSubject (el) {
        this.isMoving = false

        if (this.deleteSubject) {
          this.deleteSubject = null
        }
      },
      cloneTeacher (el) {},
      moveTeacher (evt, originalEvent) {},
      endMoveTeacher (el) {}
    }
  }
</script>
