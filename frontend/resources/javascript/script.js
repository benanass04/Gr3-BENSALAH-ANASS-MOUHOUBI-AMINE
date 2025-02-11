// Les tableaux 
let activities = [
    // {
    //     id: 1,
    //     name: "Football",
    //     description: "Apprends les bases du soccer tout en t’amusant: dribbles, passes et tirs, dans un esprit d’équipe!",
    //     image: "./resources/images/football.png",
    //     level: "Tous niveaux",
    //     coach: "Martin",
    //     schedule_day: "Samedi",
    //     schedule_time: "15h-18h",
    //     location: "Extérieur",
    // },
    // {
    //     id: 2,
    //     name: "Natation",
    //     description: "Nagez à votre rythme, détendez-vous, et profitez d’une ambiance apaisante!",
    //     image: "./resources/images/natation.png",
    //     level: "Tous niveaux",
    //     coach: "Simone",
    //     schedule_day: "Lundi",
    //     schedule_time: "19h - 21h",
    //     location: "Intérieur",
    // },
    // {
    //     id: 3,
    //     name: "Tennis",
    //     description: "Jouez à votre rythme, perfectionnez votre style, et profitez de matchs conviviaux.",
    //     image: "./resources/images/tennis.jpg",
    //     level: "Tous niveaux",
    //     coach: "Simone",
    //     schedule_day: "Mardi",
    //     schedule_time: "10h - 14h",
    //     location: "Intérieur",
    // },
    // {
    //     id: 4,
    //     name: "Volley",
    //     description: "Jouez sans pression, amusez-vous entre amis, et ressentez l'énergie du jeu.",
    //     image: "./resources/images/volley.png",
    //     level: "Tous niveaux",
    //     coach: "Pierre",
    //     schedule_day: "Mercredi",
    //     schedule_time: "15h-17h",
    //     location: "Intérieur",
    // },
    // {
    //     id: 5,
    //     name: "Basket",
    //     description: "Jouez sans pression, exprimez votre style, et partagez des moments fun avec une communauté passionnée.",
    //     image: "./resources/images/basket.png",
    //     level: "Tous niveaux",
    //     coach: "Martin",
    //     schedule_day: "Dimanche",
    //     schedule_time: "18h - 19h30",
    //     location: "Intérieur",
    // },
];
let popularActivities = [];

let locations = [];
let coaches = [];
let levels = [];

// On va separer le code en plusieurs etapes:
// 1st: on attend que le DOM soit loaded
// 2nd: lorsque le DOM est loader, on verifie on est sur quelle page
// dependament de la page, on fetches ce quon a besoin

// index a besoin des 4 activites randoms (GET /api/activities/random)
// liste a besoin des tous les activites, levels, coaches, locations (GET /api/activities/filter)
// modifier a besoin de tous les details de un activite (GET /api/activities/$id)
// on doit pouvoir mettre a jour une activite dans modifier (PUT /api/activities/$id)
// on doit pouvoir ajouter une activite dans modifier (POST /api/activities)

document.addEventListener("DOMContentLoaded", init);

function fetchActivities(){
    let baseUrl = 'http://localhost:8000/api/activities';

    fetch(baseUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur lors de la récupération des activitées');
        }
        return response.json();
    })
    .then(data => {
        activities = data;
        console.log(activities);
        fetchLocations();

    })
    .catch(error => {
        console.error('Erreur:', error);
    })
}

function fetchPopularActivities(){
    let baseUrl = 'http://localhost:8000/api/activities/random';

    fetch(baseUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur lors de la récupération des activitées populaires');
        }
        return response.json();
    })
    .then(data => {
        popularActivities = data;
        displayPopularActivities();
    })
    .catch(error => {
        console.error('Erreur:', error);
    })

}

function fetchLocations() {
    let baseUrl = 'http://localhost:8000/api/locations';

    return fetch(baseUrl)
        .then(response => {
            if (!response.ok) throw new Error('Erreur lors de la récupération des locations');
            return response.json();
        })
        .then(data => {
            locations = data;
            console.log("Locations chargées :", locations);
        });
}

function fetchCoach() {
    let baseUrl = 'http://localhost:8000/api/coaches';

    return fetch(baseUrl)
        .then(response => {
            if (!response.ok) throw new Error('Erreur lors de la récupération des entraîneurs');
            return response.json();
        })
        .then(data => {
            coaches = data;
            console.log("Coaches chargés :", coaches);
        });
}

function fetchLevels() {
    let baseUrl = 'http://localhost:8000/api/levels';

    return fetch(baseUrl)
        .then(response => {
            if (!response.ok) throw new Error('Erreur lors de la récupération des niveaux');
            return response.json();
        })
        .then(data => {
            levels = data;
            console.log("Niveaux chargés :", levels);
        });
}


function fetchFiltredActivities(filtres) {
    // Vérifier si filtres est bien un tableau
    if (!Array.isArray(filtres) || filtres.length < 3) {
        console.error("Erreur : filtres doit être un tableau avec 3 valeurs.");
        return;
    }



    // Transformer le tableau en objet clé-valeur
    const filtresObj = {
        level: filtres[0],      // "Expert"
        location: filtres[1],   // "Extérieur"
        coach: filtres[2]       // "Martin"
    };

    if (!filtresObj.location) delete filtresObj.location;
    if (!filtresObj.coach) delete filtresObj.coach;

    // Construire la query string correctement
    const params = new URLSearchParams(filtresObj).toString();
    console.log(filtresObj);
    let baseUrl = `http://localhost:8000/api/activities/filter?${params}`;

    console.log("Requête envoyée à :", baseUrl);

    fetch(baseUrl)
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur lors de la récupération des activités filtrées');
        }
        return response.json();
    })
    .then(data => {
        console.log("Données reçues :", data);
        displayFilteredActivities(data);
    })
    .catch(error => {
        console.error("Erreur :", error);
    });
}

function fetchInfo(id) {
    let baseUrl = `http://localhost:8000/api/activities/${id}`;

    console.log(`Requête envoyée à : ${baseUrl}`);

    fetch(baseUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la récupération des informations');
            }
            return response.json();
        })
        .then(data => {
            console.log("Données reçues :", data);

            if (!data || data.length === 0) {
                console.error("Activité non trouvée !");
                return;
            }

            populateForm(data[0]); // Remplir le formulaire avec les données reçues
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
}

function fetchAllData() {
    return new Promise((resolve, reject) => {
        fetchLocations()
            .then(fetchCoach)
            .then(fetchLevels)
            .then(() => {
                console.log("Toutes les données sont chargées !");
                resolve();
            })
            .catch(error => {
                console.error("Erreur lors du chargement des données :", error);
                reject(error);
            });
    });
}



function init() {
    const pageLink = window.location.pathname;
    const queryLink = window.location.search;

    // Liens header
    const logo = document.querySelector('.div-logo');
    logo.addEventListener("click", () => {
        window.location.href = 'index.html';
    });
    
    const boutonMenu = document.querySelector('.menu-bouton');
    boutonMenu.addEventListener("click", () => {
        window.location.href = 'index.html';
    });

    const boutonListe = document.querySelector('.liste-bouton');
    boutonListe.addEventListener("click", () => {
        window.location.href = 'liste.html';
    });

    const boutonAjout = document.querySelector('.ajout-bouton');
    boutonAjout.addEventListener("click", () => {
        window.location.href = 'modifier.html';
    });

    // Liens footer (externe)
    const insta = document.querySelector('.instagram');
    insta.addEventListener("click", () => {
        window.open("https://instagram.com", "_blank");
    });

    const facebook = document.querySelector('.facebook');
    facebook.addEventListener("click", () => {
        window.open("https://facebook.com", "_blank");
    });
    
    const youtube = document.querySelector('.youtube');
    youtube.addEventListener("click", () => {
        window.open("https://youtube.com", "_blank");
    });

    // Pour l'index
    if (pageLink.endsWith("index.html")) {
        //Liens       
        const boutonTousNosActivites = document.querySelector('.bouton-plus');
        boutonTousNosActivites.addEventListener("click", () => {
            window.location.href = 'liste.html';
        });

        fetchPopularActivities();

    }

    // Pour la liste
    else if (pageLink.endsWith("liste.html")){
        // Liens
        const boutonAjouterActivite = document.querySelector('.ajouter');
        boutonAjouterActivite.addEventListener("click", () => {
            window.location.href = 'modifier.html';
        })

        fetchActivities();

        // const filtresTous = sauvegardeFiltre();
        // displayFilteredActivities(filtresTous);

    }

    // Pour modifier
    else if (queryLink.includes("?")){
        const params = new URLSearchParams(window.location.search);
        const activiteID = parseInt(params.get("id"));

        fetchAllData().then(() => {
            fetchInfo(activiteID);
        });
    
    }
}

// Sauvegarder les choix des filtres
function sauvegardeFiltre(){
    let filtres = {};

    filtres.niveau = document.querySelector('.niveauDiff').value;
    filtres.lieu = document.querySelector('.lieuDiff').value;
    filtres.coach = document.querySelector('.coachDiff').value;

    console.log(filtres.lieu);

    if (filtres.lieu == "Tous"){
        delete filtres.lieu;
    }
    if (filtres.coach == "Tous"){
        delete filtres.coach;
    }

    const tabFiltre = [filtres.niveau, filtres.lieu, filtres.coach];

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
        image.setAttribute('src', popularActivities[i].image);
        
        let p = document.createElement('p');
        p.textContent = popularActivities[i].description;

        tableauDiv[i].append(image);
        tableauDiv[i].append(p);
    }
}

// Afficher tous les activites 
function displayAllActivities(){

    displayFilteredActivities(null);
}

// gestion des filtres pour la page des activités
function populateFilters() {

    let filterContainer = document.querySelector('.blockFilter');
    let nomDesLabels = ["Niveau: ", "Lieu: ", "Entraineur: "];
    let nomDesFiltres = ["niveauDiff", "lieuDiff", "coachDiff"];

    // Créer les filtres
    let filtreNiveau = [];
    let filtreLieu = [];
    let filtreCoach = [];

    // Filtre pour tous (sauf pour level)
    const TOUS = "Tous";

    // Remplir les filtres
    for(let i = 0; i < activities.length ; i++){
        // level_id
        unNiveau = activities[i].level_id;
        console.log("Niveau "+unNiveau);
        console.log(levels[unNiveau-1]);
        if(!filtreNiveau.includes(levels[unNiveau-1].name)){
            filtreNiveau.push(levels[unNiveau-1].name);
        }

        // location_id
        unLieu = activities[i].location_id;
        console.log("Location "+unLieu);
        console.log(locations[unLieu-1]);
        if(!filtreLieu.includes(locations[unLieu-1].name)){
            filtreLieu.push(locations[unLieu-1].name);
        }
        

        // coach_id
        unCoach = activities[i].coach_id;
        console.log("Coach"+unCoach);
        console.log(coaches[unCoach-1]);
        if(!filtreCoach.includes(coaches[unCoach-1].name)){
            filtreCoach.push(coaches[unCoach-1].name);
        }
    }

    filtreLieu.push(TOUS);
    filtreCoach.push(TOUS);
    

    // let filtreNiveau = ["Tous niveaux", "Débutant", "Intermédiaire", "Avancé"];
    // let filtreLieu = ["Intérieur", "Extérieur"];
    // let filtreCoach = ["Martin", "Simone", "Pierre"];

    let tousLesFiltres = [filtreNiveau, filtreLieu, filtreCoach];

    
    // Creer les divs (4)
    let tableauFiltre = [];
    for(let i = 0; i < tousLesFiltres.length; i++){
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

    btnApply.addEventListener("click", () => {
        console.log(" Bouton Appliquer cliqué !");
        const filtresChoisis = sauvegardeFiltre();
        console.log(filtresChoisis);
        fetchFiltredActivities(filtresChoisis);
        // displayFilteredActivities(filtresChoisis);
    });


}

// affiche toutes les activités filtrées pour la page des activités (tableau de 4 elements)
function displayFilteredActivities(listeDesActivitesFiltrer) {
    // ordre [niveau, lieu, coach]

    if (listeDesActivitesFiltrer == null){

        listeDesActivitesFiltrer = activities;
        console.log('tous');

    }
    // else{

    //     listeDesActivitesFiltrer = activities.filter(activite => {
    //         return (
    //             (activite.level_id === filters[0]) &&               // Niveau
    //             (activite.location_id === filters[1]) &&            // Lieu
    //             (activite.coach_id === filters[2])                  // Coach
    //         );
    //     });

    // }

    let grosContaineur = document.querySelector('.liste');

    // Reset la liste avant
    grosContaineur.innerHTML = "";

    // Creer les divs
    let tableauSport = [];
    for(let i = 0; i < listeDesActivitesFiltrer.length; i++){
        let sportDiv = document.createElement('div');
        tableauSport.push(sportDiv);
        grosContaineur.append(sportDiv);
    }

    // Remplir les divs
    for(let i = 0; i < tableauSport.length; i++){
        // Image
        let image = document.createElement('img');
        image.classList.add("image-sport");
        image.setAttribute('src', listeDesActivitesFiltrer[i].image);
        tableauSport[i].append(image);

        // Div.description
        let grosDiv = document.createElement('div');
        grosDiv.classList.add("description");
        tableauSport[i].append(grosDiv);
        
        // Titre
        let titre = document.createElement('h3');
        titre.textContent = listeDesActivitesFiltrer[i].name;
        grosDiv.append(titre);

        // Description
        let desc = document.createElement('p');
        desc.textContent = listeDesActivitesFiltrer[i].description;
        grosDiv.append(desc);

        // Paragraphe du jour
        let titreJour = document.createElement('strong');
        titreJour.textContent = "Horaire: ";
        let descJour = document.createTextNode(listeDesActivitesFiltrer[i].schedule_day);
        let pJour = document.createElement('p');
        pJour.append(titreJour);
        pJour.append(descJour);
        grosDiv.append(pJour);

        // Paragraphe du niveau
        let titreNiveau = document.createElement('strong');
        titreNiveau.textContent = "Niveau: ";
        // Le id des levels est (listeDesActivitesFiltrer[i].level_id-1)
        let descNiveau = document.createTextNode(levels[listeDesActivitesFiltrer[i].level_id-1].name);
        let pNiveau = document.createElement('p');
        pNiveau.append(titreNiveau);
        pNiveau.append(descNiveau);
        grosDiv.append(pNiveau);

        // Paragraphe du coach
        let titreCoach = document.createElement('strong');
        titreCoach.textContent = "Responsable: ";
        // Le id des coaches est (listeDesActivitesFiltrer[i].coach_id-1)
        let descCoach = document.createTextNode(coaches[listeDesActivitesFiltrer[i].coach_id-1].name);
        let pCoach = document.createElement('p');
        pCoach.append(titreCoach);
        pCoach.append(descCoach);
        grosDiv.append(pCoach);

        // Paragraphe du lieu
        let titreLieu = document.createElement('strong');
        titreLieu.textContent = "Lieu: ";
        // Le id des locations est (listeDesActivitesFiltrer[i].location_id-1)
        let descLieu = document.createTextNode(locations[listeDesActivitesFiltrer[i].location_id-1].name);
        let pLieu = document.createElement('p');
        pLieu.append(titreLieu);
        pLieu.append(descLieu);
        grosDiv.append(pLieu);

        // Bouton modifier
        let boutonModifer = document.createElement('button');
        boutonModifer.classList.add("modifier");
        boutonModifer.textContent = "Modifier l'activité";

        boutonModifer.setAttribute('data-id', listeDesActivitesFiltrer[i].id);

        // Lorsque cliquer
        boutonModifer.addEventListener('click', () => {
            const activiteID = boutonModifer.getAttribute('data-id');

            window.location.href = 'modifier.html?id='+activiteID;
        })

        tableauSport[i].append(boutonModifer);
    }

}

// Remplir le formulaire de modifier
function populateForm(activity) {

    grosContaineur = document.querySelector('.container');

    // Titre
    let inputNom = document.querySelector('.nomActivite');
    inputNom.value = activity.name;
    console.log(activity.name);

    // Desc
    let inputDesc = document.querySelector('.descActivite');
    inputDesc.value = activity.description;

    // Image
    let inputImg = document.querySelector('.imgActivite');
    inputImg.value = activity.image;

    // Niveau
    let selectNiveau = document.querySelector('.niveauDiff');
    selectNiveau.value = levels[activity.level_id-1].name;

    // Lieu
    let selectLieu = document.querySelector('.lieu');
    selectLieu.value = locations[activity.location_id-1].name;

    // Coach
    let selectCoach = document.querySelector('.coachDiff');
    selectCoach.value = coaches[activity.coach_id-1].name;

    // Créer le bouton 
    let boutonEnregistrer = document.createElement('button');
    boutonEnregistrer.classList.add("enregistrer");
    boutonEnregistrer.textContent = "Enregistrer";
    grosContaineur.append(boutonEnregistrer);

    boutonEnregistrer.addEventListener('click', () => {
        updateActivity(activity.id);
    })
}

function updateActivity(activityId) {
    let nouvelleActivity = {
        name: document.querySelector('.nomActivite').value,
        description: document.querySelector('.descActivite').value,
        image: document.querySelector('.imgActivite').value,
        level_id: levels.find(l => l.name === document.querySelector('.niveauDiff').value).id,
        location_id: locations.find(loc => loc.name === document.querySelector('.lieu').value).id,
        coach_id: coaches.find(coach => coach.name === document.querySelector('.coachDiff').value).id
    };

    console.log("Nouvelle activité mise à jour:", nouvelleActivity);

    // Envoyer une requête PUT pour mettre à jour l'activité
    fetch(`http://localhost:8000/api/activities/${activityId}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json"
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Erreur lors de la mise à jour de l'activité");
        }
        return response.json();
    })
    .then(data => {
        console.log("Mise à jour réussie :", data);
        alert("L'activité a été mise à jour avec succès !");
    })
    .catch(error => {
        console.error("Erreur :", error);
        alert("Erreur lors de la mise à jour !");
    });
}
