const cityInput = document.getElementById("city_display");
const cityIdInput = document.getElementById("city_id");
const suggestionsContainer = document.getElementById("suggestions");

cityInput.addEventListener("input", async function () {
    const query = this.value.trim();

    if (query.length === 0) {
        suggestionsContainer.innerHTML = "";
        return;
    }

    try {
        const response = await fetch(`/product_order/ajax/getCities.php?search=${encodeURIComponent(query)}`);
        const cities = await response.json();

        // Affiche les suggestions
        suggestionsContainer.innerHTML = cities
            .map((city) =>
                `<div class="suggestion-item" data-id="${city.id}">
                    [${city.postal_code}] ${city.city_name}
                </div>`
            )
            .join("");

        // Ajouter un événement pour sélectionner une ville
        document.querySelectorAll(".suggestion-item").forEach((item) => {
            item.addEventListener("click", function () {
                cityInput.value = this.textContent.trim();
                cityIdInput.value = this.getAttribute("data-id");
                suggestionsContainer.innerHTML = "";
            });
        });
    } catch (error) {
        console.error("Erreur lors de la récupération des villes :", error);
    }
});

// Réinitialise l'ID si l'utilisateur modifie manuellement le champ
cityInput.addEventListener("blur", function () {
    if (!cityIdInput.value) {
        // On efface la saisie si aucun ID n'est sélectionné
        cityInput.value = "";
    }
});