import 'datatables.net-bs5'

$(function() {
  $('#table-student').DataTable({
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
})
