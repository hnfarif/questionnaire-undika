import 'datatables.net-bs5'
import flatpickr from 'flatpickr'
import 'flatpickr/dist/flatpickr.css'
import Swal from 'sweetalert2'

$(function () {
  const urlParams = new URLSearchParams(window.location.search)
  const studyProgramId = urlParams.get('studyProgramId')
  const table = $('#table-questionnaire').DataTable({
    ajax: {
      method: 'GET',
      url: studyProgramId
        ? `/api/questionnaire?studyProgramId=${studyProgramId}`
        : '/api/questionnaire',
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
        render: 'semester',
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
            ${
              questionnaire.semester === questionnaire.study_program.semester.smt_active
                ? questionnaire.status !== 'APPROVED' &&
                  user.roles.some((role) => role.name === 'KAPRODI')
                  ? `<button class="btn btn-info btn-edit" data-bs-toggle="modal" data-bs-target="#modal-update" data-id="${questionnaire.id}">
                <i class="fa-regular fa-pen-to-square"></i>
              </button>`
                  : ''
                : user.roles.some((role) => role.name === 'KAPRODI')
                ? `<button class="btn btn-info btn-duplicate" title="Duplikat Kuesioner" data-id="${questionnaire.id}">
                <i class="fa-regular fa-clone"></i>
              </button>`
                : ''
            }

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
  $('#select-semester').on('change', handleSelectSemester)
  table.on('click', '.btn-edit', handleEditQuestionnaire)
  table.on('click', '.btn-duplicate', handleDuplicateQuestionnaire)

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
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: JSON.parse(xhr.responseText).message,
        })
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
      beforeSend: function () {
        Swal.fire({
          title: 'Loading...',
          allowOutsideClick: false,
          showConfirmButton: false,
          didOpen: () => {
            Swal.showLoading()
          },
        })
      },
      success: function () {
        $('#modal-update').modal('hide')
        table.ajax.reload()
        Swal.close()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data berhasil di ubah!',
          showConfirmButton: false,
          timer: 1500,
        })
        $('#input-edit-title').val('')
        $('#input-edit-description').val('')
        $('#input-edit-start-date').val('')
        $('#input-edit-end-date').val('')
      },
      error: function (xhr) {
        console.log(xhr.responseText)
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: JSON.parse(xhr.responseText).message,
        })
      },
    })
  }

  function handleSelectSemester() {
    const urlSelected = studyProgramId
      ? `/api/questionnaire?studyProgramId=${studyProgramId}&semester=${$(this).val()}`
      : `/api/questionnaire?semester=${$(this).val()}`
    $.get(urlSelected)
      .done((questionnaires) => {
        console.log(questionnaires)
        table.clear().rows.add(questionnaires).draw()
      })
      .fail((xhr) => {
        console.log(xhr.responseText)
      })
  }

  function handleDuplicateQuestionnaire() {
    Swal.fire({
      title: 'Apakah anda yakin?',
      html:
        'Duplikat kuesioner akan membuat kuesioner yang sama beserta pertanyaannya di semester yang sedang aktif! <br><br>' +
        'Note : Jangan lupa untuk memasukkan periodenya, setelah kuesioner berhasil diduplikasi!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Duplikat',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `api/questionnaire/duplicate/${$(this).data('id')}`,
          method: 'POST',
          beforeSend: function () {
            Swal.fire({
              title: 'Loading...',
              allowOutsideClick: false,
              showConfirmButton: false,
              didOpen: () => {
                Swal.showLoading()
              },
            })
          },
          success: function (data) {
            Swal.fire({
              title: 'Berhasil!',
              text: 'Kuesioner anda berhasil diduplikasi!. Cek kuesioner di semester yang sedang aktif!',
              icon: 'success',
              showConfirmButton: false,
              timer: 1500,
            })
          },
          error: function (xhr) {
            console.log(xhr.responseText)
          },
        })
      }
    })
  }
})
