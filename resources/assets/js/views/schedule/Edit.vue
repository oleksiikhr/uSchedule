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
                <v-text-field label="Предмет" v-model="searchSubject" single-line prepend-icon="search" />
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
                <v-card-text>Teachers</v-card-text>
              </v-card>
            </v-tabs-content>
          </v-tabs-items>
        </v-tabs>
      </div>
      <div class="right-column">
        <table>
          <thead>
          <tr>
            <draggable :list="filterSubjects" element="table"
                       :options="{ group:{ name: 'subjects', pull: 'clone', put: false }, sort: false }">

            </draggable>
          </tr>
          </thead>
        </table>
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
        scheduleDays: [],

        loadingSchedule: false,
        loadingSubjects: false,
        loadingTeachers: false,
        loadingScheduleDays: false,

        // Search
        searchSubject: '',
        searchTeacher: '',

        // Draggable
        isMoving: false,
        isDelete: false
      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Редагування')
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
      /*
       * Fetch API
       */
      getSchedule () {
        get('/api/schedules', {
          schedule_id: this.schedule.id
        })
            .then(res => {
              this.schedule = res.data
              console.log('Schedule', res.data)
              this.fetchGetSubjects()
              this.fetchGetTeachers()
              this.fetchGetScheduleDays()
            })
      },
      // For the list on the left
      fetchGetSubjects () {
        get('/api/subjects', {
          faculty_id: this.schedule.id,
          course: this.schedule.course
        })
            .then(res => {
              this.subjects = res.data
              console.log('Subjects', res.data)
            })
      },
      // For the list on the left
      fetchGetTeachers () {
        get('/api/teachers', {
          schedule_id: this.schedule.id
        })
            .then(res => {
              this.teachers = res.data
              console.log('Teachers', res.data)
            })
      },
      // Main part of the schedule
      fetchGetScheduleDays () {
        get('/api/schedules/days', {
          schedule_id: this.schedule.id
        })
            .then(res => {
              this.scheduleDays = res.data
              console.log('Days', this.scheduleDays)
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
