class Map {
    constructor(carte) {
        this.map = carte;   // map
        
        // Récupération des éléments HTML dans le DOM
        
        this.carte = document.getElementById('carte'); 
        this.btnRecentrer = document.getElementById('boutonRecentrer');

        // Création des icones pour marqueurs
        
        this.marqueur = L.icon({
            iconUrl: 'images/marqueurCarte.png',
            iconSize: [50, 50],
            popupAnchor: [0,-28],
        });
        
        this.btnRecentrer.addEventListener('click', ()=>{
            this.boutonRecentrer();
        });
    }

    // Les différentes méthodes pour le fonctionnement de la map
    
    // Méthode d'initialisation de la carte
    
    mapInit(){
        this.map;
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: '',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            accessToken: 'pk.eyJ1IjoiZXNhb3UiLCJhIjoiY2s0YjZxajJxMGF5NTNla2RlanZpdHU0aiJ9.WahFKT--zBVeywHI5U6i3Q'
        }).addTo(this.map);
        this.marqueurVert = L.marker([45.171905, 5.757263], {icon: this.marqueur}).addTo(this.map);
        this.marqueurVert.bindPopup('<p class="colorTitle" style="font-family:RobotoMedium;">Centre de santé l\'Étoile</p>');
    } 
    boutonRecentrer(){
        this.map.setView([45.171905, 5.757263],17);
    }
}

const carte = L.map('carte').setView([45.171749, 5.757089], 17);
const veloClic = new Map(carte);
veloClic.mapInit();