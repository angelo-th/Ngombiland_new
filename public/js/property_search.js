// ===================== MAP =====================
// Initialize map centered on Cameroon
const map = L.map('map').setView([5.6919, 9.3133], 7);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Variables
let userMarker, searchCircle, manualMarker;
let currentRadius = 5;

// DOM Elements
const useCurrentLocation = document.getElementById('useCurrentLocation');
const searchLocation = document.getElementById('searchLocation');
const radiusSlider = document.getElementById('radiusSlider');
const radiusValue = document.getElementById('radiusValue');
const propertyType = document.getElementById('propertyType');
const piecesGroup = document.getElementById('piecesGroup');

// Properties data (demo)
const properties = { 
    house1: {
        image: 'house1.jpg',
        title: 'Spacious House',
        price: '10,000,000 FCFA',
        location: 'Douala',
        description: 'A beautiful spacious house in Douala.',
        surface: '200 m²',
        rooms: 5,
        bedrooms: 3,
        bathrooms: 2
    }, 
    apartment1: {
        image: 'apartment1.jpg',
        title: 'Modern Apartment',
        price: '7,500,000 FCFA',
        location: 'Yaoundé',
        description: 'A modern apartment in Yaoundé.',
        surface: '120 m²',
        rooms: 3,
        bedrooms: 2,
        bathrooms: 1
    }, 
    studio1: {
        image: 'studio1.jpg',
        title: 'Cozy Studio',
        price: '2,000,000 FCFA',
        location: 'Bonabéri',
        description: 'A cozy studio in Bonabéri.',
        surface: '40 m²',
        rooms: 1,
        bedrooms: 1,
        bathrooms: 1
    }
};

// ===================== FUNCTIONS =====================

// Show/hide number of rooms
propertyType.addEventListener('change', function() {
    const selectedType = this.value;
    piecesGroup.classList.toggle('hidden', !(selectedType === 'house' || selectedType === 'apartment' || selectedType === 'studio' || selectedType === 'room'));
});

// Update radius display
radiusSlider.addEventListener('input', function() {
    currentRadius = this.value;
    radiusValue.textContent = currentRadius;
    updateSearchCircle();
});

// Toggle location mode
useCurrentLocation.addEventListener('change', function() {
    searchLocation.disabled = this.checked;
    searchLocation.placeholder = this.checked ? "Using current location" : "Douala, Yaoundé, Bonabéri...";
    if (this.checked) getUserLocation();
});

// Click map for manual location
map.on('click', function(e){
    if(!useCurrentLocation.checked){
        if(manualMarker) manualMarker.setLatLng(e.latlng);
        else manualMarker = L.marker(e.latlng, {icon: L.divIcon({className:'manual-marker',html:'📍',iconSize:[30,30]})}).addTo(map);
        updateSearchCircle(e.latlng);
    }
});

// Get user's location
function getUserLocation(){
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(pos=>{
            const coords=[pos.coords.latitude,pos.coords.longitude];
            if(userMarker) map.removeLayer(userMarker);
            if(searchCircle) map.removeLayer(searchCircle);
            userMarker=L.marker(coords,{icon:L.divIcon({className:'user-marker',html:'●',iconSize:[20,20],iconAnchor:[10,10]})}).addTo(map);
            map.setView(coords,12);
            updateSearchCircle(coords);
        },err=>{alert("Location error. Using default Douala."); updateSearchCircle([4.0511,9.7679]);}, {enableHighAccuracy:true});
    } else { alert("Geolocation not supported"); updateSearchCircle([4.0511,9.7679]); }
}

// Update search circle
function updateSearchCircle(center){
    const circleCenter = center || (userMarker ? userMarker.getLatLng() : map.getCenter());
    if(searchCircle) map.removeLayer(searchCircle);
    searchCircle = L.circle(circleCenter,{
        color:'#667eea', fillColor:'#667eea', fillOpacity:0.2, radius:currentRadius*1000
    }).addTo(map);
}

// Property modal
function openModal(id){
    const prop = properties[id];
    document.getElementById('modalImage').style.backgroundImage = `url('${prop.image}')`;
    document.getElementById('modalTitle').textContent = prop.title;
    document.getElementById('modalPrice').textContent = prop.price;
    document.getElementById('modalLocation').textContent = prop.location;
    document.getElementById('modalDescription').textContent = prop.description;
    document.getElementById('modalSurface').textContent = prop.surface;
    document.getElementById('modalRooms').textContent = prop.rooms;
    document.getElementById('modalBedrooms').textContent = prop.bedrooms;
    document.getElementById('modalBathrooms').textContent = prop.bathrooms;
    document.getElementById('propertyModal').style.display='block';
}
function closeModal(){ document.getElementById('propertyModal').style.display='none'; }

// Login modal
function openLoginModal(){ document.getElementById('loginModal').style.display='block'; }
function closeLoginModal(){ document.getElementById('loginModal').style.display='none'; }
function checkAuth(e){ e.preventDefault(); closeModal(); openLoginModal(); }
function login(){ alert('Demo login. In production, validate credentials and handle 500 FCFA deduction.'); closeLoginModal(); }

// Animate cards
document.addEventListener('DOMContentLoaded',function(){
    document.querySelectorAll('.animate-card').forEach(card=>{
        new IntersectionObserver(entries=>{
            entries.forEach(entry=>{
                if(entry.isIntersecting){ entry.target.classList.add('show'); this.unobserve(entry.target); }
            });
        }, {threshold:0.1,rootMargin:'0px 0px -50px 0px'}).observe(card);
    });
});

// Toggle user menu
function toggleUserMenu(){ document.getElementById('userMenu').classList.toggle('hidden'); }
document.addEventListener('click', function(event){
    const menu=document.getElementById('userMenu'); if(!event.target.closest('button')) menu.classList.add('hidden');
});

// Initialize
getUserLocation();
