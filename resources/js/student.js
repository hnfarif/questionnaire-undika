import 'datatables.net-bs5'
import Swal from 'sweetalert2'

$(function() {
  const table = $('#table-student').DataTable({
    ajax: {
      method: 'GET',
      url: '/api/student',
      dataSrc: ''
    },
    columns: [
      {
        data: null,
        render: (data, row, type, meta) => {
          return meta.row + 1
        }
      },
      { data: 'name' },
      {
        data: 'nim'
      },
      {
        data: null,
        render: () => '-'
      },
      { data: 'study_program.name' },
      {
        data: null,
        render: (student) => {
          return `
          <div class="d-flex gap-1">
            <button class="btn btn-sm btn-warning">Edit</button>
            <button class="btn btn-sm btn-danger">Delete</button>
          </div>`
        }
      }
    ]
  })

  $('#btn-add').on('click', function() {
    $('#input-email').val('')
    $('#input-password').val('')
    $('#input-nim').val('')
    $('#input-name').val('')

    $('#modal-add').modal('show')
  })

  $('#btn-save').on('click', handleAddStudent)

  function handleAddStudent() {
    const email = $('#input-email').val()
    const password = $('#input-password').val()
    const nim = $('#input-nim').val()
    const name = $('#input-name').val()
    const studyProgramId = $('#select-study-program').val()

    $.ajax({
      url: `/api/student`,
      method: 'POST',
      data: JSON.stringify({
        email,
        password,
        nim,
        name,
        studyProgramId
      }),
      headers: {
        'Content-Type': 'application/json'
      },
      beforeSend: function() {
        Swal.fire({
          title: 'Loading...',
          allowOutsideClick: false,
          showConfirmButton: false,
          didOpen: () => {
            Swal.showLoading()
          }
        })
      },
      success: function() {
        $('#modal-update').modal('hide')
        table.ajax.reload()
        Swal.close()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Data berhasil ditambahkan!',
          showConfirmButton: false,
          timer: 1500
        })

        $('#modal-add').modal('hide')
      },
      error: function(xhr) {
        console.log(xhr.responseText)
      }
    })
  }
})
