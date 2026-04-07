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
        reader.onload = function (e) {
            const article = document.createElement("article");
            article.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <a href="#" class="btn">Supprimer</a>
            `;



            //on verifie si l'utilisateur veut supprimer le fichier
            article.querySelector("a").addEventListener("click", function (e) {
                e.preventDefault();

                //on change le dataTransfer pour supprimer le fichier
                const DataTransfert2 = new DataTransfer();
                Array.from(dataTransfer.files).forEach(f => {
                    if (f !== file) DataTransfert2.items.add(f);
                });

                //on remet tout a jour
                dataTransfer = DataTransfert2;
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
    const contentTextarea = document.getElementById("content");
    const quill = new Quill("#quill-editor", { theme: "snow" });
    quill.root.innerHTML = contentTextarea.value;
    contentTextarea.closest("form").addEventListener("submit", () => {
        contentTextarea.value = quill.root.innerHTML;
    });
}
