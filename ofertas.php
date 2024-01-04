<?php
require_once 'config.php';
require_once 'dao/ProdutoDaoMysql.php';

$produtoDao = new ProdutoDaoMysql($pdo);

$produto = $produtoDao->readpromocao();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/produtos_cadastrados.css">

<body>
    <?php require 'partials/header_painel.php' ?>

    <nav class="product">
        <?php foreach ($produto as $produtos) : ?>
            <?php $buttonStyle = ($produtos->promocao > 0) ? 'background-color: red;' : ''; ?>
            <?php $ofertaStyle = ($produtos->promocao > 0) ? 'background-color: red; font-size:10px;' : ''; ?>
            <?php $precoStyle = ($produtos->promocao > 0) ? 'background-color: red;' : ''; ?>

            <div class="product-block">
                <img src="assets/imagem_produto/<?= $produtos->imagem ?>" alt="Nome do Produto">

                <?php if ($produtos->valorpromocao) : ?>
                    <h3 style="<?= $ofertaStyle ?>">R$<?= $produtos->valorpromocao ?> uni.</h3>
                <?php endif; ?>
                <h3 id="preco" style="<?= $precoStyle ?>">R$<?= $produtos->preco ?> uni.</h3>

                <h3><?= $produtos->nome ?></h3>
                <h3>[<?= $produtos->categoria ?>]</h3>

                <p>
                    <?= $produtos->descricao ?><br><br>
                    [<?= $produtos->data ?>]
                </p>

                <div class="actions">
                    <a class="buy-button" href="editar_produto.php?id=<?= $produtos->id ?>">editar</a>
                    <input type="number" class="quantity-input" value="<?= $produtos->estoque ?>" min="1">
                    <a class="buy-button" href="delete_produto.php?id=<?= $produtos->id ?>">deletar</a>
                </div>
            </div>
        <?php endforeach; ?>
    </nav>
</body>

</html>