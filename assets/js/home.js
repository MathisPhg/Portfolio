const CategorySelect = document.getElementById("sortCategory");
const SkillSelect = document.getElementById("sortSkill");
const projects = document.querySelectorAll(".Project");
const noResult = document.getElementById("noResult");


let nbProjectsFind = 0;


// tri lorsque l'input select des Categories change
CategorySelect.addEventListener("change", e => {

    //on recupere la categorie selectionner et combien il y en a
    const selectedCategory = e.target.value;
    nbProjectsFind = 0;

    // pour chaque projet verfie si il correspond a la categorie et au skill selectionner
    projects.forEach(project => {

        //si le projet est bon il afficher sinon il passe en display none
        if ( (selectedCategory === "category-all" || project.classList.contains(selectedCategory)) && ((SkillSelect.value === "all" || project.classList.contains(SkillSelect.value))) ) {
            project.style.display = "";
            nbProjectsFind++;
        } else {
            project.style.display = "none";
        }
    });

    //si aucun projet est trouver afficher le message "Aucun projet trouver"
    if (nbProjectsFind === 0) {
        noResult.style.display = "block";
    } else {
        noResult.style.display = "";
    }
});


// meme chose mais inverse pour le skill
SkillSelect.addEventListener("change", e => {
    const selectedSkill = e.target.value;
    nbProjectsFind = 0;

    projects.forEach(project => {
        if ( (selectedSkill === "all" || project.classList.contains(selectedSkill)) && ((CategorySelect.value === "category-all" || project.classList.contains(CategorySelect.value))) ) {
            project.style.display = "";
            nbProjectsFind++;
        } else {
            project.style.display = "none";
        }
    });

    if (nbProjectsFind === 0) {
        noResult.style.display = "block";
    } else {
        noResult.style.display = "";
    }

});