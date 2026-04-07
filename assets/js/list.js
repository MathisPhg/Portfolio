const shearchBar = document.getElementById("searchInput");
const listItems = document.querySelectorAll(".Object");
const ItemTitle = document.querySelectorAll(".ObjectTitle");
const noResults = document.querySelector(".NoResults");

let nbObjectFinnd = 0;
let searchTerm = shearchBar.value.toLowerCase();

if (searchTerm !== "" && nbObjectFinnd === 0) {
    noResults.style.display = "";
} else {
    noResults.style.display = "none";
}

shearchBar.addEventListener("input", e => {
    searchTerm = e.target.value.toLowerCase();

    nbObjectFinnd = 0;
    listItems.forEach((item, index) => {
        const title = ItemTitle[index].textContent.toLowerCase();

        if (title.includes(searchTerm)) {
            item.style.display = "";
            nbObjectFinnd++;
        } else {
            item.style.display = "none";
        }
    });




    if (searchTerm !== "" && nbObjectFinnd === 0) {
        noResults.style.display = "";
    } else {
        noResults.style.display = "none";
    }
});
