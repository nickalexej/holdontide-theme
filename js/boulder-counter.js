document.addEventListener('DOMContentLoaded', function () {
    function updateBoulderCounter() {
        fetch('/wp-admin/admin-ajax.php?action=get_boulder_counter')
            .then(response => response.json())
            .then(data => {
                const counterElement = document.getElementById('boulder-counter');
                if (data && data.counter !== undefined) {
                    counterElement.textContent = 'Aktuelle Besucher: ' + data.counter;
                } else {
                    counterElement.textContent = 'Daten konnten nicht geladen werden';
                }
            })
            .catch(error => {
                document.getElementById('boulder-counter').textContent = 'Daten konnten nicht geladen werden';
            });
    }

    updateBoulderCounter();
});
