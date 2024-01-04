<?php
require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/ContatoDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$userInfo = $auth->checkTokenAndAccess($nivel = 'user');

$ContatoDao = new ContatoDaoMysql($pdo, $base);

$contatos = $ContatoDao->readUser($userInfo->id);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $base ?>/assets/reclamaçoes.css">
    <title>Enviar Reclamação</title>
</head>

<body>
    <?php require 'partials/header.php' ?>

    <div id="container">
        <?php require 'partials/painel_user.php' ?>

        <div id="content">
            <div id="complaint-form">
                <h2>Enviar Reclamação</h2>
                <form action="<?= $base ?>/reclamacao_action.php" method="post">
                    <label for="nome">Nome:</label>
                    <input value="<?= $userInfo->nome ?>" type="text" id="nome" name="nome" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="reclamacao">Reclamação:</label>
                    <textarea id="reclamacao" name="mensagem" rows="4" required></textarea>

                    <!-- Campos ocultos para CPF e ID -->
                    <input type="hidden" name="cpf" value="<?= $userInfo->cpf ?>">
                    <input type="hidden" name="id_user" value="<?= $userInfo->id ?>">

                    <button type="submit">Enviar Reclamação</button>
                </form>
            </div>

            <table>
                <h2>Último contato</h2>

                <thead>
                    <tr>
                        <th>NOME</th>
                        <th>CPF</th>
                        <th>EMAIL</th>
                        <th>MENSAGEM</th>
                    </tr>
                </thead>
                <?php foreach ($contatos as $recla) : ?>
                    <tbody>
                        <tr>
                            <td><?= $recla->nome ?></td>
                            <td><?= $recla->cpf ?></td>
                            <td><?= $recla->email ?></td>
                            <td><?= $recla->mensagem ?></td>
                        </tr>
                        <!-- Adicione mais linhas conforme necessário -->
                    </tbody>
                <?php
                    break; // Interrompe o loop após exibir a primeira reclamação
                endforeach; ?>
            </table>

        </div>

    </div>
</body>

</html>