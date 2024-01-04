<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerim Supermercados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="assets/styles.css">
    <style>
    </style>
</head>

<body>

    <!-- header(cabeçalho da pagina) -->
    <?php require 'partials/header.php' ?>

    <!-- categoria -->
    <?php require 'partials/header-option.php' ?>

    <!-- carrossel de banners -->
    <section class="banner">
        <?php require_once 'partials/banner.php' ?>
    </section>

    <?php if ($userInfo && $userInfo->nivel == 'user') : ?>
        <?php require_once 'partials/compra-usuario.php' ?>
    <?php endif; ?>
    
    <!-- contagem de itens no carrinho  -->
    <?php if ($userInfo && $userInfo->nivel == 'user') : ?>
        <div id="pedidos-section">
            <?php require 'contagem-item-carrinho.php' ?>
        </div>
    <?php endif; ?>

    <!-- produtos -->
    <section class="main">
        <?php if ($userInfo && $userInfo->nivel == 'user') : ?>
            <div id="carrinho">
                <?php require_once 'carrinho_cliente.php' ?>
            </div>
        <?php endif; ?>

        <?php require 'partials/produtos.php' ?>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/javascript/carrinho.js"></script>
    <script src="assets/javascript/ajax-compra.js"></script>
</body>

</html>