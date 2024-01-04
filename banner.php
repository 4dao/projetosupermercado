<?php
// Inclui o arquivo de configuração
require_once 'config.php';

// Inclui a classe BannerDaoMysql que lida com operações no banco de dados relacionadas a banners
require_once 'dao/BannerDaoMysql.php';

// Cria uma instância da classe BannerDaoMysql, passando a conexão PDO como parâmetro
$bannerDao = new BannerDaoMysql($pdo);

// Lê os banners do banco de dados
$banner = $bannerDao->read();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/banner.css">
</head>

<body>
    <?php require_once 'partials/header_painel.php' ?>

    <!-- Botão para mostrar/ocultar o formulário de adição de banner -->
    <div class="action">
        <button id="showFormButton">Adicionar Banner</button>
    </div>

    <!-- Formulário para adicionar banner -->
    <div class="insert_banner">
        <form action="banner_action.php" method="post" enctype="multipart/form-data">
            <img id="imagemPreview" alt="Prévia da Imagem"><br>
            <input id="imagemInput" type="file" name="banner">
            <button>enviar</button>
        </form>
    </div>

    <!-- Seção para exibir os banners existentes -->
    <section class="block_banner">
        <?php foreach ($banner as $banner_view) : ?>
            <div class="banner">
                <!-- Link para excluir o banner com base no ID -->
                <a href="delete_banner.php?id=<?= $banner_view->id ?>">Delete</a>
                <!-- Exibe a imagem do banner -->
                <img src="assets/banners/<?= $banner_view->banner ?>" alt="">
            </div>
        <?php endforeach; ?>
    </section>

    <!-- Script para mostrar/ocultar o formulário -->
    <script>
        var formVisible = false;

        document.getElementById('showFormButton').addEventListener('click', function() {
            // Alterna a visibilidade do formulário
            formVisible = !formVisible;

            // Define o estilo do formulário com base no estado atual
            document.querySelector('.insert_banner').style.display = formVisible ? 'flex' : 'none';
        });
    </script>

    <!-- Script para exibir a imagem selecionada antes do envio -->
    <script>
        document.getElementById('imagemInput').addEventListener('change', function(event) {
            const input = event.target;
            const preview = document.getElementById('imagemPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
</body>

</html>
