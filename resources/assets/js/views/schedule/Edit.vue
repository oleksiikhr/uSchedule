<template>
  <div>Edit page</div>
</template>

<script>
  import { post, get } from '../../helpers/api'

  export default {
    created () {
      // TODO ..
    },
    data() {
      return {
        subjects: [],
        schedule: []
      }
    },
    mounted() {
      this.subjects = this.getSubjects()
    },
    methods: {
      getSubjects() {
        get('/api/subjects?faculty=1&course=1')
            .then(res => {
              console.log(res.data)
            })
      },
      getSchedule() {
        get('/api/schedule?id=' + this.$route.params)
            .then(res => {
              console.log(res.data)
            })
      }
    }
  }
</script>
