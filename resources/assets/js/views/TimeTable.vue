<template>
  <div id="timetable">
    <h2>Розклад дзвінків</h2>
    <table>
      <tr v-for="(time, timeIndex) in times" :key="timeIndex">
        <td>{{ timeIndex }}</td>
        <td>{{ getHoursMinutesfromTimeFormat(time.start_time) }} - {{ getHoursMinutesfromTimeFormat(time.end_time) }}</td>
      </tr>
    </table>
  </div>
</template>

<script>
  import { get } from '../helpers/api'
  import { getHoursMinutesfromTimeFormat } from '../helpers/date'

  export default {
    data () {
      return {
        times: []
      }
    },
    mounted () {
      this.fetchGetObjectTime()
    },
    methods: {
      getHoursMinutesfromTimeFormat,
      // TODO Save in Vuex
      fetchGetObjectTime () {
        // TODO Object_id
        get('/api/times', {
          object_id: 1
        })
            .then(res => {
              this.times = res.data
            })
            .catch(err => {
              // TODO Show error
            })
      }
    }
  }
</script>
