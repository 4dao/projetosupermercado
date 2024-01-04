<?php
require_once 'config.php';
require_once 'models/auth.php';
require_once 'models/conexao.php';

$auth = new Auth($pdo, $base);

$userInfo = $auth->checkTokenAndAccess($nivel = null);

$urlbase = "https://gold-anemone-wig.cyclic.app/receitas";
$conexao = new ConexaoAPI($urlbase);


$ponte = $conexao->conexao("/todas");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= $base ?>/assets/receitas.css">
</head>

<body>

    <!-- header(cabeçalho da pagina) -->
    <?php require 'partials/header.php' ?>

    <!-- categoria -->
    <?php require 'partials/header-option.php' ?>


    <h1>RECEITAS DOCE</h1>
    <section class="contente">
        <?php foreach ($ponte as $receitas) : ?>
            <?php if ($receitas->tipo == 'doce') : ?>
                <a href="<?= $base ?>/receitas-ingredientes.php?id=<?= $receitas->id ?>">
                    <div class="receita">
                        <div id="imagem">
                            <img src="<?= $receitas->link_imagem ?>" alt="">
                        </div>
                        <p id="nome"><?= $receitas->receita ?></p>
                    </div>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </section>


    <h1>RECEITAS SALGADA</h1>
    <section class="contente">
        <?php foreach ($ponte as $receitas) : ?>
            <?php if ($receitas->tipo == 'salgado') : ?>
                <a href="<?= $base ?>/receitas-ingredientes.php?id=<?= $receitas->id ?>">
                    <div class="receita">
                        <div id="imagem">
                            <img src="<?= $receitas->link_imagem ?>" alt="">
                        </div>
                        <p id="nome"><?= $receitas->receita ?></p>
                    </div>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </section>


    <h1>RECEITAS AGRIDOCECE</h1>
    <section class="contente">
        <?php foreach ($ponte as $receitas) : ?>
            <?php if ($receitas->tipo == 'agridoce') : ?>
                <a href="<?= $base ?>/receitas-ingredientes.php?id=<?= $receitas->id ?>">
                    <div class="receita">
                        <div id="imagem">
                            <img src="<?= $receitas->link_imagem ?>" alt="">
                        </div>
                        <p id="nome"><?= $receitas->receita ?></p>
                    </div>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </section>

</body>

</html>