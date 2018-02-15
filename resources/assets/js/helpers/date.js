import moment from 'moment'

export function getNameWeekday(index) {
  return moment.weekdays(index)
}

export function getHoursMinutesFromTimeFormat(time) {
  return moment(time, 'HH:mm:ss').format('HH[:]mm')
}

export function differenceHoursMinutesFromTimeFormat(time1, time2) {
  time1 = moment(time1, 'HH:mm:ss')
  time2 = moment(time2, 'HH:mm:ss')

  return Math.abs(time1.diff(time2, 'minutes'))
}
