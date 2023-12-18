import $ from 'jquery'
import 'datatables.net-dt'
import 'datatables.net-dt/css/jquery.dataTables.css'
import flatpickr from 'flatpickr'
import 'flatpickr/dist/flatpickr.css'

$(function () {
  $('#questionnaire-table').DataTable()

  flatpickr('#input-start-date', {
    // minDate: 'today',
  })

  flatpickr('#input-end-date', {
    // minDate: 'today',
  })
})
