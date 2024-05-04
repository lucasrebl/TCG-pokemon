document.addEventListener('DOMContentLoaded', () => {
    const user = 'simeydotme';
    const repo = 'pokemon-cards-css';
    const filePath = 'public/data/cards.json';
    const apiUrl = `https://api.github.com/repos/${user}/${repo}/contents/${filePath}?ref=main`;

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            const fileContent = atob(data.content);
            const pokemonList = JSON.parse(fileContent);
            const containerPrincipal = document.getElementById('pokemonList'); // Assurez-vous que cet ID est présent dans votre HTML

            pokemonList.forEach(pokemon => {
                // Création de la div 'card'
                const card = document.createElement('div');
                card.classList.add('card');
                
                // Création de la div 'content-card'
                const contentCard = document.createElement('div');
                contentCard.classList.add('content-card');

                // Création de l'élément img
                const image = document.createElement('img');
                image.src = pokemon.images.small; // Assurez-vous que cette propriété existe dans votre objet Pokémon
                image.alt = "Image de " + pokemon.name; // Utilisez une propriété appropriée pour l'attribut alt

                // Assemblage de la structure
                contentCard.appendChild(image); // Ajout de l'img à 'content-card'
                card.appendChild(contentCard); // Ajout de 'content-card' à 'card'
                containerPrincipal.appendChild(card); // Ajout de 'card' au conteneur principal
            });
        })
        .catch(error => console.error('Erreur lors du chargement du fichier JSON:', error));
});
