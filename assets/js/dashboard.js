const image = document.getElementById("profil_image");
const input = document.getElementById("profil_image_input");



let dataTransfer = new DataTransfer();

// recupere l'image et la met en preview 
input.addEventListener("change", e => {

    //on recupere le fichier envoyer et on le met dans le dataTransfer
    const file = e.target.files[0];
    dataTransfer.items.add(file);


    const reader = new FileReader();

    //une fois le fichier lu on lui creer sa preview
    reader.onload = e => {
        
        image.src = e.target.result;

    };
    reader.readAsDataURL(file);
});


// creer un editeur de texte enrichi avec quill.js
if (document.getElementById("quill-editor")) {
    const descriptionTextarea = document.getElementById("description");
    const quill = new Quill("#quill-editor", { theme: "snow" });
    quill.root.innerHTML = descriptionTextarea.value;
    descriptionTextarea.closest("form").addEventListener("submit", () => {
        descriptionTextarea.value = quill.root.innerHTML;
    });
}
