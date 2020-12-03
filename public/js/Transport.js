class Transport {
    
    constructor(){

        this.arret = document.getElementById('arret');
        this.traficR = document.getElementById('traficR');
        this.traficT = document.getElementById('traficT');
        this.callAPI();
        
    }

    // Les différentes méthodes pour la récupération et l'affichage
    
    async callAPI(){
            
        this.stations = await fetch("http://data.mobilites-m.fr/api/bbox/json?xmin=5.756668&xmax=5.757988&ymin=45.171806&ymax=45.172366&types=arret");
        this.station = await this.stations.json();
        this.station = this.station.features;
        
        this.trafics = await fetch("http://data.mobilites-m.fr/api/dyn/indiceTr/json");
        this.trafic = await this.trafics.json();
        this.trafic = this.trafic.IR1;

        this.traficTcs = await fetch("http://data.mobilites-m.fr/api/dyn/indiceTc/json");
        this.traficTc = await this.traficTcs.json();
        this.traficTc = this.traficTc.ITC1;

        this.traficTc.forEach(element => {

            if(element.indice == '1'){
                this.traficT.innerHTML = 'Service normal'
                this.traficT.style.color = 'rgb(100, 203, 74)'
            }else if(element.indice == '0'){
                this.traficT.innerHTML = 'Non communiqué'
                this.traficT.style.color = 'rgb(100, 100, 100)'
            }else if(element.indice == '2'){
                this.traficT.innerHTML = 'Service perturbé'
                this.traficT.style.color = 'orange'
            }else if(element.indice == '3'){
                this.traficT.innerHTML = 'Service très perturbé'
                this.traficT.style.color = 'red'
            }else if(element.indice == '5'){
                this.traficT.innerHTML = 'Hors horaires de service'
                this.traficT.style.color = 'rgb(100, 100, 100)'
            }   

        });

        this.trafic.forEach(element => {

            if(element.indice == '1'){
                this.traficR.innerHTML = 'Fluide'
                this.traficR.style.color = 'rgb(100, 203, 74)'
            }else if(element.indice == '0'){
                this.traficR.innerHTML = 'Non communiqué'
                this.traficR.style.color = 'rgb(100, 100, 100)'
            }else if(element.indice == '2'){
                this.traficR.innerHTML = 'Ralenti'
                this.traficR.style.color = 'orange'
            }else if(element.indice == '3'){
                this.traficR.innerHTML = 'Embouteillé'
                this.traficR.style.color = 'red'
            }else if(element.indice == '5'){
                this.traficR.innerHTML = 'Fermé'
                this.traficR.style.color = 'red'
            }   

        });

        this.station.forEach(element => {

            this.arret.innerHTML = this.ucFirst(element.properties.LIBELLE.toLowerCase());

        });
    }  
    
    ucFirst(str) {
         
        return str
        .toLowerCase()
        .split(' ')
        .map(function(word) {
            return word[0].toUpperCase() + word.substr(1);
        })
        .join(' ');

    }
   
}

const instance = new Transport();
