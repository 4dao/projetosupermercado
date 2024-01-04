<?php
require_once 'models/conexao.php';

$urlBase = "https://gold-anemone-wig.cyclic.app";
$conexao = new ConexaoAPI($urlBase);

$idReceita = filter_input(INPUT_GET, 'id');

// Validar e filtrar o ID para evitar SQL injection
$idReceita = filter_var($idReceita, FILTER_VALIDATE_INT);

// Adicionar tratamento de erro
try {
    $ponte = $conexao->conexaoPorId($idReceita);
} catch (Exception $e) {
    echo "Erro ao obter a receita: " . $e->getMessage();
    // Considere adicionar um redirecionamento ou outra ação apropriada em caso de erro.
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($ponte->receita) ?></title>
    <link rel="stylesheet" href="assets/receitas.css">
</head>

<body>
    <!-- header(cabeçalho da pagina) -->
    <?php require 'partials/header.php' ?>

    <div class="receita-container">
        <div class="receita-header">
            <h1><?= htmlspecialchars($ponte->receita) ?></h1>
            <img src="<?= htmlspecialchars($ponte->link_imagem) ?>" alt="<?= htmlspecialchars($ponte->receita) ?>">
        </div>
        <div class="receita-content">
            <h2>Ingredientes</h2>
            <p><?= htmlspecialchars($ponte->ingredientes) ?></p>

            <h2>Modo de Preparo</h2>
            <p><?= htmlspecialchars($ponte->modo_preparo) ?></p>
        </div>
    </div>
</body>

</html>
