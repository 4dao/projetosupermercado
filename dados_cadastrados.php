<?php
require_once 'config.php';
require_once 'models/auth.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$userInfo = $auth->checkTokenAndAccess($nivel = 'user');

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $base ?>/assets/dados_cadastrados.css">
    <title>Dados Cadastrados</title>
</head>
<body>
<?php require 'partials/header.php' ?>

    <div id="container">
    <?php require 'partials/painel_user.php' ?>
        <div id="content">

            <div id="profile-info">
                <form action="<?= $base ?>/editar_user.php" method="post" id="user-form">
                    <label for="nome">Nome:</label>
                    <input value="<?= $userInfo->nome ?>" type="text" id="nome" name="nome" required>

                    <label for="cpf">CPF:</label>
                    <input value="<?= $userInfo->cpf ?>" type="text" id="cpf" name="cpf" required>

                    <label for="telefone">Telefone:</label>
                    <input value="<?= $userInfo->telefone ?>" type="text" id="telefone" name="telefone" required>

                    <label for="endereco">Endereço:</label>
                    <input value="<?= $userInfo->endereco ?>" type="text" id="endereco" name="endereco" >

                    <label for="bairro">Bairro:</label>
                    <input value="<?= $userInfo->bairro ?>" type="text" id="bairro" name="bairro" >

                    <label for="numero">Número:</label>
                    <input value="<?= $userInfo->numero ?>" type="text" id="numero" name="numero" >

                    <label for="referencia">Referência:</label>
                    <input value="<?= $userInfo->referencia ?>" type="text" id="referencia" name="referencia">

                    <input value="<?= $userInfo->id?>" type="hidden" id="id" name="id">
                    <input value="<?= $userInfo->nivel?>" type="hidden" id="nivel" name="nivel">



                    <button type="submit">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
