<template>
  <v-container fluid class="schedule edit">
    <v-layout row wrap>
      <div class="left-column">
        <draggable :options="{ group:{ name: ['subjects', 'teachers'] }}" class="delete-choose" drag="delete" v-if="isMoving">
          <v-icon>
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
                <v-text-field solo label="Предмет" v-model="searchSubject" single-line prepend-icon="search" />
                <draggable :list="filterSubjects" element="v-list" :clone="cloneSubject" :move="moveSubject" @end="endMoveSubject"
                           :options="{ group:{ name: 'subjects', pull: 'clone', put: false }, sort: false }">
                  <v-list-tile :title="subject.title" v-for="subject in filterSubjects" :key="subject.id">
                    <v-list-tile-content>{{ subject.title }}</v-list-tile-content>
                  </v-list-tile>
                </draggable>
              </v-card>
            </v-tabs-content>
            <v-tabs-content id="tab-teachers">
              <v-card flat>
                <v-card-text>Teachers..</v-card-text>
              </v-card>
            </v-tabs-content>
          </v-tabs-items>
        </v-tabs>
      </div>
      <div class="right-column">
        <template v-if="!loadingSchedule">
          <table>
            <thead>
            <tr>
              <draggable :list="filterSubjects" element="table"
                         :options="{ group:{ name: 'subjects', pull: 'clone', put: false }, sort: false }">

              </draggable>
            </tr>
            </thead>
          </table>
        </template>
        <template v-else> <!-- Schedule is loading or error -->
          <template v-if="errorSchedule">
            <div class="bad-response error-schedule">
              <h2 class="red darken-1 white--text">Помилка при отримані розкладу</h2>
              <v-btn outline color="primary" @click="getSchedule()">Оновити</v-btn>
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
  </v-container>
</template>

<script>
  import draggable from 'vuedraggable'
  import { get, post } from '../../helpers/api'

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

        // Search
        searchSubject: '',
        searchTeacher: '',

        // Draggable
        isMoving: false,
        isDelete: false
      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Редагування розкладу')
      this.$store.dispatch('templateSetBodyClass', 'height100')
      this.schedule.id = parseInt(this.$route.params.id)
      this.getSchedule()
    },
    deactivated () {
      this.$store.dispatch('templateSetBodyClass', '')
      this.loadingSchedule = false
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
      /*
       * Fetch API
       */
      // Global info about Schedule
      getSchedule () {
        this.loadingSchedule = true
        this.errorSchedule = false
        this.schedule = {}

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
      // For the list on the left
      fetchGetSubjects () {
        this.loadingSubjects = true
        this.subjects = []

        get('/api/subjects', {
          faculty_id: this.schedule.id,
          course: this.schedule.course
        })
            .then(res => {
              console.log('Subjects', res.data)
              this.subjects = res.data
              this.loadingSubjects = false
            })
      },
      // For the list on the left
      fetchGetTeachers () {
        this.loadingTeachers = true
        this.teachers = []

        get('/api/teachers', {
          schedule_id: this.schedule.id
        })
            .then(res => {
              console.log('Teachers', res.data)
              this.teachers = res.data
              this.loadingTeachers = false
            })
      },

      /*
       * Draggable Subject
       */
      cloneSubject (el) {
        this.isMoving = true
        this.isDelete = true

        return {
          schedule_id: this.schedule.id,
          room: '',
          type: 0,
          is_empty: 0,
          teachers: [],
          subject: {
            id: el.id,
            title: el.title,
            course: el.course,
            faculty_id: el.faculty_id
          }
        }
      },
      moveSubject (evt, originalEvent) {
        let drag = evt.to.attributes.drag

        if (typeof drag !== 'undefined' && drag.value === 'delete') {
          this.isDelete = true
        }
      },
      endMoveSubject (el) {
        this.isMoving = false

        if (this.deleteSubject) {
          this.deleteSubject = null
        }
      }
    }
  }
</script>
