<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/ProdutoDaoMysql.php';


$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$produtoDao = new ProdutoDaoMysql($pdo);

$produto = $produtoDao->readadmin();
$produtooferta = $produtoDao->readpromocao();


$quant = count($produto);

$quantoferta = count($produtooferta);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Painel</title>
    <link rel="stylesheet" href="assets/produtos_cadastrados.css">
</head>

<body>
    <?php require "partials/header_painel.php" ?>

    <?php
    // Verifica se a variável de sessão 'produto_cadastrado' está definida
    if (isset($_SESSION['produto_cadastrado'])) {
        // Exibe a mensagem de erro dentro de uma div com a classe 'error-message'
        echo '<div class="error-message"><p>' . $_SESSION['produto_cadastrado'] . '</p></div>';

        // Remove a mensagem de erro da sessão para evitar exibi-la novamente
        unset($_SESSION['produto_cadastrado']);
    }
    ?>


    <section class="head">
        <p>Quant. produtos:<?= $quant ?></p>
        <p>Quant. Ofertas:<?= $quantoferta ?></p>
        <button id="toggleForm">Adicionar Produto</button>
    </section>


    <!-- cadastrar produtos -->
    <?php require_once 'partials/cadastrar_produto.php' ?>

    <!-- produtos -->

    <nav class="product">
        <?php foreach ($produto as $produtos) : ?>
            <?php
            // Define estilos condicionais com base na presença de uma promoção
            $buttonStyle = ($produtos->promocao > 0) ? 'background-color: red;' : '';
            $ofertaStyle = ($produtos->promocao > 0) ? 'background-color: red; font-size:10px;' : '';
            $precoStyle = ($produtos->promocao > 0) ? 'background-color: red;' : '';
            ?>

            <div class="product-block">
                <img src="assets/imagem_produto/<?= $produtos->imagem ?>" alt="Nome do Produto">

                <?php if ($produtos->valorpromocao) : ?>
                    <!-- Exibe o preço em promoção se houver -->
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
                    <!-- Links para editar e excluir produtos -->
                    <a class="buy-button" href="editar_produto.php?id=<?= $produtos->id ?>">editar</a>
                    <input type="number" class="quantity-input" value="<?= $produtos->estoque ?>" min="1">
                    <a class="buy-button" href="delete_produto.php?id=<?= $produtos->id ?>">deletar</a>
                </div>
            </div>
        <?php endforeach; ?>
    </nav>


    <script src="assets/javascript/pradutos_cadastrados.js"></script>
</body>

</html>