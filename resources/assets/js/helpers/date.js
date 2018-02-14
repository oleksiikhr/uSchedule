import moment from 'moment'

export function getNameWeekday(index) {
  return moment.weekdays(index)
}

export function getHoursMinutesfromTimeFormat(time) {
  let parse = time.split(':')

  return moment().set({ hour: parse[0], minute: parse[1] }).format('HH[:]mm')
}
