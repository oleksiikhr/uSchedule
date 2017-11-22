<template>
  <v-container fluid class="schedule edit">
    <v-layout row wrap>
      <v-flex d-flex xs12 sm4 md3>
        <draggable :options="{ group:{ name: ['subjects', 'teachers'] }}" class="delete-choose" v-if="isMoving">
          <v-icon>
            {{ isDelete ? 'delete_forever' : 'delete' }}
          </v-icon>
        </draggable>
        <v-tabs dark grow centered>
          <v-tabs-bar class="light-blue darken-2" dark>
            <!--<v-tabs-slider class="yellow" />-->
            <v-tabs-item href="#tab-schedules">Schedules</v-tabs-item>
            <v-tabs-item href="#tab-teachers">Teachers</v-tabs-item>
          </v-tabs-bar>
          <v-tabs-items>
            <v-tabs-content id="tab-schedules">
              <v-card flat>
                <v-text-field label="Предмет" v-model="searchSubject" />
                <draggable :list="filterSubjects" element="v-list" :clone="cloneSubject" :move="moveSubject" @end="endSubject"
                           :options="{group: {name: 'subjects', pull: 'clone', put: false}, sort: false}">
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
      </v-flex>
      <v-flex d-flex xs12 sm8 md9>
        123
      </v-flex>
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
        scheduleId: null,
        subjects: [],
        schedule: [],


        // Search
        searchSubject: '',
        searchTeacher: '',

        // Draggable
        fromTeacher: null,
        toElement: null,
        isMoving: false,
        isDelete: true,
        deleteSubject: null,
        deleteTeacher: null,

        // Dialog
        openedWeekIndex: null,
        openedDayIndex: null,
        openedIndex: null,
        dialogRoom: null,

        // Other
        days: [[[], [], [], [], [], []], [[], [], [], [], [], []]],

        message: '',
        response: null
      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Редагування')
      this.scheduleId = parseInt(this.$route.params.id)
      this.getSchedule()
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
      getSchedule () {
        get('/api/schedules/' + this.scheduleId)
            .then(res => {
              this.schedule = res.data
              this.getSubjects()
              this.getTeachers()
              console.log(res.data)
            })
      },
      getSubjects () {
        get('/api/subjects', {
          faculty: this.schedule.faculty_id,
          course: this.schedule.course
        })
            .then(res => {
              this.subjects = res.data
              console.log(res.data)
            })
      },
      getTeachers () {
        get('/api/teachers', {
          id: this.scheduleId
        })
            .then(res => {
              console.log(res.data)

            })
      },


      // Subject
      cloneSubject (el) {
        this.isMoving = true
        this.isDelete = true

        return {
          room: '',
          schedule_id: this.schedule.id,
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
        this.isDelete = !evt.relatedContext.list

        // TODO: Protect draggable after "+", but can't return back
        if (evt.to == evt.from && evt.relatedContext.list.length == 1) {
          return false
        }

        if (evt.to != evt.from) {
          this.deleteSubject = evt.relatedContext.list && evt.relatedContext.list.length > this.time.length - 1
              ? evt.to.attributes
              : null
        }
        else {
          this.deleteSubject = null
        }
      },
      endSubject (el) {
        this.isMoving = false

        if (this.deleteSubject) {
          this.deleteSubject = null
        }
      }
    }
  }
</script>
