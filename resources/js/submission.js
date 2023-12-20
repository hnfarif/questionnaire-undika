import 'datatables.net-dt'
import 'datatables.net-dt/css/jquery.dataTables.css'
$(function() {
  const urlSearchParams = new URLSearchParams(window.location.search)
  const questionnaireId = urlSearchParams.get('questionnaireId')

  $('#table-submission').DataTable({
    ajax: {
      method: 'GET',
      url: `/api/submission?questionnaireId=${questionnaireId}`,
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
        data: 'student.name'
      },
      {
        data: 'student.nim'
      },
      {
        data: 'answers',
        render: (answers) => {
          return answers.map((answer) => answer.scale)
        }
      },
    ]
  })
})
