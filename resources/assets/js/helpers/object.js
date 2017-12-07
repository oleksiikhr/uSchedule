/**
 * @param object
 *
 * @return string|null link
 */
export function objGetImage(object) {
  if (!object) {
    return null
  }

  return '//' + window.location.hostname + '/' + object.image || null
}

/**
 * @param object
 *
 * @return string|null link
 */
export function objGetName(object) {
  if (!object) {
    return null
  }

  return object.name
}
