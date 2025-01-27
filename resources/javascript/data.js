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
        location: "Interieur et Exterieur",
    },
    {
        id: 2,
        name: "Natation",
        description: "Nagez à votre rythme, détendez-vous, et profitez d’une ambiance apaisante!",
        image: "./resources/images/natation.png",
        level: "Tous niveaux",
        coach: "Simone",
        schedule_day: "Lundi, Mercredi, Vendredi",
        schedule_time: "19h - 21h",
        location: "Interieur",
    },
    {
        id: 3,
        name: "Tennis",
        description: "Jouez à votre rythme, perfectionnez votre style, et profitez de matchs conviviaux.",
        image: "./resources/images/tennis.jpg",
        level: "Tous niveaux",
        coach: "Simone",
        schedule_day: "Mardi-Jeudi",
        schedule_time: "10h - 14h",
        location: "Interieur",
    },
    {
        id: 4,
        name: "Volley",
        description: "Jouez sans pression, amusez-vous entre amis, et ressentez l'énergie du jeu.",
        image: "./resources/images/volley.png",
        level: "Tous niveaux",
        coach: "Pierre",
        schedule_day: " Lundi, Mercredi, Vendredi",
        schedule_time: "15h-17h",
        location: "Interieur",
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
        location: "Interieur",
    },
];

function init() {
    const pageLink = window.location.pathname;

    // Pour l'index
    if (pageLink === "/index.html" || pageLink.endsWith("index.html")) {
        displayPopularActivities();
        console.log("what");
    }

    // 

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
        let id = i + 1;

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
    
}

// affiche toutes les activités filtrées pour la page des activités
function displayFilteredActivities(filters) {
    
}

function populateForm(activity) {
   
}

document.addEventListener("DOMContentLoaded", init());