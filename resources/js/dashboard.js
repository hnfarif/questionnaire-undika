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

  let selectedQuestionnaires = []
  $('#select-questionnaires')
    .select2({
      theme: 'bootstrap-5',
    })
    .on('change', function (event) {
      const questionnaireId = parseInt(event.target.value)
      if (!questionnaireId) return

      $(this).val('0').trigger('change')

      $.get(`/api/questionnaire/${questionnaireId}`)
        .done(function (questionnaire) {
          if (
            !selectedQuestionnaires.find(
              (selectedQuestionnaire) => selectedQuestionnaire.id === questionnaire.id
            )
          ) {
            selectedQuestionnaires = [...selectedQuestionnaires, questionnaire]
          }

          drawRChart(selectedQuestionnaires)
        })
        .fail(function (xhr) {
          console.log(xhr.responseText)
        })
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
    borderWidth: 1,
  }))

  const data = { labels, datasets }

  const config = {
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
  }

  if (window.chart) window.chart.destroy()

  window.chart = new Chart(
    document.getElementById('canvas-questionnaire-r').getContext('2d'),
    config
  )

  $('#selected-questionnaires-container').empty()

  questionnaires.forEach((questionnaire, index) => {
    $('#selected-questionnaires-container').append(`
      <div
        class="btn btn-sm"
        style="background-color: ${backgroundColors[index]}; border-color: ${borderColors[index]};">
        <button
          data-type="detail"
          data-questionnaire-id="${questionnaire.id}"
          style="max-width: 240px"
          class="text-truncate">
          ${questionnaire.title}
        </button>&nbsp;
        <button
          data-type="remove"
          data-questionnaire-id="${questionnaire.id}">
          <i class="ms-1 fa-solid fa-x fa-xs"></i>
        </button>
      </div>
    `)
  })

  $('#selected-questionnaires-container button')
    .off()
    .on('click', function () {
      const type = $(this).data('type')
      const questionnaireId = parseInt($(this).data('questionnaire-id'))

      if (type === 'remove') {
        const filteredQuestionnaires = questionnaires.filter(
          (questionnaire) => questionnaire.id !== questionnaireId
        )
        drawRChart(filteredQuestionnaires)
      }

      if (type === 'detail') {
        alert(questionnaireId)
        // TODO: questionnaire detail
      }
    })
}
