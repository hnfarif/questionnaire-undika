import Chart from 'chart.js/auto'
import select2 from 'select2'
import 'select2/dist/css/select2.css'
import 'select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.css'

const backgroundColors = [
  'rgba(255, 99, 132, 0.2)',
  'rgba(255, 159, 64, 0.2)',
  'rgba(75, 192, 192, 0.2)',
  'rgba(47, 242, 21, 0.2)',
  'rgba(153, 102, 255, 0.2)',
]

const borderColors = [
  'rgb(255, 99, 132)',
  'rgb(255, 159, 64)',
  'rgb(75, 192, 192)',
  'rgb(47, 242, 21)',
  'rgb(153, 102, 255)',
]

$(function () {
  select2($)

  $('#select-questionnaire')
    .select2({
      theme: 'bootstrap-5',
    })
    .on('change', function (event) {
      const questionnaireId = parseInt(event.target.value)
      if (!questionnaireId) return

      $.get(`/api/questionnaire/${questionnaireId}`)
        .done(function (questionnaire) {
          drawStatistic(questionnaire)

          $.get(`/api/question?questionnaireId=${questionnaire.id}`)
            .done(function (questions) {
              $('#select-category')
                .off()
                .on('change', function (event) {
                  const categoryId = parseInt(event.target.value)
                  if (!categoryId) return

                  drawQuestionChart(
                    questionnaire,
                    'Mean',
                    'canvas-mean',
                    questions,
                    'mean',
                    categoryId
                  )
                  drawQuestionChart(
                    questionnaire,
                    'Mode',
                    'canvas-mode',
                    questions,
                    'mode',
                    categoryId
                  )
                  drawQuestionChart(
                    questionnaire,
                    'Median',
                    'canvas-median',
                    questions,
                    'median',
                    categoryId
                  )
                  drawQuestionChart(
                    questionnaire,
                    'Variance',
                    'canvas-variance',
                    questions,
                    'variance',
                    categoryId
                  )

                  $.get(`/api/dashboard`)
                    .done(function (categories) {
                      drawCategoryChart(categories, 'canvas-meanPerCategory', categoryId)
                    })
                    .fail(function (xhr) {
                      console.log(xhr.responseText)
                    })
                })

              $('#select-category').val(`${categories[0].id}`).trigger('change')
            })
            .fail(function (xhr) {
              console.log(xhr.responseText)
            })
        })
        .fail(function (xhr) {
          console.log(xhr.responseText)
        })
    })

  if (questionnaires.length) {
    $('#select-questionnaire').val(`${questionnaires[0].id}`).trigger('change')
  }
})

const charts = {}

const subscriptMap = {
  0: '₀',
  1: '₁',
  2: '₂',
  3: '₃',
  4: '₄',
  5: '₅',
  6: '₆',
  7: '₇',
  8: '₈',
  9: '₉',
}

function drawStatistic(questionnaire) {
  const numberOfStudents = questionnaire.study_program.students.length
  const numberOfSubmissions = questionnaire.submissions.length
  const semester = questionnaire.semester
  $('#stat-number-of-students').text(numberOfStudents)
  $('#stat-number-of-submissions').text(numberOfSubmissions)
  $('#stat-semester').text(semester)
}

const config = (data) => ({
  type: 'bar',
  data: data,
  options: {
    plugins: {
      legend: {
        display: false,
      },
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          font: {
            family: 'Consolas',
            size: 16,
          },
        },
      },
      x: {
        ticks: {
          font: {
            family: 'Consolas',
            size: 16,
          },
        },
      },
    },
  },
})

function drawQuestionChart(questionnaire, label, canvasId, questions, dataKey, categoryId) {
  const counter = {}
  const labels = questions
    .filter((question) => question.category_id === categoryId)
    .map((question) => {
      const number = counter[question.category_id]
      if (typeof number === 'undefined') {
        counter[question.category_id] = 1
      } else {
        counter[question.category_id] += 1
      }
      return `X${question.category_id} ${counter[question.category_id]}`.replace(
        /[0-9]/g,
        (match) => subscriptMap[match]
      )
    })

  const datasets = [
    {
      label: label,
      data: questions
        .filter((question) => question.category_id === categoryId)
        .map((question) => {
          if (dataKey !== 'mode') return question[dataKey]
          if (questionnaire.submissions.length < 3) return 0
          else return question[dataKey]
        }),
      backgroundColor: questions
        .filter((question) => question.category_id === categoryId)
        .map(
          (question) =>
            backgroundColors[
              categories.findIndex((category) => category.id === question.category_id)
            ]
        ),
      borderColor: questions
        .filter((question) => question.category_id === categoryId)
        .map(
          (question) =>
            borderColors[categories.findIndex((category) => category.id === question.category_id)]
        ),
      borderWidth: 1,
    },
  ]

  const data = { labels, datasets }

  if (charts[canvasId]) {
    charts[canvasId].destroy()
  }

  charts[canvasId] = new Chart(document.getElementById(canvasId).getContext('2d'), config(data))
}

function drawCategoryChart(categories, canvasId, categoryId) {
  const labels = categories
    .filter((category) => category.id == categoryId)
    .map((category) => category.name)

  const datasets = [
    {
      label: 'Mean Per Category',
      data: categories
        .filter((category) => category.id == categoryId)
        .map((category) => category.mean),
      backgroundColor: [
        backgroundColors[categories.findIndex((category) => category.id === categoryId)],
      ],
      borderColor: [borderColors[categories.findIndex((category) => category.id === categoryId)]],
      borderWidth: 1,
    },
  ]

  const data = { labels, datasets }

  if (charts[canvasId]) {
    charts[canvasId].destroy()
  }

  charts[canvasId] = new Chart(document.getElementById(canvasId).getContext('2d'), config(data))
}
