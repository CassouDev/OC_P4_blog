class Connect {
    constructor() {
        this.connection = document.querySelector('#connectButton');
        this.connectForm = document.querySelector('#adminForm');

        this.connection.addEventListener("click", this.connect.bind(this));
    }
    connect() {
        this.connectForm.style.display = "block";
    }
}
var connexion = new Connect;