document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.toggle-btn');
    const screenHeight = window.matchMedia("(max-width: 900px)"); // Changed to check height instead of width

    function adjustSidebar(e) {
        if (e.matches) {

            sidebar.classList.add('resize');
        } else {

            sidebar.classList.remove('resize');
        }
    }

    if (toggle) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    } else {
        console.log('Le bouton toggle n\'a pas été trouvé');
    }

    document.querySelectorAll('.disabled a').forEach(href => {
        href.removeAttribute('href');
    });

    adjustSidebar(screenHeight);

    screenHeight.addEventListener('change', adjustSidebar);
});
