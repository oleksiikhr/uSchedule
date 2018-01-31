/** @var Object teacher */
export function fullNameTeacher(teacher) {
  return teacher.last_name + ' ' + teacher.first_name + ' ' + teacher.middle_name;
}

/** @var Object teacher */
export function shortNameTeacher(teacher) {
  return teacher.last_name + ' ' + teacher.first_name.charAt(0) + '. '
      + teacher.middle_name.charAt(0) + '.';
}
