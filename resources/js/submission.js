import 'datatables.net-dt'
import 'datatables.net-dt/css/jquery.dataTables.css'

$(function() {
  const urlSearchParams = new URLSearchParams(window.location.search)
  const questionnaireId = urlSearchParams.get('questionnaireId')

  let columns = [
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
    }
  ]

  $('th[data-is-question="true"]').each(function() {
    const questionId = parseInt($(this).data('question-id'))
    columns = [...columns, {
      data: null,
      render: (submission) => {
        const answer = submission.answers.find((answer) => answer.question_id === questionId)
        if (!answer) return 0

        return answer.scale
      }
    }]
  })

  $('#table-submission').DataTable({
    ajax: {
      method: 'GET',
      url: `/api/submission?questionnaireId=${questionnaireId}`,
      dataSrc: ''
    },
    columns: columns
  })
})
