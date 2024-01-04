// exibir formulario para adicionar produtos
document.getElementById('toggleForm').addEventListener('click', function () {
    var form = document.querySelector('.contente');
    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'flex' : 'none';
});



// exibir imagem selecionada
document.getElementById('imagemInput').addEventListener('change', function (event) {
    const input = event.target;
    const preview = document.getElementById('imagemPreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
}); 



// exibir input de oferta quando selecionado
// Adiciona um ouvinte de eventos ao checkbox
document.getElementById('promocaoCheckbox').addEventListener('change', function () {
    // Obtém o estado do checkbox
    var promocaoCheckbox = this.checked;

    // Obtém a referência ao contêiner do preço da oferta
    var precoOfertaContainer = document.getElementById('precoOfertaContainer');

    // Define a exibição do contêiner com base no estado do checkbox
    precoOfertaContainer.style.display = promocaoCheckbox ? 'block' : 'none';
});

