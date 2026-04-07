const image = document.getElementById("profil_image");
const input = document.getElementById("profil_image_input");



let dataTransfer = new DataTransfer();

input.addEventListener("change", e => {

    const file = e.target.files[0];

    dataTransfer.items.add(file);


    const reader = new FileReader();


    reader.onload = e => {
        
        image.src = e.target.result;

    };
    reader.readAsDataURL(file);
});

if (document.getElementById("quill-editor")) {
    const descriptionTextarea = document.getElementById("description");
    const quill = new Quill("#quill-editor", { theme: "snow" });
    quill.root.innerHTML = descriptionTextarea.value;
    descriptionTextarea.closest("form").addEventListener("submit", () => {
        descriptionTextarea.value = quill.root.innerHTML;
    });
}
