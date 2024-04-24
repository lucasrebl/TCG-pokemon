document.addEventListener('DOMContentLoaded', () => {
    const user = 'simeydotme';
    const repo = 'pokemon-cards-css';
    const filePath = 'public/data/cards.json';
    const apiUrl = `https://api.github.com/repos/${user}/${repo}/contents/${filePath}?ref=main`;

    let pokemonData = []; // Variable pour stocker les données des cartes Pokémon

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const fileContent = atob(data.content);
            pokemonData = JSON.parse(fileContent);

            // Extraire les IDs des cartes
            pokemonIds = pokemonData.map(pokemon => pokemon.id);
            
            // Envoyer les IDs au contrôleur PHP
            fetch('/shop', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(pokemonIds)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur HTTP ' + response.status);
                }
                console.log('IDs des cartes Pokémon envoyés avec succès !')
            })
            .catch(error => console.error('Erreur lors de l\'envoi des IDs des cartes Pokémon:', error));
        })
        .catch(error => console.error('Erreur lors du chargement du fichier JSON:', error));
        
    // Fonction pour sélectionner 10 cartes au hasard
    const selectRandomCards = () => {
        const containerPrincipal = document.getElementById('pokemonList');
        containerPrincipal.innerHTML = ''; // Efface le contenu précédent

        // Sélectionne 10 indices de cartes au hasard
        const randomIndices = [];
        while (randomIndices.length < 10) {
            const randomIndex = Math.floor(Math.random() * pokemonData.length);
            if (!randomIndices.includes(randomIndex)) {
                randomIndices.push(randomIndex);
            }
        }

        // Affiche les 10 cartes sélectionnées
        randomIndices.forEach(index => {
            const pokemon = pokemonData[index];
            const card = document.createElement('div');
            card.classList.add('card');
            const contentCard = document.createElement('div');
            contentCard.classList.add('content-card');
            const image = document.createElement('img');
            image.src = pokemon.images.small;
            image.alt = "Image de " + pokemon.name;
            contentCard.appendChild(image);
            card.appendChild(contentCard);
            containerPrincipal.appendChild(card);
        });
    };

    // Ajoute un gestionnaire d'événements au bouton
    const selectRandomButton = document.getElementById('selectRandomCards');
    selectRandomButton.addEventListener('click', selectRandomCards);
});
