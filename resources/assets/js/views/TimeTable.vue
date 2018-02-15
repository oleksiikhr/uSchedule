<template>
  <div id="timetable">
    <h2>Розклад дзвінків</h2>
    <div class="inner">
      <!-- TODO Показать в виде загрузки (заполнение цветом) текущую пару (либо перемену)** -->
      <div class="block" v-for="(time, timeIndex) in times" :key="timeIndex">
        <div class="block-left">{{ timeIndex + 1 }}</div>
        <div class="block-center">{{ getHoursMinutesFromTimeFormat(time.start_time) }} - {{ getHoursMinutesFromTimeFormat(time.end_time) }}</div>
        <div class="block-right">{{ differenceTimeLesson(timeIndex) }}</div>
      </div>
    </div>
    <!-- TODO Has permission -->
    <!-- TODO Pop-up to edit -->
    <v-btn outline block color="black">Редагувати</v-btn>
  </div>
</template>

<script>
  import { getHoursMinutesFromTimeFormat, differenceHoursMinutesFromTimeFormat } from '../helpers/date'
  import { get } from '../helpers/api'

  export default {
    data () {
      return {
        times: []
      }
    },
    mounted () {
      this.$store.dispatch('templateSetTitle', 'Розклад дзвінків')
      this.fetchGetObjectTime()
    },
    methods: {
      getHoursMinutesFromTimeFormat,
      differenceHoursMinutesFromTimeFormat,

      // TODO Save in Vuex
      fetchGetObjectTime () {
        // TODO Object_id
        get('/api/times', {
          object_id: 1
        })
            .then(res => {
              this.times = res.data
            })
      },
      differenceTimeLesson (index) {
        if (typeof this.times[index + 1] === 'undefined') {
          return null
        }

        return differenceHoursMinutesFromTimeFormat(this.times[index].end_time, this.times[index + 1].start_time)
      }
    }
  }
</script>
