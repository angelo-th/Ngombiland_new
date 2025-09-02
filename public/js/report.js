document.addEventListener('DOMContentLoaded', function () {
    // Carte Leaflet
    const map = L.map('map').setView([4.05, 9.7], 13); // Douala par défaut
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker;

    // Cliquer sur la carte pour placer le marker
    map.on('click', function(e) {
        if(marker) map.removeLayer(marker);
        marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
    });

    // Confirmer position GPS
    document.getElementById('confirm-location').addEventListener('click', function() {
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(function(pos){
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                if(marker) map.removeLayer(marker);
                marker = L.marker([lat, lng]).addTo(map);
                map.setView([lat, lng], 15);
                alert('Position confirmée !');
            });
        } else {
            alert('Géolocalisation non supportée par votre navigateur.');
        }
    });

    // Soumettre le rapport
    document.getElementById('report-form').addEventListener('submit', function(e){
        e.preventDefault();
        alert('Rapport soumis avec succès !');
        this.reset();
    });
});
