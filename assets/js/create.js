
// gestion des files avec la preview

// variable / constante
const input = document.getElementById("Project_Images");
const preview = document.getElementById("picture-preview");



let dataTransfer = new DataTransfer();

// recupere les fichier envoyer et les affiche en preview
input.addEventListener("change", function () {


    //on traite chaque fichier 1 par 1
    Array.from(this.files).forEach(file => {

        //on ajoute le fichier dans le dataTransfer
        dataTransfer.items.add(file);

        //on creer un reader pour recuperer les info du fichier
        const reader = new FileReader();


        //une fois le fichier lu on lui creer sa preview
        reader.onload = e => {
            const article = document.createElement("article");
            article.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <a href="#" class="btn">Supprimer</a>
            `;



            //on verifie si l'utilisateur veut supprimer le fichier
            article.querySelector("a").addEventListener("click", e => {
                e.preventDefault();

                //on change le dataTransfer pour supprimer le fichier
                const newDT = new DataTransfer();
                Array.from(dataTransfer.files).forEach(f => {
                    if (f !== file) newDT.items.add(f);
                });

                //on remet tout a jour
                dataTransfer = newDT;
                input.files = dataTransfer.files;
                article.remove();
            });

            //on affiche la preview
            preview.appendChild(article);
        };

        //sert a afficher les images
        reader.readAsDataURL(file);
    });

    input.files = dataTransfer.files;
});

// creer un editeur de texte enrichi avec quill.js
if (document.getElementById("quill-editor")) {
    const quill = new Quill("#quill-editor", { theme: "snow" });
    document.querySelector("form").addEventListener("submit", () => {
        document.getElementById("content").value = quill.root.innerHTML;
    });
}


// ------------------- nombre du input range des skills -------------------

const skillLevel = document.getElementById("level");
const skillLabel = document.getElementById("levelLabel");

skillLabel.textContent = `Niveau: 0`;

skillLevel.addEventListener("input", e => {
    skillLabel.textContent = `Niveau: ${e.target.value}`;
});

