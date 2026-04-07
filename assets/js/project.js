const SelectedImage = document.getElementById("SelectedImage");
const ImageList = document.querySelectorAll(".Image_list img");

let currentImage = 0;
changeImage(currentImage);

//pour chaque image verifie si elle est cliquer et la mettre en grand
ImageList.forEach((image, index) => {
    image.addEventListener("click", () => {
        changeImage(index);
    });
});



//change l'image en grand
function changeImage(index) {
    SelectedImage.src = ImageList[index].src;
    currentImage = index;
}