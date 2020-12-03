class Time {
    constructor() {
        this.dateHeure = document.getElementById('dateHeure');
        this.dateJour = document.getElementById('date');
        this.dateHeure = document.getElementById('heure');
        this.ouverture = document.getElementById('ouverture');
        this.showDate();
        this.refresh();
    }
    // Les differentes methodes
    refresh(){
        let chrono = setInterval(() => {this.showDate();},1000);
    }
    showDate() {
        this.date = new Date();
        this.h = this.date.getHours();
        this.m = this.date.getMinutes();
        this.s = this.date.getSeconds();
        this.moi = this.date.getMonth();
        this.mois = new Array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 
        'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        this.j = this.date.getDate();
        this.jour = this.date.getDay();
        this.jours = new Array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
        if( this.h < 10 ){ 
            this.h = '0' + this.h;
        }
        if( this.m < 10 ){ 
            this.m = '0' + this.m;
        }
        if( this.s < 10 ){ 
            this.s = '0' + this.s; 
        }
        if(this.j < 2){
            this.j = this.j + 'er';
        }else{
            this.j = this.j;
        }
        this.time = ', il est ' +  this.h + '<span class="spanHeure">h</span>' + this.m + '<span class="spanHeure">.</span>';
        this.timeDeux = 'Nous sommes le ' +  this.jours[this.jour] + ' ' + this.j + ' ' + this.mois[this.moi];
        this.dateHeure.innerHTML = this.time;
        this.dateJour.innerHTML = this.timeDeux;

     }
}

const timer = new Time();
