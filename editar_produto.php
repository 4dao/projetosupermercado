<?php
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/ProdutoDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$produtoDao = new ProdutoDaoMysql($pdo);

$id = filter_input(INPUT_GET, 'id');

if ($id) {
    $produtos = $produtoDao->findbyid($id);
}

$promocaoChecked = ($produtos->promocao == 1) ? 'checked' : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="assets/produtos_cadastrados.css">
</head>

<body>
    <?php require "partials/header_painel.php" ?>

    <div class="contente-editar">
        <form action="editar_produto_action.php?id=<?= $produtos->id ?>" method="post" enctype="multipart/form-data" required>

            <img src="assets/imagem_produto/<?= $produtos->imagem ?>" id="imagemPreview" alt="Prévia da Imagem" style="max-width: 300px; max-height: 300px; object-fit: cover;">

            <label for="nome">Título:</label>
            <input value="<?= $produtos->nome ?>" type="text" name="nome" required autofocus>

            <label for="descricao">Descrição:</label>
            <input value="<?= $produtos->descricao ?>" type="text" name="descricao" required>

            <label for="categoria">Categoria:</label>
            <select name="categoria" id="" required>
                <option value="<?= $produtos->categoria ?>"><?= $produtos->categoria ?></option>
                <option value="hortifruti">Hortifruti</option>
                <option value="padaria">Padaria</option>
                <option value="frios e laticínios">Frios e Laticínios</option>
                <option value="congelados">Congelados</option>
                <option value="bebidas não alcoólicas">Bebidas não Alcoólicas</option>
                <option value="bebidas alcoólicas">Bebidas Alcoólicas</option>
                <option value="mercearia">Mercearia</option>
                <option value="perfumaria e higiene">Perfumaria e higiene</option>
                <option value="limpeza">Limpeza</option>
                <option value="animais">Animais</option>
                <option value="descartaveis e festa">Descartaveis e Festa</option>
            </select>

            <label for="promocao">Oferta?</label>
            <input type="checkbox" value="1" <?= $promocaoChecked ?> name="promocao" id="promocaoCheckbox">

            <!-- Campo de input para preço da oferta -->
            <div id="precoOfertaContainer">
                <input value="<?= $produtos->valorpromocao ?>" type="text" placeholder="DE:valor real" name="valorpromocao" id="precoOferta">
            </div>

            <label for="preco">Preço Ofertado:</label>
            <input value="<?= $produtos->preco ?>" type="text" name="preco" required>

            <label for="estoque">Quant. Estoque:</label>
            <input value="<?= $produtos->estoque ?>" type="text" name="estoque" required>

            <button>Atualizar Produto</button>

        </form>
    </div>
</body>

</html>