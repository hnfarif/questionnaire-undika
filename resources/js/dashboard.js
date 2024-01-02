import Chart from 'chart.js/auto'

const backgroundColors = [
  'rgba(255, 99, 132, 0.2)',
  'rgba(255, 159, 64, 0.2)',
  'rgba(75, 192, 192, 0.2)',
  'rgba(47, 242, 21, 0.2)',
  'rgba(153, 102, 255, 0.2)'
]

const borderColors = [
  'rgb(255, 99, 132)',
  'rgb(255, 159, 64)',
  'rgb(75, 192, 192)',
  'rgb(47, 242, 21)',
  'rgb(153, 102, 255)'
]

$(function() {
  let selectedQuestionnaires = []
  $('#select-questionnaires').on('change', function(event) {
    const questionnaireId = event.target.value

    if (!questionnaireId) return

    $.get(`/api/questionnaire/${questionnaireId}`)
      .done(function(questionnaire) {
        if (!selectedQuestionnaires.find((selectedQuestionnaire) => selectedQuestionnaire.id === questionnaire.id)) {
          selectedQuestionnaires = [...selectedQuestionnaires, questionnaire]
        }

        drawRChart(selectedQuestionnaires)

        console.log(selectedQuestionnaires)
      })
      .fail(function(xhr) {
        console.log(xhr.responseText)
      })

    $(this).val('')
  })

  questionnaires.slice(0, 2).forEach((questionnaire) => {
    setTimeout(() => $('#select-questionnaires').val(questionnaire.id).trigger('change'), 200)
  })
})

function drawRChart(questionnaires) {
  const labels = categories.map((category) => category.name)

  const datasets = questionnaires.map((questionnaire, index) => ({
    label: questionnaire.title,
    data: Object.values(questionnaire.r),
    backgroundColor: backgroundColors[index],
    borderColor: borderColors[index],
    borderWidth: 1
  }))

  const data = { labels, datasets }

  const config = {
    type: 'bar',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            font: {
              family: 'Consolas',
              size: 16
            }
          }
        },
        x: {
          ticks: {
            font: {
              family: 'Consolas',
              size: 16
            }
          }
        }
      }
    }
  }

  if (window.chart) window.chart.destroy()

  window.chart = new Chart(document.getElementById('canvas-questionnaire-r').getContext('2d'), config)
}
