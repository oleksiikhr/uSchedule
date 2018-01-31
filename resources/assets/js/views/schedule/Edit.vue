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
                <template v-if="!loading.subjects.model">
                  <v-layout row wrap class="line-search-update">
                    <v-text-field solo label="Предмет" clearable v-model="searchSubject" single-line
                                  prepend-icon="search" />
                    <v-btn flat icon @click="fetchGetSubjects()">
                      <v-icon>refresh</v-icon>
                    </v-btn>
                  </v-layout>
                  <draggable v-model="filterSubjects" :clone="cloneSubject" :move="moveSubject" @end="endMoveSubject"
                             :options="{ group:{ name: 'subjects', pull: 'clone', put: false }, sort: false }" element="v-list">
                    <v-list-tile :title="subject.title" v-for="subject in filterSubjects" :key="subject.id">
                      <v-list-tile-content class="cursor-grab">{{ subject.title }}</v-list-tile-content>
                    </v-list-tile>
                  </draggable>
                </template>
                <template v-else-if="!loading.schedule.model && !loading.schedule.hasError"> <!-- Subjects is loading -->
                  <div class="error-left-column">
                    <v-progress-circular indeterminate :size="30" :width="5" color="primary" />
                  </div>
                </template> <!-- END Subjects is loading or error -->
              </v-card>
            </v-tabs-content>
            <v-tabs-content id="tab-teachers">
              <v-card flat>
                <template v-if="!loading.teachers.model">
                  <v-layout row wrap class="line-search-update">
                    <v-text-field solo label="Викладач" clearable v-model="searchTeacher" single-line
                                  prepend-icon="search" />
                    <v-btn flat icon @click="fetchGetTeachers()">
                      <v-icon>refresh</v-icon>
                    </v-btn>
                  </v-layout>
                  <draggable v-model="filterTeachers" :clone="cloneTeacher" :move="moveTeacher" @end="endMoveTeacher"
                             :options="{ group:{ name: 'teachers', pull: 'clone', put: false }, sort: false }" element="v-list">
                    <v-list-tile v-for="teacher in filterTeachers" :key="teacher.id">
                      <v-list-tile-content class="cursor-grab">{{ fullNameTeacher(teacher) }}</v-list-tile-content>
                    </v-list-tile>
                  </draggable>
                </template>
                <template v-else-if="!loading.schedule.model && !loading.schedule.hasError"> <!-- Teachers is loading -->
                  <div class="error-left-column">
                    <v-progress-circular indeterminate :size="30" :width="5" color="primary" />
                  </div>
                </template> <!-- END Teachers is loading or error -->
              </v-card>
            </v-tabs-content>
          </v-tabs-items>
        </v-tabs>
      </div>
      <div class="right-column">
        <template v-if="scheduleIsLoaded">
          <table> <!-- Main Left Column -->
            <thead> <!-- Columns -->
            <draggable :options="{ group: { name: 'columns' }, sort: true, draggable: '.item' }" element="tr"
                       :v-model="schedule.columns">
              <td colspan="2" class="column small">#</td>
              <td v-for="(column, columnIndex) in schedule.columns" class="column edit cursor-grab item" :key="column.id">
                <span>{{ column.name }}</span>
                <div class="hover-visible">
                  <div class="edit">
                    <v-btn outline @click="actColumnDialogEditOpen(columnIndex)" color="primary">
                      <v-icon>edit</v-icon>
                    </v-btn>
                  </div>
                  <div class="move">
                    <v-icon>chevron_left</v-icon><v-icon>chevron_right</v-icon>
                  </div>
                  <div class="delete">
                    <v-btn outline @click="actColumnDialogDeleteOpen(columnIndex)" color="red">
                      <v-icon>delete</v-icon>
                    </v-btn>
                  </div>
                </div>
              </td>
              <td class="column small" slot="footer">
                <v-btn outline @click="actColumnAdd()">
                  <v-icon>add</v-icon>
                </v-btn>
              </td>
            </draggable>
            </thead> <!-- EMD Columns -->
            <tbody> <!-- Rows -->
            <tr v-for="day in 7" :key="day">
              <td></td> <!-- TODO: (sunday, monday) - from moments.js. Custom_date ? <table> : .. -->
              <td>
                <table>
                  <tr v-for="order in getMaxLessonsOnDay(day - 1)">
                    {{ order }}
                  </tr>
                </table>
              </td>
              <td colspan="2"> <!-- Lessons -->
                {{ day }}
              </td>
            </tr>
            </tbody> <!-- EMD Rows -->
          </table> <!-- END Main Left Column -->
        </template>
        <template v-else> <!-- Schedule is loading or error -->
          <div class="schedule-loading">
            <h6>Налаштування розкладу</h6>
            <ul class="info-schedule-loading">
              <li v-for="item in loading">
                <v-icon color="red" v-if="item.hasError">clear</v-icon>
                <v-icon color="green" v-else-if="!item.model">done</v-icon>
                <v-progress-circular :indeterminate="item.model" :size="22" :width="5" color="primary" v-else />
                <span>{{ item.message }}</span>
              </li>
            </ul>
            <!-- TODO: update only errors block. + Visible* -->
            <v-btn outline block @click="getGetSchedule()">Оновити</v-btn>
          </div>
        </template> <!-- End Schedule is loading or error  -->
      </div>
    </v-layout>

    <!-- Dialogs -->

    <v-dialog v-model="dialogColumnEdit" max-width="400">
      <v-card>
        <v-card-title class="headline">Редагування колонки</v-card-title>
        <v-card-text>
          <form @keydown.enter.prevent="actColumnDialogEditSave()">
            <v-text-field label="Назва колонки" v-model="columnOpenObj.name" counter="100" ref="columnEdit" />
            <v-text-field label="Опис" v-model="columnOpenObj.description" counter="191" multi-line />
          </form>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn color="red" flat @click.native="dialogColumnEdit = false">Закрити</v-btn>
          <v-btn color="primary" flat @click.native="actColumnDialogEditSave()">Зберегти</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogColumnDelete" v-if="columnOpenIndex > -1" max-width="400">
      <v-card>
        <v-card-title class="headline">Видалення колонки</v-card-title>
        <v-card-text>
          Ви дійсно хочете видалити "{{ schedule.columns[columnOpenIndex].name }}" колонку?
          Всі дані, які прікріплені до цієї колонки <strong>видаляться</strong>.
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn color="red" flat @click.native="dialogColumnDelete = false">Закрити</v-btn>
          <v-btn color="primary" flat @click.native="actColumnDialogDeleteConfirm()">Видалити</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
  import { fullNameTeacher, shortNameTeacher } from "../../helpers/teacher"
  import { get, post } from '../../helpers/api'
  import draggable from 'vuedraggable'

  export default {
    components: {
      draggable
    },
    data () {
      return {
        schedule: {},
        subjects: [],
        teachers: [],
        columns: [],
        types: [],
        times: [],

        // Loading
        loading: {
          schedule: { model: true, hasError: false, message: 'Отримання інформація про навчальний заклад.' },
          types: { model: true, hasError: false, message: 'Отримання типів навчальних занять.' },
          subjects: { model: true, hasError: false, message: 'Отримання предметів.' },
          teachers: { model: true, hasError: false, message: 'Отримання викладачів.' },
          times: { model: true, hasError: false, message: 'Отримання розкладу дзвінків' }
        },
        isLoaded: false,

        // Search
        searchSubject: '',
        searchTeacher: '',

        // Column
        dialogColumnEdit: false,
        dialogColumnDelete: false,
        columnOpenObj: {},
        columnOpenIndex: -1,

        // Draggable
        isMoving: false,
        isDelete: false
      }
    },
    mounted () {
      this.$store.dispatch('templateSetTitle', 'Редагування розкладу') // TODO: Name group (faculty)
      this.$store.dispatch('templateSetBodyClass', 'height100')

      this.schedule.id = parseInt(this.$route.params.id)
      this.getGetSchedule()
    },
    destroyed () {
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

        return subjects
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
      },
      scheduleIsLoaded () {
        if (this.isLoaded) {
          return true
        }

        for (let item in this.loading) {
          if (this.loading[item].model && !this.loading[item].hasError) {
            return false
          }
        }

        this.isLoaded = true
        return true
      },
      maxCountLessons () {
        return this.times.length
      }
    },
    methods: {
      /* | ------------------------------------------------------------------------
       * | Import helpers
       * | ------------------------------------------------------------------------
       */
      fullNameTeacher,
      shortNameTeacher,

      /* | ------------------------------------------------------------------------
       * | Fetch API
       * | ------------------------------------------------------------------------
       */
      getGetSchedule () {
        this.loading.schedule.model = true
        this.loading.schedule.hasError = false
        this.columns = []

        get('/api/schedule', {
          schedule_id: this.schedule.id
        })
            .then(res => {
              this.schedule = res.data
              console.log(this.schedule)
              this.loading.schedule.model = false
              this.fetchGetTypes()
              this.fetchGetSubjects()
              this.fetchGetTeachers()
              this.fetchGetTimes()
            })
            .catch(err => {
              this.loading.schedule.hasError = true
              this.loading.schedule.model = false
            })
      },
      fetchGetTypes () {
        this.loading.types.model = true
        this.loading.types.hasError = false
        this.types = []

        get('/api/types', {
          schedule_id: this.schedule.id
        })
            .then(res => {
              this.types = res.data
              this.loading.types.model = false
            })
            .catch(err => {
              this.loading.types.hasError = true
              this.loading.types.model = false
            })
      },
      fetchGetSubjects () {
        this.loading.subjects.model = true
        this.loading.subjects.hasError = false
        this.subjects = []

        get('/api/subjects', {
          faculty_id: this.schedule.faculty_id
        })
            .then(res => {
              this.subjects = res.data
              this.loading.subjects.model = false
            })
            .catch(err => {
              this.loading.subjects.hasError = true
              this.loading.subjects.model = false
            })
      },
      fetchGetTeachers () {
        this.loading.teachers.model = true
        this.loading.teachers.hasError = false
        this.teachers = []

        get('/api/teachers', {
          faculty_id: this.schedule.faculty_id
        })
            .then(res => {
              this.teachers = res.data
              this.loading.teachers.model = false
            })
            .catch(err => {
              this.loading.teachers.hasError = true
              this.loading.teachers.model = false
            })
      },
      fetchGetTimes () {
        this.loading.times.model = true
        this.loading.times.hasError = false
        this.times = []

        get('/api/times', {
          object_id: this.schedule.object_id
        })
            .then(res => {
              this.times = res.data
              this.loading.times.model = false
            })
            .catch(err => {
              this.loading.times.hasError = true
              this.loading.times.model = false
            })
      },

      /* | ------------------------------------------------------------------------
       * | Action
       * | ------------------------------------------------------------------------
       */
      // Column
      actColumnAdd () {
        this.schedule.columns.push({ days: [], name: '', description: '' })
        this.actColumnDialogEditOpen(this.schedule.columns.length - 1)
      },
      actColumnDialogEditOpen (index) {
        this.columnOpenIndex = index
        this.columnOpenObj = JSON.parse(JSON.stringify(this.schedule.columns[index]))
        this.$nextTick(() => this.$refs.columnEdit.focus())
        this.dialogColumnEdit = true
      },
      actColumnDialogEditSave () {
        this.schedule.columns[this.columnOpenIndex] = this.columnOpenObj
        this.actColumnDialogClose()
      },
      actColumnDialogDeleteOpen (index) {
        this.columnOpenIndex = index
        this.dialogColumnDelete= true
      },
      actColumnDialogDeleteConfirm () {
        this.schedule.columns.splice(this.columnOpenIndex, 1)
        this.actColumnDialogClose()
      },
      actColumnDialogClose () {
        this.dialogColumnEdit = false
        this.dialogColumnDelete = false
        this.columnOpenObj = {}
        this.columnOpenIndex = -1
      },

      /* | ------------------------------------------------------------------------
       * | Draggable. Left Column
       * | ------------------------------------------------------------------------
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
      endMoveTeacher (el) {},

      /* | ------------------------------------------------------------------------
       * | Other
       * | ------------------------------------------------------------------------
       */
      getMaxLessonsOnDay (dayIndex) {
        let max = 0

        for (let column of this.schedule.columns) {
          let days = column['days'][dayIndex]

          if (days === undefined) {
            continue
          }

          let len = days['lessons'].length

          if (max < len) {
            max = len
          }
        }

        return max
      }
    },
    watch: {
      // dialogColumnEdit (val) {
      //   !val && this.actColumnDialogClose()
      // },
      // dialogColumnDelete (val) {
      //   !val && this.actColumnDialogClose()
      // },
    }
  }
</script>
