import Quill from 'quill'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import Swal from 'sweetalert2'

$(function () {
  const fullToolbar = [
    [{ font: [] }, { size: [] }],
    ['bold', 'italic', 'underline', 'strike'],
    [{ color: [] }, { background: [] }],
    [{ script: 'super' }, { script: 'sub' }],
    [{ header: '1' }, { header: '2' }, 'blockquote', 'code-block'],
    [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
    ['direction', { align: [] }],
    ['link', 'image', 'video', 'formula'],
    ['clean'],
  ]

  new Quill('#editor-add', {
    bounds: '#editor-add',
    placeholder: 'Type Something...',
    modules: {
      toolbar: fullToolbar,
    },
    theme: 'snow',
  })

  new Quill('#editor-update', {
    bounds: '#editor-update',
    placeholder: 'Type Something...',
    modules: {
      toolbar: fullToolbar,
    },
    theme: 'snow',
  })

  renderQuestions()

  $('.btn-add').on('click', function () {
    $('#modal-add .ql-editor').empty()

    const categoryId = $(this).data('category-id')
    const categoryName = $(this).data('category-name')

    $('#title-modal-add').text(categoryName)
    $('#modal-add').modal('show')

    $('#btn-save').off().on('click', handleSaveQuestion(categoryId))
  })

  function handleSaveQuestion(categoryId) {
    return () => {
      const description = $('#editor-add .ql-editor').html()

      if (!$('#editor-add .ql-editor').text().trim()) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Deskripsi harus diisi',
        })
        return
      }

      $('#btn-save').prop('disabled', true)

      $.post({
        url: '/api/question',
        data: JSON.stringify({ questionnaireId: questionnaire.id, categoryId, description }),
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .done(() => {
          $('#modal-add').modal('hide')
          renderQuestions()
          setTimeout(() => $('#btn-save').prop('disabled', false), 1000)
        })
        .fail((xhr) => {
          console.log(xhr.responseText)
          setTimeout(() => $('#btn-save').prop('disabled', false), 1000)
        })
    }
  }

  function renderQuestions() {
    const role = $('#body-section').data('role')
    $.get(`/api/question?questionnaireId=${questionnaire.id}`)
      .done(function (questions) {
        $('.question-items').empty()
        questions.forEach((question) => {
          $(`#accordion-${question.category_id} .question-items`).append(`
            <div
              id="question-${question.id}"
              data-question-id="${question.id}"
              data-category-id="${question.category_id}"
              class="question-item ${
                role === 'KAPRODI' && question.questionnaire.status !== 'APPROVED' ? 'question' : ''
              } input-group gap-3 mb-3">
                <div class="form-control flex-grow-1" style="cursor: text"> ${
                  question.description
                }</div>
                <div class="input-group-append my-auto">
                  ${
                    role === 'KAPRODI' && question.questionnaire.status !== 'APPROVED'
                      ? `<button data-question-id="${question.id}" type="button" class="btn btn-danger btn-delete">
                  <i class="fa-solid fa-trash"></i>
                </button>`
                      : ''
                  }

              </div>
            </div>
          `)
        })

        $('.question')
          .off()
          .on('click', function (event) {
            event.stopPropagation()

            $('#modal-update .ql-editor').empty()

            const questionId = $(this).data('question-id')
            const categoryId = $(this).data('category-id')

            $.get(`/api/question/${questionId}`)
              .done((question) => {
                $('#editor-update .ql-editor').html(question.description)

                $('#modal-update').modal('show')

                $('#btn-update')
                  .off()
                  .on('click', function () {
                    const description = $('#editor-update .ql-editor').html()

                    if (!$('#editor-update .ql-editor').text().trim()) {
                      Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Deskripsi harus diisi',
                      })
                      return
                    }

                    $('#btn-update').prop('disabled', true)

                    $.ajax({
                      url: `/api/question/${questionId}`,
                      method: 'PUT',
                      data: JSON.stringify({
                        questionnaireId: questionnaire.id,
                        categoryId,
                        description,
                      }),
                      headers: {
                        'Content-Type': 'application/json',
                      },
                      success: function () {
                        renderQuestions()
                        $('#modal-update').modal('hide')
                        setTimeout(() => $('#btn-update').prop('disabled', false), 1000)
                      },
                      body: JSON.stringify({ description }),
                      error: function (xhr) {
                        setTimeout(() => $('#btn-update').prop('disabled', false), 1000)
                        console.log(xhr.responseText)
                      },
                    })
                  })
              })
              .fail((xhr) => {
                console.log(xhr.responseText)
              })
          })

        $('.btn-delete')
          .off()
          .on('click', function (event) {
            event.stopPropagation()
            const questionId = $(this).data('question-id')

            Swal.fire({
              title: 'Are you sure you want to delete question?',
              showCancelButton: true,
              confirmButtonText: 'Delete',
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                $.ajax({
                  url: `/api/question/${questionId}`,
                  type: 'DELETE',
                  success: renderQuestions,
                  error: function (xhr) {
                    console.log(xhr.responseText)
                  },
                })
              }
            })
          })
      })
      .fail(function (xhr) {
        console.log(xhr.responseText)
      })

    $('#form-submit')
      .off()
      .on('submit', function (event) {
        event.preventDefault()
        let valid = true
        categories.forEach((category) => {
          const numberOfQuestions = $(`[data-category-id="${category.id}"].question-item`).length
          if (numberOfQuestions < 2) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: `Kategori ${category.name} harus memiliki minimal 2 pertanyaan`,
            })
            valid = false
            return
          }
        })
        if (valid) event.target.submit()
      })
  }

  $('#form-reject').on('submit', async function (event) {
    event.preventDefault()

    let noteInput
    const {
      value: { note },
    } = await Swal.fire({
      title: 'Form penolakan',
      html: `
        <div id="editor-note-container">
          <div class="border border-primary rounded" id="editor-note"></div>
        </div>
      `,
      width: '80%',
      confirmButtonText: 'Reject',
      focusConfirm: false,
      didOpen: () => {
        new Quill('#editor-note', {
          bounds: '#editor-note',
          placeholder: 'Type Something...',
          modules: {
            toolbar: fullToolbar,
          },
          theme: 'bubble',
        })

        const popup = Swal.getPopup()
        noteInput = popup.querySelector('#editor-note .ql-editor')
        // noteInput.onkeyup = Swal.clickConfirm()
      },
      preConfirm: () => {
        const note = noteInput.innerHTML
        if (!note) {
          Swal.showValidationMessage(`Please enter note`)
        }
        return { note }
      },
    })

    $('#input-note').val(note)

    event.target.submit()
  })

  $('.btn-note').on('click', function () {
    Swal.fire({
      title: 'Catatan',
      html: `
        <div class="text-start">${questionnaire.note}</div>
      `,
      showConfirmButton: false,
      showCloseButton: true,
      focusConfirm: false,
      width: '70%',
    })
  })
})
