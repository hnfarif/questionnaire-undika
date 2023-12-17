import $ from 'jquery'

$(function () {
    $('#btn-password-visibility').on('click', function (element) {
        const inputPassword = $('#input-password')
        const btnPasswordVisibility = $('#btn-password-visibility')
        if (inputPassword.prop('type') === 'password') {
            inputPassword.prop('type', 'text')
            btnPasswordVisibility.html('<i class="fa-solid fa-eye"></i>')
        } else {
            inputPassword.prop('type', 'password')
            btnPasswordVisibility.html('<i class="fa-solid fa-eye-slash"></i>')
        }
    })
})
