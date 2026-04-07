const CategorySelect = document.getElementById("sortCategory");
const SkillSelect = document.getElementById("sortSkill");
const projects = document.querySelectorAll(".Project");
const noResult = document.getElementById("noResult");


let nbProjectsFind = 0;



CategorySelect.addEventListener("change", e => {
    const selectedCategory = e.target.value;
    nbProjectsFind = 0;

    projects.forEach(project => {
        if ( (selectedCategory === "category-all" || project.classList.contains(selectedCategory)) && ((SkillSelect.value === "all" || project.classList.contains(SkillSelect.value))) ) {
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