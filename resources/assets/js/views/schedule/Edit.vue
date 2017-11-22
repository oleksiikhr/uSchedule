<template>
  <div>Edit page</div>
</template>

<script>
  import { post, get } from '../../helpers/api'

  export default {
    data() {
      return {
        scheduleId: null,
        subjects: [],
        schedule: []
      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Редагування')
      this.scheduleId = parseInt(this.$route.params.id)
      this.getSchedule()
    },
    methods: {
      getSchedule () {
        get('/api/schedules/' + this.scheduleId)
            .then(res => {
              this.schedule = res.data
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
      }
    }
  }
</script>
