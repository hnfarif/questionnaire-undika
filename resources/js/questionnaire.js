import 'datatables.net-bs5'
import flatpickr from 'flatpickr'
import 'flatpickr/dist/flatpickr.css'

$(function () {
  const table = $('#table-questionnaire').DataTable({
    ajax: {
      method: 'GET',
      url: 'api/questionnaire',
      dataSrc: '',
    },
    columns: [
      {
        data: null,
        render: (data, row, type, meta) => {
          return meta.row + 1
        },
      },
      {
        data: 'title',
      },
      {
        data: null,
        render: 'start_date',
      },
      {
        data: null,
        render: 'end_date',
      },
      {
        data: null,
        render: 'status',
      },
      {
        data: null,
        render: (questionnaire) => {
          return `
          <div>
            <button class="btn btn-info btn-edit" data-bs-toggle="modal" data-bs-target="#modal-update" data-id="${
              questionnaire.id
            }">
              <i class="fa-regular fa-pen-to-square"></i>
            </button>
            <a href="/questionnaire/${questionnaire.id}" class="btn btn-primary">Detail</a>
            ${
              questionnaire.status === 'APPROVED'
                ? `<a href="/submission?questionnaireId=${questionnaire.id}" class="btn btn-primary">Jawaban</a>`
                : ''
            }
          </div>`
        },
      },
    ],
  })

  flatpickr('#input-start-date', {
    minDate: 'today',
  })

  flatpickr('#input-end-date', {
    minDate: 'today',
  })

  flatpickr('#input-edit-start-date', {
    minDate: 'today',
  })

  flatpickr('#input-edit-end-date', {
    minDate: 'today',
  })

  $('#btn-add').on('click', handleAddQuestionnaire)
  $('#btn-update').on('click', handleUpdateQuestionnaire)
  table.on('click', '.btn-edit', handleEditQuestionnaire)

  function handleAddQuestionnaire() {
    const title = $('#input-title').val()
    const description = $('#input-description').val()
    const startDate = $('#input-start-date').val()
    const endDate = $('#input-end-date').val()

    $.post({
      url: '/api/questionnaire',
      data: JSON.stringify({ title, description, startDate, endDate }),
      headers: {
        'Content-Type': 'application/json',
      },
    })
      .done(() => {
        location.reload()
      })
      .fail((xhr) => {
        console.log(xhr.responseText)
      })
  }

  function handleEditQuestionnaire() {
    const questionnaireId = $(this).data('id')
    $.get(`/api/questionnaire/${questionnaireId}`)
      .done((questionnaire) => {
        $('#input-edit-id').val(questionnaire.id)
        $('#input-edit-title').val(questionnaire.title)
        $('#input-edit-description').val(questionnaire.description)
        $('#input-edit-start-date').val(questionnaire.start_date)
        $('#input-edit-end-date').val(questionnaire.end_date)
      })
      .fail((xhr) => {
        console.log(xhr.responseText)
      })
  }

  function handleUpdateQuestionnaire() {
    const questionnaireId = $('#input-edit-id').val()
    const title = $('#input-edit-title').val()
    const description = $('#input-edit-description').val()
    const startDate = $('#input-edit-start-date').val()
    const endDate = $('#input-edit-end-date').val()

    $.ajax({
      url: `/api/questionnaire/${questionnaireId}`,
      method: 'PUT',
      data: JSON.stringify({
        title,
        description,
        startDate,
        endDate,
      }),
      headers: {
        'Content-Type': 'application/json',
      },
      success: function () {
        $('#modal-update').modal('hide')
        table.ajax.reload()
        $('#input-edit-title').val('')
        $('#input-edit-description').val('')
        $('#input-edit-start-date').val('')
        $('#input-edit-end-date').val('')
      },
      error: function (xhr) {
        console.log(xhr.responseText)
      },
    })
  }
})
