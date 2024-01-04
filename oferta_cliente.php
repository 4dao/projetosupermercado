<?php
require_once 'config.php';
require_once 'dao/ProdutoDaoMysql.php';
require_once 'models/auth.php';


$auth = new Auth($pdo, $base);
$userInfo = $auth->checkTokenAndAccess($nivel = null);
$produtoDao = new ProdutoDaoMysql($pdo);
$produtooferta = $produtoDao->readpromocao();

$veryid = ($userInfo) ? $userInfo->id : '';



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Título Aqui</title>
</head>

<body>

    <!-- header(cabeçalho da pagina) -->
    <?php require 'partials/header.php' ?>

    <!-- categoria -->
    <?php require 'partials/header-option.php' ?>

    <!-- contagem de itens no carrinho  -->
    <?php if ($userInfo && $userInfo->nivel == 'user') : ?>
        <div id="pedidos-section">
            <?php require 'contagem-item-carrinho.php' ?>
        </div>
    <?php endif; ?>

    <div class="produto-content">

        <nav class="product">

            <?php foreach ($produtooferta as $produtos) : ?>
                <?php $buttonStyle = ($produtos->promocao > 0) ? 'background-color: red;' : ''; ?>
                <?php $ofertaStyle = ($produtos->promocao > 0) ? 'background-color: red; font-size:10px;' : ''; ?>
                <?php $precoStyle = ($produtos->promocao > 0) ? 'background-color: red;' : ''; ?>

                <div title="<?= $produtos->nome ?>" class="product-block">
                    <img src="<?= $base ?>/assets/imagem_produto/<?= $produtos->imagem ?>" alt="Nome do Produto">
                    <div class="preco">
                        <?php if ($produtos->valorpromocao) : ?>
                            <h3 style="<?= $ofertaStyle ?>">R$<?= $produtos->valorpromocao ?> uni.</h3>
                        <?php endif; ?>
                        <h3 style="<?= $precoStyle ?>">R$<?= $produtos->preco ?> uni.</h3>
                    </div>
                    <p><?= $produtos->descricao ?></p>
                    <div class="actions">
                        <form class="form">
                            <button type="submit" class="buy-button" style="<?= $buttonStyle ?>">Comprar</button>
                            <input type="number" class="quantity-input" value="1" max="<?= $produtos->estoque ?>" min="1" step="1" name="quantidade">
                            <input type="hidden" value="<?= $produtos->id ?>" name="id_produto">
                            <input type="hidden" value="<?= $veryid ?>" name="id_user">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </nav>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/javascript/ajax-compra.js"></script>
</body>

</html>