import 'datatables.net-bs5'
import Chart from 'chart.js/auto'

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

  $('thead th[data-is-question="true"]').each(function() {
    const questionId = parseInt($(this).data('question-id'))
    columns = [
      ...columns,
      {
        data: null,
        render: (submission) => {
          const answer = submission.answers.find((answer) => answer.question_id === questionId)
          if (!answer) return `<span class="d-block w-100" style="cursor: pointer">0</span>`

          return `<span class="d-block w-100" style="cursor: pointer">${answer.scale}</span>`
        }
      }
    ]
  })

  const table = $('#table-submission').DataTable({
    ajax: {
      method: 'GET',
      url: `/api/submission?questionnaireId=${questionnaireId}`,
      dataSrc: ''
    },
    columns: columns,
    initComplete: () => {
      $('#select-category').appendTo('#table-submission_length')
    }
  })

  $('#select-category')
    .on('change', handleChangeCategory)
    .trigger('change')

  function handleChangeCategory(event) {
    table.columns().every(function() {
      this.visible(true)
    })

    const indexes = [
      ...new Set([
        0,
        1,
        2,
        ...[
          ...$('th[data-category-id]')
            .filter(function() {
              return parseInt($(this).data('category-id')) === parseInt(event.target.value)
            })
            .map(function() {
              return parseInt($(this).data('index'))
            })
        ]
      ])
    ]

    table.columns().every(function() {
      this.visible(indexes.includes(this.index()))
    })

    $('.btn-question').off().on('click', handleShowQuestion)
  }

  function handleShowQuestion(event) {
    event.stopPropagation()
    $('#modal-detail-question').modal('show')

    const description = $(this).parent().data('question-description')
    const category = $(this).parent().data('question-category')
    $('#title-category').text(category)
    $('#modal-detail-question .modal-body').html(description)
  }

  $('#btn-analytics-descriptive').on('click', function() {
    $('#modal-analytics-descriptive').modal('show')
  })

  const backgroundColors = categories.reduce((acc, category, index) => ({
    ...acc, [category.id]: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)'
    ][index]
  }), {})
  const borderColors = categories.reduce((acc, category, index) => ({
    ...acc, [category.id]: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)'
    ][index]
  }), {})

  const counter = {}
  const labels = questions.map((question) => {
    const number = counter[question.category_id]
    if (typeof  number === 'undefined') {
      counter[question.category_id] = 1
    }else {
      counter[question.category_id] += 1
    }
    return `X${question.category_id} ${counter[question.category_id]}`})
  const data = {
    labels: labels,
    datasets: [{
      label: 'Mean',
      data: questions.map((question) => question.mean),
      backgroundColor: questions.map((question) => backgroundColors[question.category_id]),
      borderColor: questions.map((question) => borderColors[question.category_id]),
      borderWidth: 1
    }]
  }

  const config = {
    type: 'bar',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  }

  const ctx = document.getElementById('canvas-analytics-descriptive').getContext('2d')
  new Chart(ctx, config)
})
