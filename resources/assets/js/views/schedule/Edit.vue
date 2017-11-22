<template>
  <div>Edit page</div>
</template>

<script>
  import { post, get } from '../../helpers/api'

  export default {
    data() {
      return {
        id: null,
        subjects: [],
        schedule: []
      }
    },
    activated () {
      this.$store.dispatch('templateSetTitle', 'Редагування')
      this.id = parseInt(this.$route.params.id)
      this.getSubjects()
      this.getSchedule()
    },
    methods: {
      getSubjects () {
        get('/api/subjects', {
          faculty: 1,
          course: 1
        })
            .then(res => {
              this.subjects = res.data
              console.log(res.data)
            })
      },
      getSchedule () {
        get('/api/schedule', {
          id: this.id
        })
            .then(res => {
              this.schedule = res.data
              console.log(res.data)
            })
      }
    }
  }
</script>
