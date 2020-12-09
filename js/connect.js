class Connect {
    constructor() {
        this.connexion = document.querySelector('#boutonConnect');
        this.connectForm = document.querySelector('#connectForm');

        this.connexion.addEventListener("click", this.connect.bind(this));
    }
    connect() {
        this.connectForm.style.display = "block";
    }
}
var connexion = new Connect;