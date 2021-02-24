class Connect {
    constructor() {
        this.connection = document.querySelector('#connectButton');
        this.connectForm = document.querySelector('#adminForm');
        this.body = document.getElementsByTagName("body");

        this.connection.addEventListener("click", this.connect.bind(this));
    }
    connect() {
        this.connectForm.style.display = "block";
        // this.body.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    }
}
var connexion = new Connect;