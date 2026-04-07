const shearchBar = document.getElementById("searchInput");
const listItems = document.querySelectorAll(".Object");
const ItemTitle = document.querySelectorAll(".ObjectTitle");
const noResults = document.querySelector(".NoResults");

let nbObjectFinnd = 0;
let searchTerm = shearchBar.value.toLowerCase();

//pour gerer l'affichage du message au chargement de la page
if (searchTerm !== "" && nbObjectFinnd === 0) {
    noResults.style.display = "";
} else {
    noResults.style.display = "none";
}

//verfie si le input pour la recherche change et affiche les resultats
shearchBar.addEventListener("input", e => {

    //la recherche en lowercase pour pas que les majuscules influe la recherche
    searchTerm = e.target.value.toLowerCase();

    nbObjectFinnd = 0;

    //pour chaque element verfie si son titre correspond a la recherche
    listItems.forEach((item, index) => {
        const title = ItemTitle[index].textContent.toLowerCase();

        //si il correspond il affiche sinon il passe en display none
        if (title.includes(searchTerm)) {
            item.style.display = "";
            nbObjectFinnd++;
        } else {
            item.style.display = "none";
        }
    });



    //si  aucun element est trouver alors on affiche le message "Pas de resultat"
    if (searchTerm !== "" && nbObjectFinnd === 0) {
        noResults.style.display = "";
    } else {
        noResults.style.display = "none";
    }
});
