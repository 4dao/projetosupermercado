<?php
require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/ProdutoDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkTokenAndAccess($nivel = null);
$exibicao = $auth->exibicao();
$produtoDao = new ProdutoDaoMysql($pdo);
$produto = $produtoDao->read();

$cadastro = 'cadastro';
$perfil = 'perfil';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $base ?>/assets/styles.css">
    <title>Sua Página</title>
</head>

<body>
    <header>
        <div class="logo">
            <a title="Supermercado gerim" href="<?= $base ?>"><img src="<?= $base ?>/assets/imagem/logo.png" alt="Gerim Logo"></a>
        </div>

        <!-- Adicione o formulário de pesquisa -->
        <form action="<?= $base ?>" method="get" class="search-area">
            <h1 style="color: #2d7b51;">TUDO DE BOM PRA VOCÊ!</h1>
        </form>

        <div class="signup-link">
            <?php if ($userInfo) : ?>
                <a title="Perfil" href="<?= $base ?>/perfil.php">Perfil</a>
            <?php else : ?>
                <a title="Cadastro/login" href="<?= $base ?>/login/">Cadastro</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Restante do seu conteúdo HTML aqui -->

</body>

</html>
