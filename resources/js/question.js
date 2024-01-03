$(function() {
  $('#form-question').on('submit', function(event) {
    event.preventDefault()

    let allAnswered = true

    $('.question[data-question-id]').each(function() {
      const questionId = parseInt($(this).data('question-id'))

      const answered = $(`[data-question-id="${questionId}"] input`).toArray().some((checkbox) => $(checkbox).is(':checked'))

      $(this).children('.card-footer').remove()

      if (!answered) {
        allAnswered = false
        $(this).append(`<div class="card-footer text-danger">Wajib pilih salah satu</div>`)
      }
    })

    if (allAnswered) event.target.submit()
  })


  $('input[type="radio"]').on('change', function() {
    const questionId = $(this).data('question-id')
    if ($(this).is(':checked')) {
      $(`.question[data-question-id="${questionId}"]`).children('.card-footer').remove()
    }
  })
})
