// Elementor Close Menu on click
document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function (event) {
        if (!event.target.closest('.elementor-nav-menu--toggle') && document.querySelector('.elementor-menu-toggle.elementor-active')) {
            document.querySelector('.elementor-menu-toggle.elementor-active').click();
        }
    });
});