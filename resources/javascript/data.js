// donnÃ©es des activités
const activities = [
    {
        id: 1,
        name: "Football",
        description: "Apprends les bases du soccer tout en t’amusant: dribbles, passes et tirs, dans un esprit d’équipe!",
        image: "./resources/images/football.png",
        level: "Tous niveaux",
        coach: "Martin",
        schedule_day: "Samedi",
        schedule_time: "15h-18h",
        location: "Tous",
    },
    {
        id: 2,
        name: "Natation",
        description: "Nagez à votre rythme, détendez-vous, et profitez d’une ambiance apaisante!",
        image: "./resources/images/natation.png",
        level: "Tous niveaux",
        coach: "Simone",
        schedule_day: "Lundi",
        schedule_time: "19h - 21h",
        location: "Intérieur",
    },
    {
        id: 3,
        name: "Tennis",
        description: "Jouez à votre rythme, perfectionnez votre style, et profitez de matchs conviviaux.",
        image: "./resources/images/tennis.jpg",
        level: "Tous niveaux",
        coach: "Simone",
        schedule_day: "Mardi",
        schedule_time: "10h - 14h",
        location: "Intérieur",
    },
    {
        id: 4,
        name: "Volley",
        description: "Jouez sans pression, amusez-vous entre amis, et ressentez l'énergie du jeu.",
        image: "./resources/images/volley.png",
        level: "Tous niveaux",
        coach: "Pierre",
        schedule_day: "Mercredi",
        schedule_time: "15h-17h",
        location: "Intérieur",
    },
    {
        id: 5,
        name: "Basket",
        description: "Jouez sans pression, exprimez votre style, et partagez des moments fun avec une communauté passionnée.",
        image: "./resources/images/basket.png",
        level: "Tous niveaux",
        coach: "Martin",
        schedule_day: "Dimanche",
        schedule_time: "18h - 19h30",
        location: "Intérieur",
    },
];

document.addEventListener("DOMContentLoaded", init);

function init() {
    const pageLink = window.location.pathname;

    // Pour l'index
    if (pageLink.endsWith("index.html")) {
        displayPopularActivities();
    }

    // Pour la liste
    if (pageLink.endsWith("liste.html")){
        populateFilters();

        //Mettre par defaut (tous)
        const filtresTous = sauvegardeFiltre();
        displayFilteredActivities(filtresTous);

        // Lorsque le bouton appliquer est cliquer, il va afficher la liste des activites filtrers
        const btnApply = document.getElementById("appliquerFiltres");
        btnApply.addEventListener("click", () => {
            const filtresChoisis = sauvegardeFiltre();
            displayFilteredActivities(filtresChoisis);
        });
    }

}

// Sauvegarder les choix des filtres
function sauvegardeFiltre(){
    const filtres = {};

    filtres.niveau = document.querySelector('.niveauDiff').value;
    filtres.lieu = document.querySelector('.lieuDiff').value;
    filtres.coach = document.querySelector('.coachDiff').value;
    filtres.jour = document.querySelector('.jourDiff').value;

    const tabFiltre = [filtres.niveau, filtres.lieu, filtres.coach, filtres.jour];

    console.log(tabFiltre);

    return tabFiltre;
}

// affiche les activités populaires pour la page d'accueil
function displayPopularActivities() {

    let grosContaineur = document.querySelector('.grid-container');

    // Creer les divs (4)
    let tableauDiv = [];
    for(let i = 0; i < 4; i++){
        let div = document.createElement('div');
        div.classList.add("container");
        tableauDiv.push(div);
        grosContaineur.append(div);
        console.log(tableauDiv);
    }

    // Remplir les divs
    for(let i = 0; i < tableauDiv.length; i++){
        let image = document.createElement('img');
        image.classList.add("image-sport");
        image.setAttribute('src', activities[i].image)
        
        let p = document.createElement('p');
        p.textContent = activities[i].description;

        tableauDiv[i].append(image);
        tableauDiv[i].append(p);
    }
}

// gestion des filtres pour la page des activités
function populateFilters() {

    let filterContainer = document.querySelector('.blockFilter');
    let nomDesLabels = ["Niveau: ", "Lieu: ", "Entraineur: ", "Jour: "];
    let nomDesFiltres = ["niveauDiff", "lieuDiff", "coachDiff", "jourDiff"];

    let filtreNiveau = ["Tous niveaux", "Débutant", "Intermédiaire", "Avancé"];
    let filtreLieu = ["Tous", "Intérieur", "Extérieur"];
    let filtreCoach = ["Tous", "Martin", "Simone", "Pierre"];
    let filtreJour = ["Tous", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

    let tousLesFiltres = [filtreNiveau, filtreLieu, filtreCoach, filtreJour];

    
    // Creer les divs (4)
    let tableauFiltre = [];
    for(let i = 0; i < 4; i++){
        let filtreDiv = document.createElement('div');
        filtreDiv.classList.add("filtre");
        tableauFiltre.push(filtreDiv);
        filterContainer.append(filtreDiv);
    }

    // Remplir les divs
    for(let i = 0; i < tableauFiltre.length; i++){
        // Label
        let filtreLabel = document.createElement('label');
        filtreLabel.textContent = nomDesLabels[i];
        tableauFiltre[i].append(filtreLabel);

        // Select
        let filtreSelect = document.createElement('select');
        filtreSelect.classList.add(nomDesFiltres[i]);
        tableauFiltre[i].append(filtreSelect);

        // Remplir le Select
        for(let j = 0; j < tousLesFiltres[i].length; j++){
            let typeFiltre = tousLesFiltres[i];
            let filtreOption = document.createElement('option');
            filtreOption.textContent = typeFiltre[j];
            filtreSelect.append(filtreOption);
     
        }
    }

    // Ajouter le bouton
    let btnApply = document.createElement('button');
    btnApply.textContent = "Appliquer";
    btnApply.id = "appliquerFiltres";
    filterContainer.append(btnApply);

}

// affiche toutes les activités filtrées pour la page des activités (tableau de 4 elements)
function displayFilteredActivities(filters) {
    // ordre [niveau, lieu, coach, jour]
    const activiteFiltrer = activities.filter(activite => {
        return (
            (filters[0] === "Tous niveaux" || activite.level === filters[0]) &&     // Niveau
            (filters[1] === "Tous" || activite.location === filters[1]) &&          // Lieu
            (filters[2] === "Tous" || activite.coach === filters[2]) &&             // Coach
            (filters[3] === "Tous" || activite.schedule_day === filters[3])         // Jour
        );
    });

    console.log(activiteFiltrer);

    let grosContaineur = document.querySelector('.liste');

    // Reset la liste avant
    grosContaineur.innerHTML = "";

    // Creer les divs
    let tableauSport = [];
    for(let i = 0; i < activiteFiltrer.length; i++){
        let sportDiv = document.createElement('div');
        tableauSport.push(sportDiv);
        grosContaineur.append(sportDiv);
    }

    // Remplir les divs
    for(let i = 0; i < tableauSport.length; i++){
        // Image
        let image = document.createElement('img');
        image.classList.add("image-sport");
        image.setAttribute('src', activiteFiltrer[i].image);
        tableauSport[i].append(image);

        // Div.description
        let grosDiv = document.createElement('div');
        grosDiv.classList.add("description");
        tableauSport[i].append(grosDiv);

        
        // Titre
        let titre = document.createElement('h3');
        titre.textContent = activiteFiltrer[i].name;
        grosDiv.append(titre);

        // Description
        let desc = document.createElement('p');
        desc.textContent = activiteFiltrer[i].description;
        grosDiv.append(desc);

        // Paragraphe du jour
        let titreJour = document.createElement('strong');
        titreJour.textContent = "Horaire: ";
        let descJour = document.createTextNode(activiteFiltrer[i].schedule_day);
        let pJour = document.createElement('p');
        pJour.append(titreJour);
        pJour.append(descJour);
        grosDiv.append(pJour);

        // Paragraphe du niveau
        let titreNiveau = document.createElement('strong');
        titreNiveau.textContent = "Niveau: ";
        let descNiveau = document.createTextNode(activiteFiltrer[i].level);
        let pNiveau = document.createElement('p');
        pNiveau.append(titreNiveau);
        pNiveau.append(descNiveau);
        grosDiv.append(pNiveau);

        // Paragraphe du coach
        let titreCoach = document.createElement('strong');
        titreCoach.textContent = "Responsable: ";
        let descCoach = document.createTextNode(activiteFiltrer[i].coach);
        let pCoach = document.createElement('p');
        pCoach.append(titreCoach);
        pCoach.append(descCoach);
        grosDiv.append(pCoach);

        // Paragraphe du lieu
        let titreLieu = document.createElement('strong');
        titreLieu.textContent = "Lieu: ";
        let descLieu = document.createTextNode(activiteFiltrer[i].location);
        let pLieu = document.createElement('p');
        pLieu.append(titreLieu);
        pLieu.append(descLieu);
        grosDiv.append(pLieu);

        // Bouton modifier
        let boutonModifer = document.createElement('button');
        boutonModifer.classList.add("modifier");
        boutonModifer.textContent = "Modifier l'activité";

        let aLink = document.createElement('a');
        aLink.setAttribute('href', "modifOuAjout.html");
        aLink.append(boutonModifer);

        tableauSport[i].append(aLink);
    }

}


function populateForm(activity) {
   
}

