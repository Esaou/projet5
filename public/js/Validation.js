class Validation {
    
    constructor() {

        this.name = document.getElementById('nom');
        this.profilName = document.getElementById('profil');
        this.profilPass = document.getElementById('profilPass');
        this.profilPassConfirm = document.getElementById('profilPassConfirm');
        this.email = document.getElementById('email');
        this.submit = document.getElementById('submit');
        this.submitProfil = document.getElementById('submitProfil');
        this.error = document.getElementById('error');
        
        this.nameCheck = /^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s-]{2,50}$/;
        this.emailCheck = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        this.passCheck = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,100})$/;

        if(this.submit){
            this.submit.addEventListener('click', (event)=>{
                this.validerMessage(event);
            });
        }

        if(this.submitProfil){
            this.submitProfil.addEventListener('click', (event)=>{
                this.validerProfil(event);
            });
        }

        

    }

    // Les différentes méthodes pour le fonctionnement de la validation
    
    validerMessage(event){

        if(this.name.value == "" ){
            event.preventDefault();
            this.error.style.display = 'flex';
            this.error.innerHTML = 'Renseignez votre nom !';      
        }else{
            if(!this.nameCheck.test(this.name.value)){
                event.preventDefault();
                this.error.style.display = 'flex';
                this.error.innerHTML = 'Le nom ne peut contenir que des lettres majuscules, minuscules, des espaces et tirets !';      
            }else{
                if(!this.emailCheck.test(this.email.value)){
                    event.preventDefault();
                    this.error.style.display = 'flex';
                    this.error.innerHTML = 'L\'email n\'est pas valide !';      
                }
            }
        }
        
    

    }

    validerProfil(event){

        if(this.profilName.value == "" ){
            event.preventDefault();
            this.error.style.display = 'flex';
            this.error.className = "alert alert-danger text-center";
            this.error.innerHTML = 'Renseignez un nom d\'utilisateur !';      
        }else{
            if(!this.passCheck.test(this.profilPass.value) && !this.passCheck.test(this.profilPassConfirm.value)){
                event.preventDefault();
                this.error.style.display = 'flex';
                this.error.className = "alert alert-danger text-center";
                this.error.innerHTML = 'Votre mot de passe doit contenir au moins 1 chiffre, une lettre minuscule, majuscule, un caractère spécial et 8 caractères minimum !';      
            }else{
                if(this.profilPass.value !== this.profilPassConfirm.value){
                    event.preventDefault();
                    this.error.style.display = 'flex';
                    this.error.className = "alert alert-danger text-center";
                    this.error.innerHTML = 'Mots de passe non-identiques !';      
                }
            }

        }
        
    

    }

}

const test = new Validation();

