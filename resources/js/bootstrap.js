import $ from 'jquery'
import 'bootstrap'
import { Modal, Tooltip } from 'bootstrap'

window.$ = $

$.fn.modal = function(action) {
  return this.each(function() {
    const modal = Modal.getOrCreateInstance(this)
    if (action === 'hide') modal.hide()
    if (action === 'show') modal.show()

    return modal
  })
}

$.fn.tooltip = function(config) {
  return this.each(function() {
    console.log('hello')
    return new Tooltip(this, config)
  })
}
