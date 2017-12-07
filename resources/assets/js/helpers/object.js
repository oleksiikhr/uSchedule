/**
 * @param object
 *
 * @return string|null link
 */
export function getImage(object) {
  if (!object) {
    return null
  }

  return '//' + window.location.hostname + '/' + object.image || null
}
