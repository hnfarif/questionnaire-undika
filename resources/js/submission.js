import 'datatables.net-dt'
import 'datatables.net-dt/css/jquery.dataTables.css'
import 'perfect-scrollbar/css/perfect-scrollbar.css'

$(function () {
  const urlSearchParams = new URLSearchParams(window.location.search)
  const questionnaireId = urlSearchParams.get('questionnaireId')

  let columns = [
    {
      data: null,
      render: (data, row, type, meta) => {
        return meta.row + 1
      },
    },
    {
      data: 'student.name',
    },
    {
      data: 'student.nim',
    },
  ]

  $('thead th[data-is-question="true"]').each(function () {
    const isTotal = $(this).data('is-total')
    const categoryId = parseInt($(this).data('category-id'))
    if (isTotal) {
      columns = [
        ...columns,
        {
          data: null,
          render: (submission) => {
            const sum = submission.answers
              .filter((answer) => answer.question.category.id === categoryId)
              .reduce((count, answer) => answer.scale + count, 0)
            return sum
          },
        },
      ]
    } else {
      const questionId = parseInt($(this).data('question-id'))
      columns = [
        ...columns,
        {
          data: null,
          render: (submission) => {
            const answer = submission.answers.find((answer) => answer.question_id === questionId)
            if (!answer) return `<span class="d-block w-100" style="cursor: pointer">0</span>`

            return `<span class="d-block w-100" style="cursor: pointer">${answer.scale}</span>`
          },
        },
      ]
    }
  })

  const table = $('#table-submission').DataTable({
    ajax: {
      method: 'GET',
      url: `/api/submission?questionnaireId=${questionnaireId}`,
      dataSrc: '',
    },
    columns: columns,
  })

  const indexes = [0, 1, 2, 3, 4, 5, 6]

  table.columns().every(function () {
    this.visible(indexes.includes(this.index()))
  })

  $('.btn-question').off().on('click', handleShowQuestion)

  $('#select-category').on('change', function (event) {
    table.columns().every(function () {
      this.visible(true)
    })

    const indexes = [
      ...new Set([
        0,
        1,
        2,
        ...[
          ...$('th[data-category-id]')
            .filter(function () {
              return parseInt($(this).data('category-id')) === parseInt(event.target.value)
            })
            .map(function () {
              return parseInt($(this).data('index'))
            }),
        ],
      ]),
    ]

    table.columns().every(function () {
      this.visible(indexes.includes(this.index()))
    })

    $('.btn-question').off().on('click', handleShowQuestion)
  })

  function handleShowQuestion(event) {
    event.stopPropagation()
    $('#modal-detail-question').modal('show')

    const description = $(this).parent().data('question-description')
    const category = $(this).parent().data('question-category')
    $('#title-category').text(category)
    $('#modal-detail-question .modal-body').html(description)
  }

  $('tfoot th[data-is-xiyi="true"]').each(function () {})
})
