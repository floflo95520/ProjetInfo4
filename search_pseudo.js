// Fonction pour charger le fichier JSON
function loadUserData(callback) {
    fetch('clientsnew.json').then(response => response.json()).then(data => {
            callback(data);
        })
        .catch(error => console.error('Erreur de chargement du fichier JSON:', error));
}

// Fonction de recherche d'utilisateur par pseudo
function searchpseudo() {
    const bar_client = document.getElementById('searchBar').value.toLowerCase(); // Insensible à la casse
    const in_results = document.getElementById('results'); // Récup les résultats
    in_results.innerHTML = ''; // Remise à 0

    if (bar_client === '') {
        return;
    }

    loadUserData(userData => {
        // Filtre les utilisateurs dont le pseudo contient la bar_client
        const results = userData.utilisateur.filter(user => {
            const pseudo = user.Pseudo.toLowerCase(); // Pseudo insensible à la casse
            return pseudo.includes(bar_client); // Le pseudo contient la bar_client??
        });

        // Le reste c'est pour l'affichage
        if (results.length > 0) {
            results.forEach(user => {
                const userElement = document.createElement('div');
                userElement.className = 'user';
                userElement.textContent = `Pseudo: ${user.Pseudo}, Nom: ${user.Nom}, Prénom: ${user.Prenom}`;
                in_results.appendChild(userElement);
            });
        } else {
            in_results.textContent = 'Aucun utilisateur trouvé.';
        }
    });
}
