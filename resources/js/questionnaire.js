import 'datatables.net-dt'
import 'datatables.net-dt/css/jquery.dataTables.css'
import flatpickr from 'flatpickr'
import 'flatpickr/dist/flatpickr.css'

$(function() {
  const table = $('#table-questionnaire').DataTable({
    ajax: {
      method: 'GET',
      url: 'api/questionnaire',
      dataSrc: ''
    },
    columns: [
      {
        data: null,
        render: (data, row, type, meta) => {
          return meta.row + 1
        }
      },
      {
        data: 'title'
      },
      {
        data: null,
        render: 'start_date'
      },
      {
        data: null,
        render: 'end_date'
      },
      {
        data: null,
        render: 'status'
      },
      {
        data: null,
        render: (questionnaire) => {
          return `<div>
            <a href="/questionnaire/${questionnaire.id}" class="btn btn-primary">Detail</a>
            ${questionnaire.status === 'APPROVED' ? `<a href="/submission?questionnaireId=${questionnaire.id}" class="btn btn-primary">Jawaban</a>` : ''}
          </div>`
        }
      }
    ]
  })

  flatpickr('#input-start-date', {
    minDate: 'today'
  })

  flatpickr('#input-end-date', {
    minDate: 'today'
  })

  $('#btn-add').on('click', handleAddQuestionnaire)

  function handleAddQuestionnaire() {
    const title = $('#input-title').val()
    const description = $('#input-description').val()
    const startDate = $('#input-start-date').val()
    const endDate = $('#input-end-date').val()

    $.post({
      url: '/api/questionnaire',
      data: JSON.stringify({ title, description, startDate, endDate }),
      headers: {
        'Content-Type': 'application/json'
      }
    })
      .done(() => {
        table.ajax.reload()
        $('#modal-add').modal('hide')
      })
      .fail((xhr) => {
        console.log(xhr.responseText)
      })
  }
})
