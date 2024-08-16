jQuery(document).ready(function ($) {
    function updateBoulderCounter() {
        $.ajax({
            url: 'https://backend.boulderado.app/api/gethc?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjdXN0b21lciI6IlRoZVRpZGVIZWR3aWdlbmtvb2cyODIzIn0.uLSXuX6dkmy8b3hJ97k_GQFsmDe5jtfB-JY_QVhM3Fk&sector=Boulderhalle',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data && data.counter !== undefined) {
                    $('#boulder-counter').text('Aktuelle Besucher: ' + data.counter);
                } else {
                    $('#boulder-counter').text('Daten konnten nicht geladen werden');
                }
            },
            error: function () {
                $('#boulder-counter').text('Daten konnten nicht geladen werden');
            }
        });
    }

    // Initiales Laden der Daten
    updateBoulderCounter();

    // Aktualisieren alle 5 Minuten
    setInterval(updateBoulderCounter, 300000); // 300000 Millisekunden = 5 Minuten
});