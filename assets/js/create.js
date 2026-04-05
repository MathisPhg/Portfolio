// JS for the Create page - handles image file preview

const input = document.getElementById('Project_Images');
const preview = document.getElementById('picture-preview');

if (input && preview) {
    let dataTransfer = new DataTransfer();

    input.addEventListener('change', function () {

        Array.from(this.files).forEach(file => {
            

            dataTransfer.items.add(file);

            const reader = new FileReader();

            reader.onload = function (e) {
                const article = document.createElement('article');
                article.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}">
                    <button type="button" class="btn">Supprimer</button>
                `;

                article.querySelector('button').addEventListener('click', function () {
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
