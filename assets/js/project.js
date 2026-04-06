const SelectedImage = document.getElementById("SelectedImage");
const ImageList = document.querySelectorAll(".Image_list img");

let currentImage = 0;
changeImage(currentImage);

ImageList.forEach((image, index) => {
    image.addEventListener("click", () => {
        changeImage(index);
    });
});




function changeImage(index) {
    SelectedImage.src = ImageList[index].src;
    currentImage = index;
}