$(document).ready(function(){

    let request = new XMLHttpRequest(); // 1- On crée notre objet AJAX
    // en jQuery $.ajax();
    request.onreadystatechange = function() {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
            let response = JSON.parse(this.responseText);
            console.log(response.current_condition.condition);
        }
    };
    request.open("GET", "https://www.prevision-meteo.ch/services/json/paris"); // 2- On demande à ouvrir une connexion
    request.send(); // 3- On envoie la requete
});

