/**
 * | -----------------------------------------------------------------------
 * | Object - universe, college, etc.
 * | -----------------------------------------------------------------------
 * |
 */

/**
 * @param obj
 *
 * @return string|null link
 */
export function objGetImage(obj) {
  if (!obj) {
    return null
  }

  return '//' + window.location.hostname + '/' + obj.image || null
}

/**
 * @param object
 *
 * @return string|null link
 */
export function objGetName(obj) {
  if (!obj) {
    return null
  }

  return obj.name
}
