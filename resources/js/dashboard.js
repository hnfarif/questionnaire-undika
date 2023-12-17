import $ from 'jquery'

$(function () {
    const sidebarToggle = $('#sidebarToggle');
    if (sidebarToggle.length) {

        sidebarToggle.on('click', function (event) {
            const body = $('body')
            event.preventDefault();
            body.toggleClass('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', body.hasClass('sb-sidenav-toggled'));
        });
    }
});
