import $ from 'jquery'
import 'bootstrap'
import { Modal } from 'bootstrap'

window.$ = $

$.fn.modal = function(action) {
  return this.each(function() {
    const modal = Modal.getOrCreateInstance(this)
    if (action === 'hide') modal.hide()
    if (action === 'show') modal.show()
  })
}
