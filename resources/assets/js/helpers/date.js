import moment from 'moment'

export function getNameWeekday(index) {
  return moment.weekdays(index)
}
