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
                    const DataTransfert2 = new DataTransfer();
                    Array.from(dataTransfer.files).forEach(f => {
                        if (f !== file) DataTransfert2.items.add(f);
                    });
                    dataTransfer = DataTransfert2;
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

if (document.getElementById('quill-editor')) {
    const contentTextarea = document.getElementById('content');
    const quill = new Quill('#quill-editor', { theme: 'snow' });
    quill.root.innerHTML = contentTextarea.value;
    contentTextarea.closest('form').addEventListener('submit', () => {
        contentTextarea.value = quill.root.innerHTML;
    });
}
