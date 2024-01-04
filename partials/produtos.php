<?php
require_once 'config.php';
require_once 'dao/ProdutoDaoMysql.php';

$produtoDao = new ProdutoDaoMysql($pdo);

$produto = $produtoDao->read();


$veryid = ($userInfo) ? $userInfo->id : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


<body>

    <nav class="product">
        <?php foreach ($produto as $produtos) : ?>
            <?php $buttonStyle = ($produtos->promocao > 0) ? 'background-color: red;' : ''; ?>
            <?php $ofertaStyle = ($produtos->promocao > 0) ? 'background-color: red; font-size:10px;' : ''; ?>
            <?php $precoStyle = ($produtos->promocao > 0) ? 'background-color: red;' : ''; ?>

            <div class="product-block">
                <img src="assets/imagem_produto/<?= $produtos->imagem ?>" alt="Nome do Produto">
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

</body>


</html>