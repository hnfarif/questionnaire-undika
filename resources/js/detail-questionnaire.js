import $ from 'jquery'

$(function () {
  $(document).on('click', '.btn-delete', function () {
    var targetInputId = $(this).data('target')

    // Lakukan operasi hapus data menggunakan AJAX
    // $.ajax({
    //   url: '/path/to/delete/endpoint', // Ganti dengan URL endpoint penghapusan data
    //   type: 'DELETE', // Sesuaikan dengan metode yang sesuai
    //   data: { id: targetInputId }, // Sesuaikan dengan data yang perlu dikirim ke server
    //   success: function (response) {
    //     // Hapus elemen HTML setelah berhasil menghapus data
    //     $('#' + targetInputId)
    //       .closest('.question-group')
    //       .remove()
    //     console.log('Data berhasil dihapus')
    //   },
    //   error: function (error) {
    //     console.error('Gagal menghapus data:', error)
    //   },
    // })
    $('#' + targetInputId)
      .closest('.question-group')
      .remove()
  })

  $('.btn-add').on('click', function () {
    let target = $(this).data('target')
    // Dapatkan elemen pertama dari pertanyaan yang sudah ada sebagai referensi
    var referenceQuestion = $(`.${target}-question .question-group:first-child`).clone()

    // Kosongkan nilai input pada pertanyaan yang baru
    referenceQuestion.find('input').val('')

    var placeholderText = 'Pertanyaan baru ' + ($(`.${target}-question .question-group`).length + 1)
    referenceQuestion.find('input').attr('placeholder', placeholderText)

    // Ganti data-target pada tombol Hapus sesuai dengan pertanyaan yang baru
    var newQuestionTarget =
      `${target}Question` + ($(`.${target}-question .question-group`).length + 1)
    referenceQuestion.find('.btn-delete').attr('data-target', newQuestionTarget)

    // Ganti ID dan name pada input sesuai dengan pertanyaan yang baru
    referenceQuestion.find('input').attr('id', newQuestionTarget).attr('name', newQuestionTarget)

    // Sisipkan pertanyaan yang baru setelah pertanyaan yang sudah ada
    $(`.${target}-question`).append(referenceQuestion)
  })
})
