
// gestion des files avec la preview


const input = document.getElementById("Project_Images");
const preview = document.getElementById("picture-preview");

if (input && preview) {


    
    let dataTransfer = new DataTransfer();

    input.addEventListener("change", function () {

        Array.from(this.files).forEach(file => {


            dataTransfer.items.add(file);

            const reader = new FileReader();



            reader.onload = function (e) {
                const article = document.createElement("article");
                article.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}">
                    <a href="#" class="btn">Supprimer</a>
                `;




                article.querySelector("a").addEventListener("click", function (e) {
                    e.preventDefault();
                    const newDT = new DataTransfer();
                    Array.from(dataTransfer.files).forEach(f => {
                        if (f !== file) newDT.items.add(f);
                    });
                    dataTransfer = newDT;
                    input.files = dataTransfer.files;
                    article.remove();
                });

                preview.appendChild(article);
            };

            reader.readAsDataURL(file);
        });

        input.files = dataTransfer.files;
    });
}

if (document.getElementById("quill-editor")) {
    const quill = new Quill("#quill-editor", { theme: "snow" });
    document.querySelector("form").addEventListener("submit", () => {
        document.getElementById("content").value = quill.root.innerHTML;
    });
}


// nombre du input range des skills

const skillLevel = document.getElementById("level");
const skillLabel = document.getElementById("levelLabel");

skillLabel.textContent = `Niveau: 0`;

skillLevel.addEventListener("input", e => {
    skillLabel.textContent = `Niveau: ${e.target.value}`;
});

