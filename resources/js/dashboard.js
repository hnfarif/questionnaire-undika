import Chart from 'chart.js/auto'

$(function() {
  const options = {
    type: 'line',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [
        {
          label: '# of Votes',
          data: [12, 19, 3, 5, 2, 3],
          borderWidth: 1
        },
        {
          label: '# of Points',
          data: [7, 11, 5, 8, 3, 7],
          borderWidth: 1
        }
      ]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            reverse: false
          }
        }]
      }
    }
  }

  const ctx = document.getElementById('chartJSContainer').getContext('2d')
  new Chart(ctx, options)
})
